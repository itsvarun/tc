<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$users = App\User::count();
    	$categories = App\Category::count();

    	// dd("categories count " . $categories . " user count " . $users);

        factory(App\Task::class, 10)->create();
    }
}
