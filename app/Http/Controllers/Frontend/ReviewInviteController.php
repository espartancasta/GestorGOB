<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SubmissionReviewer;
use Illuminate\Http\Request;

class ReviewInviteController extends Controller
{
    public function show($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404);
        }

        // 🔥 VALIDACIÓN EXPIRACIÓN
        if ($invite->invite_expires_at && now()->greaterThan($invite->invite_expires_at)) {
            $invite->update(['status' => 'expired']);

            return view('frontend.review-invite.show', [
                'invite' => $invite,
                'expired' => true
            ]);
        }

        return view('frontend.review-invite.show', compact('invite'));
    }

    public function reject($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404);
        }

        $invite->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()->back()->with('success', 'Revisión rechazada.');
    }
}