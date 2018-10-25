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
    	factory(App\Group::class, 5)
           ->create()
           ->each(function ($g) {
                $g->users()->saveMany(factory(App\User::class, 5)->make());
            });
    }
}
