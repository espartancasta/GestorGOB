<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'sex')) {
                $table->string('sex')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'age')) {
                $table->integer('age')->nullable()->after('sex');
            }

            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution')->nullable()->after('age');
            }

            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable()->after('institution');
            }

            if (!Schema::hasColumn('users', 'curp')) {
                $table->string('curp', 18)->nullable()->after('department');
            }

            if (!Schema::hasColumn('users', 'rfc')) {
                $table->string('rfc', 13)->nullable()->after('curp');
            }

            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable()->after('rfc');
            }

            if (!Schema::hasColumn('users', 'specialty')) {
                $table->text('specialty')->nullable()->after('about');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['phone', 'sex', 'age', 'institution', 'department', 'curp', 'rfc', 'location', 'specialty'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
