<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticiaFavorita extends Model
{
    protected $table = 'favourite_news';
    protected $fillable = ['user_id', 'story_id', 'title', 'url'];
}
