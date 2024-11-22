<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $check_user = DB::table('users')->where('email', '=', 'admin@marloanderson.com')->exists();
        if (!$check_user) {
            DB::table('users')->insert([
                [
                    'first_name' => "Marlo",
                    'last_name'  => "Anderson",
                    'email'      => "admin@marloanderson.com",
                    'password'   => bcrypt(123456),
                    'role'       => 0,
                    "created_at" => Date("Y-m-d H:i:s"),
                    "updated_at" => Date("Y-m-d H:i:s")
                ]
            ]);
        }
    }
}
