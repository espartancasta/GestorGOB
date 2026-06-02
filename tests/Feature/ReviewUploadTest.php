<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;
use App\Models\User;
use App\Notifications\AuthorReviewReadyNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ReviewUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_reviewer_can_upload_docx_review_after_accepting_invite()
    {
        Storage::fake('local');

        $author = User::factory()->create([
            'username' => 'author1',
            'role' => User::ROLE_AUTHOR,
            'status' => true,
        ]);

        $reviewer = User::factory()->create([
            'username' => 'reviewer1',
            'role' => User::ROLE_REVIEWER,
            'status' => true,
        ]);

        $submission = Submission::create([
            'author_id' => $author->id,
            'title' => 'Prueba de revisión',
            'summary' => 'Resumen de prueba',
            'status' => 'pending_assignment',
        ]);

        $token = Str::random(64);

        SubmissionReviewer::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer->id,
            'status' => 'accepted',
            'invite_token_hash' => $token,
            'accepted_at' => now(),
            'review_due_at' => now()->addDays(5),
        ]);

        $response = $this->actingAs($reviewer)
            ->post("/review-invite/{$token}/upload-review", [
                'file' => UploadedFile::fake()->create(
                    'revision.docx',
                    500,
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ),
            ]);

        $response->assertSessionHas('success', 'Revision subida correctamente.');

        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();
        $this->assertNotNull($invite);
        $this->assertEquals('completed', $invite->status);
        $this->assertNotNull($invite->review_uploaded_at);

        $file = SubmissionFile::where('submission_id', $submission->id)
            ->where('type', 'review_docx')
            ->first();

        $this->assertNotNull($file);
        Storage::disk('local')->assertExists($file->path);
    }

    public function test_author_is_notified_when_second_review_is_completed()
    {
        Notification::fake();
        Storage::fake('local');

        $author = User::factory()->create([
            'username' => 'author3',
            'role' => User::ROLE_AUTHOR,
            'status' => true,
            'email' => 'author3@example.com',
        ]);

        $reviewer1 = User::factory()->create([
            'username' => 'reviewer3',
            'role' => User::ROLE_REVIEWER,
            'status' => true,
        ]);

        $reviewer2 = User::factory()->create([
            'username' => 'reviewer4',
            'role' => User::ROLE_REVIEWER,
            'status' => true,
        ]);

        $submission = Submission::create([
            'author_id' => $author->id,
            'title' => 'Documento para notificacion',
            'summary' => 'Resumen de prueba',
            'status' => 'in_review',
        ]);

        SubmissionReviewer::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer1->id,
            'status' => 'completed',
            'invite_token_hash' => Str::random(64),
            'accepted_at' => now()->subDays(3),
            'review_due_at' => now()->subDay(),
            'review_uploaded_at' => now()->subDay(),
        ]);

        $token = Str::random(64);

        SubmissionReviewer::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer2->id,
            'status' => 'accepted',
            'invite_token_hash' => $token,
            'accepted_at' => now(),
            'review_due_at' => now()->addDays(5),
        ]);

        $response = $this->actingAs($reviewer2)
            ->post("/review-invite/{$token}/upload-review", [
                'file' => UploadedFile::fake()->create(
                    'revision.docx',
                    500,
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ),
            ]);

        $response->assertSessionHas('success', 'Revision subida correctamente.');

        $submission->refresh();
        $this->assertEquals('pending_correction', $submission->status);

        Notification::assertSentTo(
            $author,
            AuthorReviewReadyNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels, true);
            }
        );
    }

    public function test_reviewer_cannot_upload_non_docx_file()
    {
        Storage::fake('local');

        $author = User::factory()->create([
            'username' => 'author2',
            'role' => User::ROLE_AUTHOR,
            'status' => true,
        ]);

        $reviewer = User::factory()->create([
            'username' => 'reviewer2',
            'role' => User::ROLE_REVIEWER,
            'status' => true,
        ]);

        $submission = Submission::create([
            'author_id' => $author->id,
            'title' => 'Prueba de revisión',
            'summary' => 'Resumen de prueba',
            'status' => 'pending_assignment',
        ]);

        $token = Str::random(64);

        SubmissionReviewer::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer->id,
            'status' => 'accepted',
            'invite_token_hash' => $token,
            'accepted_at' => now(),
            'review_due_at' => now()->addDays(5),
        ]);

        $response = $this->actingAs($reviewer)
            ->post("/review-invite/{$token}/upload-review", [
                'file' => UploadedFile::fake()->create('revision.pdf', 500, 'application/pdf'),
            ]);

        $response->assertSessionHasErrors(['file']);
        $this->assertDatabaseMissing('submission_files', [
            'submission_id' => $submission->id,
        ]);
    }
}
