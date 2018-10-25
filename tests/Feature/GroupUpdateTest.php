<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupUpdateTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test if group's users list can be updated
     *
     * @return void
     */
    public function testListOfUsersInAGroupCanBeModified()
    {
        $group = factory(Group::class)->create();
        $users = factory(User::class, 3)->create();

        $responseExistingUsersIds = $this->json('PUT', 'api/groups/' . $group->id, [
        	'user_ids' => [1, 2, 3]
        ]);

        $responseWithNonExistentUserIds = $this->json('PUT', 'api/groups/' . $group->id, [
        	'user_ids' => [1, 2, 3, 4, 5]
        ]);

        $responseExistingUsersIds->assertStatus(200);
        $responseWithNonExistentUserIds->assertStatus(422);
    }
}
