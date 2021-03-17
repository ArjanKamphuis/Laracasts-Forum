<?php

namespace Tests\Unit;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp() : void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function it_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function it_has_a_creator()
    {
        $this->assertInstanceOf('App\Models\User', $this->thread->creator);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
