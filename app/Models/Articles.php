<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Traits\AdminBuilder;


class Articles extends Model implements Sortable
{
    use SortableTrait,SoftDeletes, AdminBuilder;

    protected $table = 'demo_articles';

    protected $casts = [
        'extra' => 'json',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public static function grid($callback)
    {
        return new Grid(new static, $callback);
    }

    public static function form($callback)
    {
        return new Form(new static, $callback);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'demo_taggables');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function scopeHot($query)
    {
        return $query->where('rate', '>', 1);
    }

    public function scopeReleased($query)
    {
        return $query->where('released', 1);
    }

    public function scopeUnreleased($query)
    {
        return $query->where('released', 0);
    }

}
