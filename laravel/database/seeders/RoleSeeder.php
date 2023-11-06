<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        {
            // Define els rols que vols afegir a la taula "roles"
            $roles = [
                ['name' => 'author'],
                ['name' => 'editor'],
                ['name' => 'admin'],
            ];
    
            // Utilitza la funció DB per afegir els rols a la taula "roles"
            DB::table('roles')->insert($roles);
        }
        
    }
}
