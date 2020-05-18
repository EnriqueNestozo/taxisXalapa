<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TurnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turnos')->insert([
            'horaInicio' => '6:00:00',
            'horaFin' => '13:59:59',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('turnos')->insert([
            'horaInicio' => '14:00:00',
            'horaFin' => '21:59:59',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('turnos')->insert([
            'horaInicio' => '22:00:00',
            'horaFin' => '05:59:59',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}