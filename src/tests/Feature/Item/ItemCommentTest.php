<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_post_comment()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'とても良い商品です',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品です',
        ]);
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'ゲストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'comment' => 'ゲストコメント',
        ]);
    }

    public function test_comment_is_required()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    public function test_comment_must_be_less_than_256_characters()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
