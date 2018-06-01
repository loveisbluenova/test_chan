<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Cviebrock\EloquentTaggable\Taggable;


class Blog extends Model{

    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Taggable;
    

    protected $dates = ['deleted_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $table = 'blogs';

    protected $guarded  = ['id'];

    protected $casts = [ 'featured' => 'boolean'];

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getBlogcategoryAttribute()
    {
        return $this->category->pluck('id');
    }
}
