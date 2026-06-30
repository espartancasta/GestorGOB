<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;
use App\Models\ChatThread;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
        'title',
        'summary',
        'titulo_publicacion',
        'tipo_publicacion',
        'resumen',
        'palabras_clave',
        'autores',
        'institucion_adscripcion',
        'archivo_documento',
        'estado',
        'status',
    ];

    protected $casts = [
        'palabras_clave' => 'array',
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

    public function reviewerUsers()
    {
        return $this->belongsToMany(User::class, 'submission_reviewers', 'submission_id', 'reviewer_id')
            ->withPivot([
                'status',
                'invite_token_hash',
                'invite_expires_at',
                'accepted_at',
                'rejected_at',
                'review_due_at',
                'review_uploaded_at',
            ])
            ->withTimestamps();
    }

    public function chatThread()
    {
        return $this->hasOne(ChatThread::class);
    }

    public function evaluationDecisionKey(): string
    {
        $reviewers = $this->relationLoaded('reviewers')
            ? $this->reviewers
            : $this->reviewers()->get();

        if ($reviewers->count() < 2 || $reviewers->contains(fn ($reviewer) => $reviewer->reviewDecisionKey() === 'en_revision')) {
            return 'en_revision';
        }

        if ($reviewers->contains(fn ($reviewer) => $reviewer->reviewDecisionKey() === 'no_aprobado')) {
            return 'no_aprobado';
        }

        if ($reviewers->contains(fn ($reviewer) => $reviewer->reviewDecisionKey() === 'aprobado_observaciones')) {
            return 'aprobado_observaciones';
        }

        if ($reviewers->every(fn ($reviewer) => $reviewer->reviewDecisionKey() === 'aprobado')) {
            return 'aprobado';
        }

        return 'en_revision';
    }

    public function evaluationDecisionLabel(): string
    {
        return match ($this->evaluationDecisionKey()) {
            'aprobado' => 'Aprobado',
            'aprobado_observaciones' => 'Aprobado con observaciones',
            'no_aprobado' => 'No aprobado',
            default => 'En revisión',
        };
    }

    public function evaluationDecisionClass(): string
    {
        return match ($this->evaluationDecisionKey()) {
            'aprobado' => 'is-approved',
            'aprobado_observaciones' => 'is-observed',
            'no_aprobado' => 'is-rejected',
            default => 'is-reviewing',
        };
    }
}
