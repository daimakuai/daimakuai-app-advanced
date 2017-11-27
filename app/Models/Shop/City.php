<?php
/**
 * Create by HappyOnion
 * author: yt
 * City.php 下午11:27
 * Date: 2017/5/15  Time: 下午11:27
 */

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'city';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}