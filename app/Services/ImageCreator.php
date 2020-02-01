<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:41 PM
 */

namespace App\Services;


use App\Image;
use App\ImageParameters;
use App\Rectangle;
use App\Status;
use Illuminate\Support\Facades\DB;

class ImageCreator
{
    /**
     * @var ImageValidator
     */
    private $imageValidator;

    public function __construct(ImageValidator $imageValidator)
    {
        $this->imageValidator = $imageValidator;
    }

    public function addToQueue(array $imageArr, array $rectangles): Image
    {
        $rectangles = $this->mapRectangles($rectangles);

        $image = new Image($imageArr);
        $image->status = Status::id(Status::STATUS_PENDING);

        $imageParams = new ImageParameters($imageArr);

        $this->imageValidator->validateRectangles($imageParams, $rectangles);

        $this->save($image, $imageParams, $rectangles);

        return $image;
    }

    private function save(Image $image, ImageParameters $parameters, array $rectangles): Image
    {
        DB::transaction(function() use ($image, $parameters, $rectangles) {
            $image->save();

            $image->parameters()->save($parameters);

            $image->rectangles()->saveMany($rectangles);
        });

        return $image;
    }

    private function mapRectangles(array $rectangles): array
    {
        return array_map(function(array $rectangle) {
            return new Rectangle($rectangle);
        }, $rectangles);
    }

    public function create(Image $image): Image
    {
        try {
            $image->status = Status::id(Status::STATUS_IN_PROGRESS);
            $image->save();

            $resource = $this->imageCreate($image);

            $name = $this->saveToStorage($image, $resource);

            $image->path   = 'storage/' . $name;
            $image->status = Status::id(Status::STATUS_DONE);
            $image->save();


        } catch (\Throwable $exception) {
            $image->status = Status::id(Status::STATUS_FAILED);
            $image->save();
        }
        return $image;
    }

    private function saveToStorage(Image $image, $resource): string
    {
        $name = $image->id . '.png';
        $path = storage_path('app/public/' . $name);
        imagepng($resource, $path);

        return $name;
    }

    /**
     * @param Image $image
     * @return false|resource
     */
    private function imageCreate(Image $image)
    {
        /**@var $params ImageParameters*/
        $params = $image->parameters()->first();
        $rectangles = $image->rectangles()->get();

        $im = imagecreate($params->width, $params->height);

        list($r, $g, $b) = $this->parseHexColor($params->color);
        imagecolorallocate($im, $r, $g, $b);

        $rectangles->each(function(Rectangle $rectangle) use ($im) {

            list($r, $g, $b) = $this->parseHexColor($rectangle->color);

            $colorAllocate = ImageColorAllocate($im, $r, $g, $b);
            ImageFilledRectangle(
                $im,
                $rectangle->x, $rectangle->y, $rectangle->x + $rectangle->width, $rectangle->y + $rectangle->height,
                $colorAllocate
            );

        });

        return $im;
    }

    private function parseHexColor(string $hex): array
    {
        return sscanf($hex, "#%02x%02x%02x");
    }
}
