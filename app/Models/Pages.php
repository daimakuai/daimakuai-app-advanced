<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Traits\AdminBuilder;


class Pages extends Model
{
    use  AdminBuilder;

    protected $table = 'demo_pages';

    public static function grid($callback)
    {
        return new Grid(new static, $callback);
    }

    public static function form($callback)
    {
        return new Form(new static, $callback);
    }



}
