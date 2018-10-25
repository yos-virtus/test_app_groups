<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
	 use RefreshDatabase;

    /**
     * Test if one can create a user who is included in a group
     *
     * @return void
     */
    public function testCanCreateUserWhoIncludedInAGroup()
    {
        $group = factory(Group::class)->create();

        $response = $this->json('POST', 'api/users', [
       		'name' => 'Us', 
       		'email' => 'us@traveling.test', 
       		'password' => 'secret',
       		'group_id' => $group->id
       	]);

       	// check that relation exists in db
       	$this->assertDatabaseHas('user_group', ['user_id' => 1, 'group_id' => 1]);

        $response
            ->assertStatus(201)
            ->assertJson([
				"id" => 1,
				'name' => 'Us', 
       			'email' => 'us@traveling.test'
            ]);
    }

    /**
     * Test if users exists and active
     *
     * @return void
     */
    public function testIfUserExistsAndActive()
    {
        $user = factory(User::class)->create();

        $responseExists = $this->json('GET', 'api/users/1', ['state' => 'active']);
        $responseNonExistent = $this->json('GET', 'api/users/1', ['state' => 'nonactive']);

        $responseExists->assertStatus(200);
        $responseNonExistent->assertStatus(404);
    }

    /**
     * Test if users exists and active
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
