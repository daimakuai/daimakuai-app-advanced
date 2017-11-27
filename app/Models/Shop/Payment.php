<?php
/**
 * Create by HappyOnion
 * author: yt
 * Payment.php 下午9:02
 * Date: 2017/5/16  Time: 下午9:02
 */

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //protected $connection = 'sakila';

    protected $table = 'payment';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}