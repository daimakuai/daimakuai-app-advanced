<?php
/**
 * Create by HappyOnion
 * author: yt
 * Store.php 上午12:19
 * Date: 2017/5/16  Time: 上午12:19
 */

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'store';

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id');
    }
}