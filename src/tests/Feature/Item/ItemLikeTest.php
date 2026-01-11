<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
class ItemLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_an_item()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/like");

        $response->assertRedirect();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_can_unlike_an_item()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/like");

        $response->assertRedirect();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_guest_cannot_like_item()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/like");

        $response->assertRedirect('/login');

        $this->assertDatabaseCount('likes', 0);
    }

}
