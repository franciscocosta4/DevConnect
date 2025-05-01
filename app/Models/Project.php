<?php

// app/Models/Project.php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'visibility', 'zip_file_path', 'slug',
    ];

    // Gerar slug automaticamente
    protected static function booted()
    {
        static::creating(function ($project) {
            $project->slug = Str::slug($project->title);
        });

        static::updating(function ($project) {
            $project->slug = Str::slug($project->title);
        });
    }

    // Relacionamento com o utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
