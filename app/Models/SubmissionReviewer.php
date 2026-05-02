<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionReviewer extends Model
{
    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'invite_token_hash', // 🔥 CORREGIDO
        'invite_expires_at',
        'status',
        'rejected_at'
    ];

    protected $casts = [
        'invite_expires_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}