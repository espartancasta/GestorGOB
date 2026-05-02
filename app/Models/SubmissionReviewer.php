<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Submission;

class SubmissionReviewer extends Model
{
    protected $table = 'submission_reviewers';

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'status',
        'invite_token_hash',
        'invite_expires_at',
        'accepted_at',
        'rejected_at',
        'review_uploaded_at', // 🔥 Semana 12
    ];

    protected $casts = [
        'invite_expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'review_uploaded_at' => 'datetime',
    ];

    /**
     * 📄 Relación con submission
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    /**
     * ⏰ Saber si expiró (SEMANA 13)
     */
    public function isExpired()
    {
        return $this->invite_expires_at &&
               now()->greaterThan($this->invite_expires_at);
    }

    /**
     * ❌ Rechazado
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * ⏳ Pendiente
     */
    public function isInvited()
    {
        return $this->status === 'invited';
    }

    /**
     * ✅ Aceptado
     */
    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    /**
     * ✔ Completado
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}