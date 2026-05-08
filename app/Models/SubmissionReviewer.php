<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Submission;
use App\Models\User;

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
        'review_due_at',       // ✅ Semana 14: fecha límite para entregar revisión
        'review_uploaded_at',  // ✅ Semana 12: fecha en que subió revisión
    ];

    protected $casts = [
        'invite_expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'review_due_at' => 'datetime',
        'review_uploaded_at' => 'datetime',
    ];

    /**
     * 📄 Relación con submission/documento
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    /**
     * 👤 Relación con usuario revisor
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * ⏰ Saber si la invitación expiró
     * Aplica principalmente cuando sigue en invited.
     */
    public function isExpired()
    {
        return $this->invite_expires_at &&
               now()->greaterThan($this->invite_expires_at);
    }

    /**
     * ⏰ Saber si la fecha límite de entrega de revisión venció
     * Aplica después de aceptar la invitación.
     */
    public function isReviewDueExpired()
    {
        return $this->review_due_at &&
               now()->greaterThan($this->review_due_at);
    }

    /**
     * ❌ Rechazado
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * ⏳ Pendiente de respuesta
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
     * ✔ Completado / revisión subida
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}