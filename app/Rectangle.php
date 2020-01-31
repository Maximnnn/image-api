<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:43 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Rectangle extends Model
{
    public $table = 'rectangles';

    protected $fillable = ['width', 'height', 'x', 'y', 'color', 'customId', 'imageId'];

    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo(Image::class, 'id', 'imageId');
    }

}
