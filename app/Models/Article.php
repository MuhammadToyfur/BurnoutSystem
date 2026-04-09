<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'judul', 'slug', 'konten', 'kategori', 'thumbnail', 'published', 'author_id', 'source_name', 'source_url',
    ];

    protected $casts = ['published' => 'boolean'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getExcerptAttribute(): string
    {
        return \Str::limit(strip_tags($this->konten), 150);
    }
}
