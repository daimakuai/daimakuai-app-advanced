<?php
/**
 * Create by HappyOnion
 * author: yt
 * Language.php 下午9:41
 * Date: 2017/5/14  Time: 下午9:41
 */

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $connection = 'world';

    protected $table = 'countrylanguage';

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'Code');
    }
}