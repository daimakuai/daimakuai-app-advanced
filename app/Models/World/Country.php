<?php
/**
 * Create by HappyOnion
 * author: yt
 * Country.php 下午9:41
 * Date: 2017/5/14  Time: 下午9:41
 */

namespace App\Models\World;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'Code';

    protected $keyType = 'string';

    protected $connection = 'world';

    protected $table = 'country';

    public $timestamps = false;

    public static $continents = ['Asia','Europe','North America','Africa','Oceania','Antarctica','South America'];

    public function city()
    {
        return $this->belongsTo(City::class, 'Capital', 'ID');
    }

    public static function options($id)
    {
        return static::where('Code', $id)->get()->map(function ($country) {

            return [$country->Code => $country->Name];

        })->flatten();
    }
}