<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatThread;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $completedStatuses = ['completed', 'approved', 'revision_completed'];
        $rejectedStatuses = ['rejected', 'no_aprobado'];

        $authorSubmissionQuery = Submission::query()
            ->where('author_id', $user->id);

        $stats = [
            'total_submissions' => (clone $authorSubmissionQuery)->count(),
            'in_process' => (clone $authorSubmissionQuery)
                ->whereNotIn('status', array_merge($completedStatuses, $rejectedStatuses))
                ->count(),
            'completed' => (clone $authorSubmissionQuery)
                ->whereIn('status', $completedStatuses)
                ->count(),
            'active_chats' => Schema::hasTable('chat_threads')
                ? ChatThread::whereHas('submission', fn ($query) => $query->where('author_id', $user->id))->count()
                : 0,
        ];

        return view('profile.show', compact('user', 'stats'));
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'sex' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'institution' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'curp' => ['nullable', 'string', 'max:18'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'location' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'max:1000'],
            'specialty' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->fill($validated);
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
