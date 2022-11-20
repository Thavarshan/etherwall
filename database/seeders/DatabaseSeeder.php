<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $threads = Thread::factory(10)->create();

        $threads->each(function ($thread) {
            Reply::factory(5)->create([
                'thread_id' => $thread->id,
            ]);
        });
    }
}
