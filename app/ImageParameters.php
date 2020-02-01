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
 * @property int imageId
 * @property int width
 * @property int height
 * @property string $color
 */
class ImageParameters extends Model
{
    public $table = 'imageParameters';

    protected $fillable = ['imageId', 'width', 'height', 'color'];

    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo(Image::class, 'imageId', 'id');
    }
}
