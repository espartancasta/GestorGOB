<?php

namespace App\Models;

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
     * 🔥 ROLES DEL SISTEMA (OFICIAL)
     */
    public const ROLE_AUTHOR = 1;
    public const ROLE_REVIEWER = 2;
    public const ROLE_SECRETARY = 3;
    public const ROLE_DICOVI = 4;

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'sex',
        'age',
        'institution',
        'department',
        'curp',
        'rfc',
        'location',
        'profile',
        'about',
        'specialty',
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
     * Username siempre minúsculas
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value)
        );
    }

    /**
     * 🔥 NOMBRE DEL ROL (PARA VISTAS)
     */
    public function getRoleNameAttribute()
    {
        return match ($this->role) {
            self::ROLE_AUTHOR => 'Autor',
            self::ROLE_REVIEWER => 'Revisor',
            self::ROLE_SECRETARY => 'Secretario',
            self::ROLE_DICOVI => 'DICOVI',
            default => 'Desconocido',
        };
    }

    /**
     * 🔐 HELPERS DE PERMISOS
     */
    public function isAuthor()
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    public function isReviewer()
    {
        return $this->role === self::ROLE_REVIEWER;
    }

    public function isSecretary()
    {
        return $this->role === self::ROLE_SECRETARY;
    }

    public function isDicovi()
    {
        return $this->role === self::ROLE_DICOVI;
    }

    /**
     * Relaciones
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
     * 🔥 Autor → submissions
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'author_id');
    }
}
