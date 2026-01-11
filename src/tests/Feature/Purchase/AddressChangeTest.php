<?php

namespace Tests\Feature\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_address_edit_page()
    {
        $item = Item::factory()->create();

        $response = $this->get("/purchase/address/{$item->id}");

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_address_edit_page()
    {
        /** @var User */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get("/purchase/address/{$item->id}");

        $response->assertStatus(200);
        $response->assertViewIs('address_edit');
    }

    public function test_user_can_update_shipping_address()
    {
        /** @var User */
        $user = User::factory()->create([
            'postal_code' => '1234567',
            'address' => '旧住所',
            'building' => '旧建物',
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/address/update/{$item->id}", [
            'postal_code' => '987-6543',
            'address'     => '新しい住所',
            'building'    => '新しい建物',
        ]);

        // DBが更新されているか
        $this->assertDatabaseHas('users', [
            'id'          => $user->id,
            'postal_code' => '9876543', // ハイフン除去されて保存される前提
            'address'     => '新しい住所',
            'building'    => '新しい建物',
        ]);

        // purchase画面に戻る
        $response->assertRedirect("/purchase/{$item->id}");
    }
}
