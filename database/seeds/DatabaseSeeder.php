<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 50)->create();
        $books = factory(App\Book::class, 50)->create();
        for ($i = 0; $i < 250; $i++) {
            $users->random()->books()->save($books->random());    
        }
    }
}
