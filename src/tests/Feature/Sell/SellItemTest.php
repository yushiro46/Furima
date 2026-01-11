<?php

namespace Tests\Feature\Sell;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_sell_page()
    {
        $response = $this->get('/sell');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_sell_page()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sell');

        $response->assertStatus(200);
        $response->assertViewIs('sell');
    }

    public function test_user_can_sell_item()
    {
        Storage::fake('public');
        /** @var User */
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/items', [
            'image'        => UploadedFile::fake()->image('test.jpg'),
            'name'         => 'テスト商品',
            'brand'        => 'テストブランド',
            'price'        => 5000,
            'description'  => 'テスト商品の説明',
            'condition_id' => $condition->id,
            'category_ids' => [$category->id],
        ]);

        // items テーブルに保存されているか
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'price' => 5000,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // 画像が storage/app/public/products に保存されているか
        Storage::disk('public')->assertExists('products');

        // 出品後のリダイレクト確認（mypage など）
        $response->assertRedirect();
    }
}
