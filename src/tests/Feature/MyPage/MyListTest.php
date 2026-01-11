<?php

namespace Tests\Feature\MyPage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_page()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertRedirect('/login');
    }

    public function test_user_can_see_only_liked_items()
    {
        /** @var User */
        $user = User::factory()->create();

        // いいねした商品
        $likedItem = Item::factory()->create();
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        // いいねしていない商品
        $notLikedItem = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($likedItem->name);
        $response->assertDontSee($notLikedItem->name);
    }

}
