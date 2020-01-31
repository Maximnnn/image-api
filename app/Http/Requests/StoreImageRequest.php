<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'width' => 'required|int|min:640|max:1920',
            'height' => 'required|int|min:480|max:1080',
            'color' => 'required|string',//todo hex color
            'rectangles.*.id' => 'required|distinct|string|max:255|min:1',
            'rectangles.*.x' => 'required|int',
            'rectangles.*.y' => 'required|int',
            'rectangles.*.width' => 'required|int',
            'rectangles.*.height' => 'required|int',
            'rectangles.*.color' => 'required|string', //todo
            'rectangles.*.customId' => 'required|string|min:1|max:255'
        ];
    }
}
