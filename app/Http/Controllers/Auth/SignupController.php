<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route("frontend.home");
        }
        $enable_registration = SiteSetting::first("enable_registration")->enable_registration;
        return view("auth.signup", compact("enable_registration"));
    }

    public function signup(Request $request) {
        if (Auth::check()) {
            return redirect()->route("frontend.home");
        }
        $enable_registration = SiteSetting::first("enable_registration")->enable_registration;
        if (!$enable_registration) {
            return back();
        }
        $validated = $request->validate([
            "name" => ["required", "string", "min:3", "max:100"],
            "username" => ["required", "string", "regex:/\w*$/", "unique:users,username", "max:100"],
            "email" => ["required", "email:rfc", "unique:users,email", "max:255"],
            "password" => ["required", "confirmed", "min:8", "max:100"],
            "password_confirmation" => ["required"],
            "role_id" => ["required"],
            "terms" => ["required", "accepted"],
            "phone" => ["nullable", "string", "max:30"],
            "sex" => ["nullable", "string", "max:50"],
            "age" => ["nullable", "integer", "min:1", "max:120"],
            "institution" => ["nullable", "string", "max:255"],
            "department" => ["nullable", "string", "max:255"],
            "curp" => ["nullable", "string", "max:18"],
            "rfc" => ["nullable", "string", "max:13"],
            "location" => ["nullable", "string", "max:255"],
            "about" => ["nullable", "string", "max:1000"],
            "specialty" => ["nullable", "string", "max:1000"],
        ]);

        $role = $validated["role_id"] === "Autor" ? User::ROLE_AUTHOR : (int) $validated["role_id"];

        $user = User::create([
            "name" => $validated["name"],
            "username" => $validated["username"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
            "role" => $role ?: User::ROLE_AUTHOR,
            "phone" => $validated["phone"] ?? null,
            "sex" => $validated["sex"] ?? null,
            "age" => $validated["age"] ?? null,
            "institution" => $validated["institution"] ?? null,
            "department" => $validated["department"] ?? null,
            "curp" => $validated["curp"] ?? null,
            "rfc" => $validated["rfc"] ?? null,
            "location" => $validated["location"] ?? null,
            "about" => $validated["about"] ?? null,
            "specialty" => $validated["specialty"] ?? null,
        ]);

        Auth::loginUsingId($user->id);
        return redirect()->route("frontend.home");
    }
}
