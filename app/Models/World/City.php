<?php
/**
 * Create by HappyOnion
 * author: yt
 * City.php 下午9:40
 * Date: 2017/5/14  Time: 下午9:40
 */

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'ID';

    protected $connection = 'world';

    protected $table = 'city';

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'Code');
    }

    public static function options($id)
    {
        return static::where('ID', $id)->get()->map(function ($city) {

            return [$city->ID => $city->Name];

        })->flatten();
    }
}