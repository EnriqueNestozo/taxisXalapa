<?php

use Illuminate\Database\Seeder;

class TaxisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            'placas' => '',
            'numero' => 'M00',
            'numero_economico' => '',
            'marca' => '',
            'modelo' => '',
            'tarjeta_circulacion' => '',
            'base' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        for ($i=1; $i <= 105; $i++) { 
            DB::table('unidades')->insert([
                'placas' => '',
                'numero' => 'M'.$i,
                'numero_economico' => '',
                'marca' => '',
                'modelo' => '',
                'tarjeta_circulacion' => '',
                'base' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]);
       }
       for ($i=106; $i <= 210; $i++) { 
        DB::table('unidades')->insert([
            'placas' => '',
            'numero' => 'M'.$i,
            'numero_economico' => '',
            'marca' => '',
            'modelo' => '',
            'tarjeta_circulacion' => '',
            'base' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
   }   
        
    }
}
