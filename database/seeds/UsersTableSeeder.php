<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    
    public function run()
    {
        /*
        //teste seeding de inserção de cliente na BD
        \DB::table('users')->insert([
        'name' => 'Adminstrador',
        'email' => 'admin2admin.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => 'mjzxhjvbzdfxsdzfzsddzxv',
        ]); */


        //faz a criação de 40 usuarios e pra cada um cria uma loja com o id do usuario.
        factory(\App\User::class, 40)->create()->each(function($user){

            //store representa a criação do relacionamento 1/1
            //metodo create trabalha com arrays e op metodo save trabalha com objetos.
            $user->store()->save(factory(\App\Store::class)->make());
        });
    }
}
