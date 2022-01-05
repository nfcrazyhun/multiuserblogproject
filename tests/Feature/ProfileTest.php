<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /*
     * Livewire Testing
     * https://laravel-livewire.com/docs/2.x/testing
     */

/**
|--------------------------------------------------------------------------
| Happy Path
|--------------------------------------------------------------------------
*/

    public function test_can_see_livewire_profile_component_on_profile_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profile')
            ->assertSuccessful()
            ->assertSeeLivewire('profile');
    }

    function test_profile_info_is_pre_populated()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->assertSet('user.username', $user->username)
            ->assertSet('user.email', $user->email);
    }

    public function test_can_update_profile()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.username', 'test.user')
            ->set('user.email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('save');

        $user->refresh();

        $this->assertEquals('test.user', $user->username);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue( Hash::check('password123', $user->password) );
    }

    function test_can_upload_avatar()
    {
        Storage::fake('avatars');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.png');

        Livewire::actingAs($user)
            ->test('profile')
            ->set('upload', $file)
            ->call('save');

        $user->refresh();

        $this->assertNotNull($user->avatar);
        Storage::disk('avatars')->assertExists($user->avatar);
    }

    function test_message_is_shown_on_save()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->call('save')
            ->assertDispatchedBrowserEvent('notify','Profile Updated!');
    }

/**
|--------------------------------------------------------------------------
| Validation Test
|--------------------------------------------------------------------------
*/

/*
|------------------ Username --------------------------------------------------------
*/
    public function test_username_is_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.username', '')
            ->call('save')
            ->assertHasErrors(['user.username' => 'required']);

        $this->assertNotEquals('', $user->refresh()->username);
    }

    public function test_username_is_max_32_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.username', str_repeat('a', 33))
            ->call('save')
            ->assertHasErrors(['user.username' => 'max']);
    }

    public function test_username_must_be_unique()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.username', $anotherUser->username)
            ->call('save')
            ->assertHasErrors(['user.username' => 'unique']);
    }

    public function test_username_rule_unique_ignores_current_user()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.username', $user->username)
            ->call('save')
            ->assertHasNoErrors(['user.username' => 'unique']);
    }

/*
|------------------ email --------------------------------------------------------
*/
    public function test_email_is_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.email', '')
            ->call('save')
            ->assertHasErrors(['user.email' => 'required']);
    }

    public function test_email_must_be_a_valid_email_address()
    {
        $user = User::factory()->create();

        $lv = Livewire::actingAs($user)
            ->test('profile');

        $lv->set('user.email', 'foobar')
            ->call('save')
            ->assertHasErrors(['user.email' => 'email']);

        $lv->set('user.email', 'foo@bar')
            ->call('save')
            ->assertHasErrors(['user.email' => 'email']);

        $lv->set('user.email', 'foo@bar.com')
            ->call('save')
            ->assertHasNoErrors(['user.email' => 'email']);
    }

    public function test_email_is_max_255_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.email', str_repeat('a', 256))
            ->call('save')
            ->assertHasErrors(['user.email' => 'max']);
    }

    public function test_email_rule_unique_ignores_current_user()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('user.email', $user->email)
            ->call('save')
            ->assertHasNoErrors(['user.email' => 'unique']);
    }

/*
|------------------ password --------------------------------------------------------
*/
    public function test_password_optional()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('password', '')
            ->call('save')
            ->assertHasNoErrors('password');
    }

    public function test_password_is_min_8_characters()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('password', str_repeat('a',7))
            ->call('save')
            ->assertHasErrors(['password' => 'min']);
    }

    public function test_password_confirmation_must_match_password()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('password', 'bizbar987')
            ->set('password_confirmation', 'foobar123')
            ->call('save')
            ->assertHasErrors(['password_confirmation' => 'same']);
    }

/*
|------------------ upload (avatar) --------------------------------------------------------
*/

    function test_upload_avatar_is_optional()
    {
        Storage::fake('avatars');

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile')
            ->set('upload', null)
            ->call('save')
            ->assertHasNoErrors('upload');

        $user->refresh();

        $this->assertNull($user->avatar);
        Storage::disk('avatars')->assertMissing($user->avatar);
    }

    /*
        Memo:
        Solved: Facade\Ignition\Exceptions\ViewException : This driver does not support creating temporary URLs.
        Use "$upload?->isPreviewable()" with if statement in blade views, or the file tests will fail with the message above. Only images has temporaryUrl() methods, which means only images is reviewable.
    */
    function test_upload_avatar_must_be_image()
    {
        Storage::fake('avatars');

        $user = User::factory()->create();

        $filetxt = UploadedFile::fake()->create('avatar.txt',1,'text/plain');
        $filepdf = UploadedFile::fake()->create('avatar.pdf',1,'application/pdf');


        $lv = Livewire::actingAs($user)
            ->test('profile');

        $lv->set('upload', $filetxt)
            ->call('save')
            ->assertHasErrors(['upload' => 'image'])
            ->assertHasErrors(['upload' => 'mimes']);



        $lv->set('upload', $filepdf)
            ->call('save')
            ->assertHasErrors(['upload' => 'image'])
            ->assertHasErrors(['upload' => 'mimes']);

        $user->refresh();

        $this->assertNull($user->avatar);
        Storage::disk('avatars')->assertMissing($user->avatar);
    }

    function test_upload_avatar_has_maximum_filesize()
    {
        Storage::fake('avatars');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('avatar.png',2049,'image/png');


        Livewire::actingAs($user)
            ->test('profile')
            ->set('upload', $file)
            ->call('save')
            ->assertHasNoErrors('max');

        $user->refresh();

        $this->assertNull($user->avatar);
        Storage::disk('avatars')->assertMissing($user->avatar);
    }

}
