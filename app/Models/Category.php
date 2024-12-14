<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //region model config
    use SoftDeletes;

    protected $table = 'categories';
    protected $fillable = ['name', 'ename', 'search_url', 'parent_id', 'img', 'notShow', 'url'];

    //endregion

    protected static function boot()
    {
        parent::boot();


    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    //endregion
}
