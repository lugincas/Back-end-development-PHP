<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\MascotaLCU;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class LCUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('name','LCU1')->count()==0)
        {
            $userLCU1= new User;
            $userLCU1->name='LCU1';
            $userLCU1->password=Hash::make('LCU1');
            $userLCU1->email='LCU1@email.LCU';
            $userLCU1->email_verified_at='now';
            $userLCU1->save();
        }

        if (User::where('name','LCU2')->count()==0)
        {
            $userLCU2= new User;
            $userLCU2->name='LCU2';
            $userLCU2->password=Hash::make('LCU2');
            $userLCU2->email='LCU2@email.LCU';
            $userLCU2->email_verified_at='now';
            $userLCU2->save();
        }
    // Mascotas usuario 1
        if (MascotaLCU::where('nombre','Felicia')->count()==0)
        {
            $mascota1user1= new MascotaLCU();
            $mascota1user1->nombre='Felicia';
            $mascota1user1->descripcion='Gata parda muy bonita';
            $mascota1user1->tipo='Gato';
            $mascota1user1->publica='Si';
            $mascota1user1->megusta=0;
            $mascota1user1->user_id=1; // He ajustado los ID de los usuarios (en la tarea 5 el id 1 estaba ocupado por un usuario creado para un ejercicio concreto), es la única diferencia con respecto al código utilizado en la tarea 5
            $mascota1user1->save();
        }
        if (MascotaLCU::where('nombre','Facundo')->count()==0)
        {
            $mascota2user1= new MascotaLCU();
            $mascota2user1->nombre='Facundo';
            $mascota2user1->descripcion='Perro salchicha';
            $mascota2user1->tipo='Perro';
            $mascota2user1->publica='No';
            $mascota2user1->megusta=0;
            $mascota2user1->user_id=1;
            $mascota2user1->save();
        }

    // Mascotas usuario 2
        if (MascotaLCU::where('nombre','Desdentao')->count()==0)
        {
            $mascota1user2= new MascotaLCU();
            $mascota1user2->nombre='Desdentao';
            $mascota1user2->descripcion='Dragón negro de ojos verdes';
            $mascota1user2->tipo='Dragón';
            $mascota1user2->publica='Si';
            $mascota1user2->megusta=3;
            $mascota1user2->user_id=2;
            $mascota1user2->save();
        }
        if (MascotaLCU::where('nombre','Arsenio')->count()==0)
        {
            $mascota2user2= new MascotaLCU();
            $mascota2user2->nombre='Arsenio';
            $mascota2user2->descripcion='Pez de colores';
            $mascota2user2->tipo='Pez';
            $mascota2user2->publica='No';
            $mascota2user2->megusta=0;
            $mascota2user2->user_id=2;
            $mascota2user2->save();
        }

    }
}
