<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Admin\UserController;

use User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testChangeLink()
    {
        $string = 'a test link';
        $expect = 'a-test-link';

        $result = changeLink($string);

        $this->assertEquals($expect, $result);
    }
}
