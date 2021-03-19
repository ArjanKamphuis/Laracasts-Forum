<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
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
        Channel::factory(5)->create()->each(function($channel) {
            return Thread::factory(3)->create(['channel_id' => $channel->id])->each(function($thread) {
                return Reply::factory(2)->create(['thread_id' => $thread->id]);
            });
        });
    }
}
