<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // Mantengo index() por compatibilidad
    public function index($username)
    {
        $user = User::where("status", true)->where("username", $username)->first();

        if (!$user) {
            abort(404);
        }

        $posts = $user->posts()
            ->with("category")
            ->where("status", true)
            ->orderBy("id", "DESC")
            ->paginate(10);

        return view("frontend.user.index", compact("user", "posts"));
    }

    // Ruta actual usa show()
    public function show($username)
    {
        return $this->index($username);
    }
}
