<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CarreraTableSeeder::class);
        $this->call(CategoriaTableSeeder::class);
        $this->call(ModuloTableSeeder::class);
        $this->call(EstudianteTableSeeder::class);
    }
}
