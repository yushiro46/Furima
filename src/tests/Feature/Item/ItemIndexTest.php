<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_item_list()
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items');
    }

    public function test_authenticated_user_can_see_item_list()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        Item::factory()->count(3)->create();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items');
    }

    public function test_user_cannot_see_own_items_in_index()
    {
        /** @var User $user */
        $user = User::factory()->create();

        // 自分の商品
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        // 他人の商品
        $otherItem = Item::factory()->create([
            'name' => '他人の商品',
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

    public function test_items_are_displayed_in_order()
    {
        $first = Item::factory()->create(['name' => '商品A']);
        $second = Item::factory()->create(['name' => '商品B']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            '商品A',
            '商品B',
        ]);
    }

    public function test_sold_item_is_displayed_as_sold()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        // 購入済みにする
        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        // 商品名が表示されている
        $response->assertSee($item->name);

        // Sold 表示があること
        $response->assertSee('Sold');
    }
}
