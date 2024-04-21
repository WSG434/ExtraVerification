<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UpdateInfoTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->user=User::find(1);
        $this->user->update(['name'=>'default value']);

    }

    public function test_update_success(): void
    {
        $data = [
            'name' => 'New value',
        ];

        $verifyCode = $this->post(route('sendEmailVerification', $this->user->id));
        $checkCode = $this->post(route('checkEmailVerification'));

        $checkCode->assertOk();

        $response = $this->patch(route('users.update', $this->user->id), $data);

        $response->assertOk();

        $response->assertJson([
            'name' => Arr::get($data,'name'),
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'name' => Arr::get($data,'name'),
        ]);
    }

    public function test_update_failed(): void
    {

    }

}
