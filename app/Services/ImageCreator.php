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

    public function prepare(array $imageArr, array $rectangles): Image
    {
        $rectangles = $this->mapRectangles($rectangles);

        $this->imageValidator->validateRectangles($rectangles);

        $image = new Image($imageArr);
        $image->status = Status::id(Status::STATUS_PENDING);

        $imageParams = new ImageParameters($imageArr);

        $this->save($image, $imageParams, $rectangles);

        return $image;
    }

    private function save(Image $image, ImageParameters $parameters, array $rectangles)
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

            //todo

            $image->status = Status::id(Status::STATUS_DONE);
            $image->save();


        } catch (\Throwable $exception) {
            $image->status = Status::id(Status::STATUS_FAILED);
            $image->save();
        }
        return $image;
    }
}
