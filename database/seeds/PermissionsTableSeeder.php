<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission; 

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permisos de usuario
        Permission::create([
            'name' => 'Navegar categorias',
            'slug' => 'categoria.index',
            'description' => 'Lista y navega todas las categorias de observaciones',
        ]);
        Permission::create([
            'name' => 'Navegar Usuarios del sistema',
            'slug' => 'users.index',
            'description' => 'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name' => 'Navegar los modulos de las carreras',
            'slug' => 'modulos.index',
            'description' => 'Lista y navega todos los modulos del sistema',
        ]);
        Permission::create([
            'name' => 'Añadir estudiante',
            'slug' => 'estudiante.add',
            'description' => 'Podra añadir estudiante de la carrera que se le asigne',
        ]);

        /** 
         * 
         * Añadir usuarios por carrera
         * 
         * 
        */
        
        Permission::create([
            'name' => 'Añadir usuario al sistema',
            'slug' => 'addUser',
            'description' => 'Podra añadir usuario al sistema',
        ]);
        
        
        
    }
}
