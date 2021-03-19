<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp() : void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_partipate_in_forum_threads()
    {
        $reply = make(Reply::class);

        $this->signIn()
            ->post($this->thread->path().'/replies', $reply->toArray());
        
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $reply = make(Reply::class, ['body' => null]);
        
        $this->withExceptionHandling()
            ->signIn()
            ->post($this->thread->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
