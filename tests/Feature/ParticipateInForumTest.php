<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('threads/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_partipate_in_forum_threads()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->signIn()
            ->post($thread->path().'/replies', $reply->toArray());
        
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
