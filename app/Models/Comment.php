<?php
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'user_id', 'content', 'parent_id',
    ];

    // Relacionamento com o post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relacionamento com o utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
{
    return $this->belongsTo(Comment::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Comment::class, 'parent_id')->latest();
}

}
