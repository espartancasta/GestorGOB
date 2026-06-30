<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submission_reviewers', function (Blueprint $table) {
            if (!Schema::hasColumn('submission_reviewers', 'review_decision')) {
                $table->string('review_decision')->default('en_revision')->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('submission_reviewers', function (Blueprint $table) {
            if (Schema::hasColumn('submission_reviewers', 'review_decision')) {
                $table->dropColumn('review_decision');
            }
        });
    }
};
