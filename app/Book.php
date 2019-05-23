<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'genre_id', 'status'
    ];

    public function setGenreIdAttribute($value)
    {
        $this->attributes['genre_id'] = ($value == 0) ? null : $value;
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class)->withPivot('note');
    }

    public function picture()
    {
        return $this->hasOne(Picture::class);
    }

    public function note()
    {
        $toto = $this->authors();

        return $toto;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function isGenre(int $genreId): bool
    {
        if (is_null($this->genre)) return false;

        return $this->genre->id === $genreId;
    }

    public function isAuthor(int $authorId): bool
    {
        if (is_null($this->authors)) return false;

        foreach ($this->authors as $author) {
            if ($author->id == $authorId) return true;
        }
        return false;
    }
}
