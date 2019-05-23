<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public function scopeBookCount(){
        return $this->first()->nbBook;
    }

    public function scopeAuthorCount(){
        return $this->first()->nbAuthor;
    }
    public function scopeBestNote(){
        return $this->first()->bestNote;
    }
}
