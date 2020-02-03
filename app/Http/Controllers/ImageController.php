<?php


namespace App\Http\Controllers;


use App\Image;
use App\Services\ImageCreator;
use Illuminate\Http\Request;

class ImageController
{
    public function index()
    {
        return view('image/create');
    }

    public function create(ImageCreator $imageCreator, Request $request)
    {
        $id = $request->post('id');

        $result = $imageCreator->create(Image::query()->findOrFail($id));

        return ['url' => asset($result['path'])];
    }


}
