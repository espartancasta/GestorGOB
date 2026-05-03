<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));

        $submissions = Submission::query()
            ->with('author')

            /*
            |--------------------------------------------------------------------------
            | VISIBILIDAD POR ROL
            |--------------------------------------------------------------------------
            | Secretario role = 3:
            |   Puede ver todos los documentos en búsqueda.
            |
            | Autor role = 1, Revisor role = 2, DICOVI role = 4 e invitados:
            |   Solo pueden ver documentos completados.
            |
            | Esto evita que el Autor/Revisor vea documentos pendientes,
            | esperando aceptación, en revisión o todavía internos.
            */
            ->when(!Auth::check() || Auth::user()->role != 3, function ($q) {
                $q->where('status', 'completed');
            })

            /*
            |--------------------------------------------------------------------------
            | BÚSQUEDA
            |--------------------------------------------------------------------------
            | Busca por:
            | - título
            | - resumen
            | - nombre del autor
            | - correo del autor
            */
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($inner) use ($query) {
                    $inner->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('summary', 'LIKE', "%{$query}%")
                        ->orWhereHas('author', function ($authorQuery) use ($query) {
                            $authorQuery->where('name', 'LIKE', "%{$query}%")
                                ->orWhere('email', 'LIKE', "%{$query}%");
                        });
                });
            })

            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('frontend.search.index', [
            'submissions' => $submissions,
            'query' => $query,
        ]);
    }
}