<?php
/**
 * Create by HappyOnion
 * author: yt
 * Staff.php 上午12:23
 * Date: 2017/5/16  Time: 上午12:23
 */
namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'staff';

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}