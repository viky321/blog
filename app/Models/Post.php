<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "text", "slug" ];

    protected $appends = ["teaser", "datetime"];


    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function tags()
    {
        return $this->belongsToMany("App\Models\Tag");
    }

    public function getDateTimeAttribute()
    {
        return date("Y-m-d", strtotime($this->created_at));
    }

    public function getCreatedAtAttribute($value)
    {
        return date(" j M Y, G:i ", strtotime($value));
    }

    public function getTeaserAttribute()
    {
        return Str::limit($this->text, 300);
    }

    public function getRichTextAttribute()
    {
        return add_paragraphs( filter_url( e($this->text)));
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });

    }

    public function setTitleAttribute($value)
    {
        $this->attributes["title"] = ucfirst($value);
        $this->attributes["slug"] = Str::slug($value);
    }

    public function cachedPosts()
    {
        return Cache::remember('cached_posts', 600, function () {
            return $this->all(); // ulozi vsetky prispevky do cachce na 10 min
        });
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

        public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
