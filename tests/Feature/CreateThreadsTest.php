<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp() : void
    {
        parent::setUp();

        $this->thread = make(Thread::class);
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads', $this->thread->toArray());
    }

    /** @test */
    public function guests_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn()
            ->post('/threads', $this->thread->toArray());

        $this->get($this->thread->path())
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }
}
