<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_item_detail()
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'price' => 5000,
            'description' => 'テスト用の商品説明',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('5000');
        $response->assertSee('テスト用の商品説明');
    }

    public function test_authenticated_user_can_view_item_detail()
    {
        /** @var User */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertViewIs('show'); // ログイン時のblade
    }

    public function test_item_detail_shows_category_and_condition()
    {
        $category = Category::factory()->create([
            'name' => '家電',
        ]);

        $condition = Condition::factory()->create([
            'name' => '新品',
        ]);

        $item = Item::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $item->categories()->attach($category->id);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('家電');
        $response->assertSee('新品');
    }

    public function test_item_detail_returns_404_for_invalid_id()
    {
        $response = $this->get('/item/9999');

        $response->assertStatus(404);
    }
}
