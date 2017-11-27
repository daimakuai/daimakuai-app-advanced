<?php
/**
 * Create by HappyOnion
 * author: yt
 * Address.php 下午11:14
 * Date: 2017/5/15  Time: 下午11:14
 */

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'address';

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public static function options($id)
    {
        return static::where('id', $id)->get()->map(function ($address) {

            return [$address->id => $address->address];

        })->flatten();
    }
}