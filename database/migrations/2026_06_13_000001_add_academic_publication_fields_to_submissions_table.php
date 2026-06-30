<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('submissions', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('submissions', 'titulo_publicacion')) {
                $table->string('titulo_publicacion')->nullable()->after('summary');
            }

            if (!Schema::hasColumn('submissions', 'tipo_publicacion')) {
                $table->string('tipo_publicacion')->nullable()->after('titulo_publicacion');
            }

            if (!Schema::hasColumn('submissions', 'resumen')) {
                $table->text('resumen')->nullable()->after('tipo_publicacion');
            }

            if (!Schema::hasColumn('submissions', 'palabras_clave')) {
                $table->json('palabras_clave')->nullable()->after('resumen');
            }

            if (!Schema::hasColumn('submissions', 'autores')) {
                $table->text('autores')->nullable()->after('palabras_clave');
            }

            if (!Schema::hasColumn('submissions', 'institucion_adscripcion')) {
                $table->string('institucion_adscripcion')->nullable()->after('autores');
            }

            if (!Schema::hasColumn('submissions', 'archivo_documento')) {
                $table->string('archivo_documento')->nullable()->after('institucion_adscripcion');
            }

            if (!Schema::hasColumn('submissions', 'estado')) {
                $table->string('estado')->default('pendiente')->after('archivo_documento');
            }
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            foreach ([
                'estado',
                'archivo_documento',
                'institucion_adscripcion',
                'autores',
                'palabras_clave',
                'resumen',
                'tipo_publicacion',
                'titulo_publicacion',
                'user_id',
            ] as $column) {
                if (Schema::hasColumn('submissions', $column)) {
                    if ($column === 'user_id') {
                        $table->dropConstrainedForeignId('user_id');
                    } else {
                        $table->dropColumn($column);
                    }
                }
            }
        });
    }
};
