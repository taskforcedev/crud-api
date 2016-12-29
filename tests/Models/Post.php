<?php

namespace Test\Models;

class Post
{
    public $fillable = [
        'title', 'body', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo('Test\Models\User');
    }
}