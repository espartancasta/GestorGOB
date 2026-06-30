<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatThread;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionChatController extends Controller
{
    public function index(Submission $submission)
    {
        $this->authorizeChatAccess($submission);

        $thread = ChatThread::firstOrCreate(
            ['submission_id' => $submission->id],
            ['created_by' => Auth::id()]
        );

        $messages = $thread->messages()
            ->with('user')
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->values();

        $submission->load('author');

        return view('submissions.chat.index', compact('submission', 'thread', 'messages'));
    }

    public function messages(Submission $submission)
    {
        $this->authorizeChatAccess($submission);

        $thread = ChatThread::firstOrCreate(
            ['submission_id' => $submission->id],
            ['created_by' => Auth::id()]
        );

        $messages = $thread->messages()
            ->with('user')
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->values()
            ->map(fn ($message) => [
                'id' => $message->id,
                'body' => $message->body,
                'is_mine' => $message->user_id === Auth::id(),
                'user_name' => $message->user->name ?? 'Usuario',
                'created_at' => $message->created_at?->format('d/m/Y H:i'),
            ]);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, Submission $submission)
    {
        $this->authorizeChatAccess($submission);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $thread = ChatThread::firstOrCreate(
            ['submission_id' => $submission->id],
            ['created_by' => Auth::id()]
        );

        $message = $thread->messages()->create([
            'user_id' => Auth::id(),
            'body' => $data['body'],
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'body' => $message->body,
                'is_mine' => true,
                'user_name' => Auth::user()->name ?? 'Usuario',
                'created_at' => $message->created_at?->format('d/m/Y H:i'),
            ],
        ]);
    }

    private function authorizeChatAccess(Submission $submission): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No tienes permiso para acceder al chat de este documento.');
        }

        $isAuthor = $submission->author_id === $user->id;
        $isSecretary = $user->role === User::ROLE_SECRETARY;
        $isDicovi = $user->role === User::ROLE_DICOVI;
        $isReviewer = $submission->reviewers()
            ->where('reviewer_id', $user->id)
            ->exists();

        if (!$isAuthor && !$isSecretary && !$isDicovi && !$isReviewer) {
            abort(403, 'No tienes permiso para acceder al chat de este documento.');
        }
    }
}
