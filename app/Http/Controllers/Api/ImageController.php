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
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{

    public function create(StoreImageRequest $request, ImageCreator $imageCreator)
    {
        $imageArr = array_diff_key($request->validated(), ['rectangles']);

        $image = $imageCreator->prepare($imageArr, $request->validated()['rectangles']);

        return [
            'success' => true,
            'id'      => $image->id
        ];
    }

    public function get()
    {
        return Image::query();
    }

}
