<?php

use Illuminate\Database\Seeder;

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/seeds/sql/cat_estados.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('cat_estados table seeded!');

        $path = 'database/seeds/sql/cat_municipios.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('cat_municipios table seeded!');

        $path = 'database/seeds/sql/cat_localidades.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('cat_localidades table seeded!');

        $path = 'database/seeds/sql/cat_colonias.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('cat_colonias table seeded!');
    }
}
