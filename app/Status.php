<?php
/**
 * Created by PhpStorm.
 * User: winwi
 * Date: 1/31/2020
 * Time: 8:42 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = 'statuses';

    protected $fillable = ['name', 'title'];

    public $timestamps = false;

    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_PENDING = 'pending';

    public static function id(string $name): int {
        return self::query()->where('name', $name)->first()->id ?? 0;
    }

    public static function name(int $id): string
    {
        return self::query()->find($id)->name ?? '';
    }
}
