<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:42 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $status
 * @property string $path
 */
class Image extends Model
{
    public $table = 'images';

    protected $fillable = ['status', 'url'];

    public function parameters()
    {
        return $this->hasOne(ImageParameters::class, 'imageId', 'id');
    }

    public function rectangles()
    {
        return $this->hasMany(Rectangle::class, 'imageId', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status')->first();
    }
}
