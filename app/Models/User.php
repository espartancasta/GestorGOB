<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Str;

// MODELOS
use App\Models\Post;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Submission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Roles del sistema
     */
    public const IS_VISITOR = 1;
    public const IS_AUTHOR = 2;
    public const IS_ADMIN = 3;

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'profile',
        'about',
        'role',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
        'status',
        'password',
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    /**
     * Mutator para username (siempre minúsculas)
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value)
        );
    }

    /**
     * Relaciones existentes
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * 🔥 RELACIÓN CLAVE SEMANA 6
     * Un usuario (autor) puede tener muchos submissions
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'author_id');
    }
}