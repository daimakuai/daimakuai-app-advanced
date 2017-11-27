<?php
/**
 * Create by HappyOnion
 * author: yt
 * Customer.php 上午12:09
 * Date: 2017/5/16  Time: 上午12:09
 */

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'customer';

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}