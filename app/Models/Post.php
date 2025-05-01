<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'content',
    ];

    // Relacionamento com o utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com os comentários
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
