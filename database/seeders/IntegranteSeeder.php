<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Integrante;
use App\Models\User;
use Illuminate\Database\Seeder;

class IntegranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = Grupo::all();

        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);

        foreach($grupos as $key => $grupo){

            Integrante::factory()->create([
                "nombre" => $user1->name,
                "correo" => $user1->email,
                "usuario" => $user1->id,
                "grupo" => $grupo->id
            ]);

            Integrante::factory()->create([
                "nombre" => $user2->name,
                "correo" => $user2->email,
                "usuario" => $user2->id,
                "grupo" => $grupo->id
            ]);

            Integrante::factory()->create([
                "nombre" => $user3->name,
                "correo" => $user3->email,
                "usuario" => $user3->id,
                "grupo" => $grupo->id
            ]);

            Integrante::factory()->create([
                "grupo" => $grupo->id
            ]);
        }
    }
}
