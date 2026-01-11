<?php

namespace Tests\Feature\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_purchase_page()
    {
        $item = Item::factory()->create();

        $response = $this->get("/purchase/{$item->id}");

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_purchase_page()
    {
        /** @var User */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertStatus(200);
        $response->assertViewIs('purchase');
    }

    public function test_user_can_purchase_item()
    {
        /** @var User */
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'price' => 1000,
        ]);

        $this->actingAs($user);

        $response = $this->post("/purchase/{$item->id}/pay", [
            'payment' => 'カード支払い',
        ]);

        // purchases テーブルに保存されているか
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // Stripeの決済URLにリダイレクトされる（URLは何でもOK）
        $response->assertRedirect();
    }

    public function test_cannot_purchase_already_sold_item()
    {
        /** @var User */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // すでに購入済み
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->post("/purchase/{$item->id}/pay", [
            'payment' => 'カード支払い',
        ]);

        // 商品詳細ページへ戻される想定
        $response->assertRedirect("/item/{$item->id}");

        // 二重登録されていない
        $this->assertEquals(1, Purchase::where('item_id', $item->id)->count());
    }
}
