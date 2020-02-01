<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:43 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $width
 * @property int $height
 * @property int $x
 * @property int $y
 * @property string $color
 * @property string $customId
 * @property int $imageId
*/
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
