<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'summary',
        'status',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function files()
    {
        return $this->hasMany(SubmissionFile::class);
    }

    public function reviewers()
    {
        return $this->hasMany(SubmissionReviewer::class, 'submission_id');
    }
}