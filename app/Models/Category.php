<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Jblv\Admin\Traits\AdminBuilder;
use Jblv\Admin\Traits\ModelTree;

class Category extends Model
{
     use ModelTree, AdminBuilder;

    protected $table = 'category';

//    public $sortable = [
//        'order_column_name' => 'order',
//        'sort_when_creating' => true,
//    ];
}
