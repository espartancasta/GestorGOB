<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_SECRETARY) {
            return app(SubmissionController::class)->index(request());
        }
        $recentposts = Post::with("category")
            ->where("status", true)
            ->orderBy("id", "DESC")
            ->paginate(10);

        $featuredposts = Post::with(["category", "user"])
            ->where("status", true)
            ->where("is_featured", true)
            ->orderBy("id", "DESC")
            ->limit(10)
            ->get();

        $categories = Category::where("status", true)
            ->orderBy("title", "ASC")
            ->limit(10)
            ->get();

        $approvedSubmissions = Submission::with("author")
            ->where("status", "completed")
            ->orderBy("updated_at", "DESC")
            ->get();

        $featuredCalls = [
            [
                "category" => "Ciencias Agropecuarias",
                "title" => "Convocatoria Nacional de Investigacion 2026",
                "description" => "Registro de propuestas para proyectos de investigacion, innovacion y desarrollo tecnologico.",
                "deadline" => "30/06/2026",
                "status" => "Abierta",
            ],
            [
                "category" => "Biotecnologia",
                "title" => "Fondo Sectorial SAGARPA-CONACYT 2026",
                "description" => "Propuestas orientadas a la seguridad alimentaria, biotecnologia y sustentabilidad rural.",
                "deadline" => "15/07/2026",
                "status" => "Abierta",
            ],
            [
                "category" => "Innovacion Rural",
                "title" => "Programa de Innovacion Agropecuaria 2026",
                "description" => "Apoyo a proyectos de transferencia tecnologica y mejora en cadenas productivas del sector rural.",
                "deadline" => "31/07/2026",
                "status" => "Proximamente",
            ],
        ];

        return view("frontend.home.index", compact(
            "recentposts",
            "featuredposts",
            "categories",
            "approvedSubmissions",
            "featuredCalls"
        ));
    }
}
