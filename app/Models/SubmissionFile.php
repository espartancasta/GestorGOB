<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    protected $fillable = [
        'submission_id',
        'uploaded_by',
        'type',
        'path',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}