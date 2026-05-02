<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'summary',
        'status',
    ];

    /**
     * Relación con el autor
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * 🔥 RELACIÓN CON ARCHIVOS (SEMANA 7)
     */
    public function files()
    {
        return $this->hasMany(SubmissionFile::class);
    }
}