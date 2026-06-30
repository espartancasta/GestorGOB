<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Autor Demo',
                'username' => 'autor',
                'email' => 'autor@example.com',
                'role' => User::ROLE_AUTHOR,
                'password' => 'password',
            ],
            [
                'name' => 'Revisor Uno',
                'username' => 'revisor1',
                'email' => 'revisor1@example.com',
                'role' => User::ROLE_REVIEWER,
                'password' => 'password',
            ],
            [
                'name' => 'Revisor Dos',
                'username' => 'revisor2',
                'email' => 'revisor2@example.com',
                'role' => User::ROLE_REVIEWER,
                'password' => 'password',
            ],
            [
                'name' => 'Secretario Demo',
                'username' => 'secretario',
                'email' => 'secretario@example.com',
                'role' => User::ROLE_SECRETARY,
                'password' => 'password',
            ],
            [
                'name' => 'DICOVI Demo',
                'username' => 'dicovi',
                'email' => 'dicovi@example.com',
                'role' => User::ROLE_DICOVI,
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user + ['status' => true]
            );
        }

        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'Gestor GOB',
                'tagline' => 'Sistema de gestion de publicaciones',
                'description' => 'Sistema para administrar envios, revisiones y cierre de documentos INIFAP.',
                'logo_dark' => 'logo_dark.png',
                'logo_light' => 'logo_light.png',
                'copyright_text' => 'Gestor GOB',
                'enable_registration' => true,
            ]
        );

        $menu = [
            [
                'href' => url('/'),
                'icon' => '',
                'text' => 'Inicio',
                'tooltip' => '',
                'children' => [],
            ],
            [
                'href' => url('/submissions/create'),
                'icon' => '',
                'text' => 'Enviar documento',
                'tooltip' => '',
                'children' => [],
            ],
        ];

        Menu::updateOrCreate(
            ['id' => 1],
            [
                'header_menu' => json_encode($menu),
                'footer_menu' => json_encode($menu),
            ]
        );
    }
}
