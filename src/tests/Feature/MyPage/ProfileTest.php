<?php

namespace Tests\Feature\MyPage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile_page()
    {
        $response = $this->get('/mypage');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile_page()
    {
        /** @var User */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_authenticated_user_can_view_profile_edit_page()
    {
        /** @var User */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('プロフィール設定');
    }

    public function test_user_can_update_profile_information()
    {
        Storage::fake('public');

        /** @var User */
        $user = User::factory()->create([
            'name' => '旧ユーザー名',
        ]);

        $this->actingAs($user);

        $response = $this->post('/mypage/profile', [
            'name' => '新しいユーザー名',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'avatar' => UploadedFile::fake()->image('avatar.png'),
        ]);

        $response->assertRedirect('/mypage');

        // DBが更新されているか
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しいユーザー名',
            'postal_code' => '1234567', // ハイフン除去されて保存される前提
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        // 画像が保存されているか
        Storage::disk('public')->assertExists('avatars/' . $user->fresh()->avatar);
    }
}
