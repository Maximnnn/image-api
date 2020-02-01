<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],

            'rectangles.*.id' => 'required|distinct|string|max:255|min:1',
            'rectangles.*.x' => 'required|int|min:0',
            'rectangles.*.y' => 'required|int|min:0',
            'rectangles.*.width' => 'required|int|min:0',
            'rectangles.*.height' => 'required|int|min:0',
            'rectangles.*.color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'rectangles.*.customId' => 'required|string|min:1|max:255'
        ];
    }


    protected function buildResponse(Validator $validator)
    {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()->all(),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, $this->buildResponse($validator)));
    }
}
