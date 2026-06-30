<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submission_reviewers', function (Blueprint $table) {
            if (!Schema::hasColumn('submission_reviewers', 'review_due_at')) {
                $table->timestamp('review_due_at')->nullable()->after('rejected_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('submission_reviewers', function (Blueprint $table) {
            if (Schema::hasColumn('submission_reviewers', 'review_due_at')) {
                $table->dropColumn('review_due_at');
            }
        });
    }
};