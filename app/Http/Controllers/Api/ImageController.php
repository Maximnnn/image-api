<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/30/2020
 * Time: 10:17 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Image;
use App\Services\ImageCreator;
use App\Status;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{

    public function create(StoreImageRequest $request, ImageCreator $imageCreator)
    {
        $imageArr = array_diff_key($request->validated(), ['rectangles']);

        $image = $imageCreator->addToQueue($imageArr, $request->validated()['rectangles']);

        return [
            'success' => true,
            'id'      => $image->id
        ];
    }

    public function get(Image $image)
    {
        $status = $image->status()->name;

        $response['status'] = $status;

        switch ($status) {
            case Status::STATUS_PENDING:
                $response['queue_length'] = Image::query()
                    ->where('status', Status::id(Status::STATUS_PENDING))
                    ->where('id', '<', $image->id)
                    ->count();
                break;
            case Status::STATUS_DONE:
                $response['url'] = asset($image->path);
                break;
            case Status::STATUS_FAILED:
                $response['reason'] = 'not implemented';
                break;
            case Status::STATUS_IN_PROGRESS:
                break;
        };


        return $response;
    }

}
