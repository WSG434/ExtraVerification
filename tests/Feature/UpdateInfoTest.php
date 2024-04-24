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

        $this->user=User::firstOrCreate([
            'name' => 'John Doe',
            'email' => 'John@Doe.com'
        ]);
        $this->user->update(['my_attribute' => 'default value']);
    }

    public function test_update_success(): void
    {
        $this->withoutExceptionHandling();


        $data = [
            'my_attribute' => 'new value',
        ];

        $CodeByUser = [
            'code' => 100100
        ];

        $verifyCode = $this->post(route('sendEmailVerification'), $this->user->toArray());
        $verifyCode->assertOk();

        $checkCode = $this->post(route('checkEmailVerification'), $CodeByUser);
        $checkCode->assertOk();

        $response = $this->patch(route('users.update', $this->user->id), $data);
        $response->assertOk();

        $response->assertJson([
            'my_attribute' => Arr::get($data,'my_attribute'),
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'my_attribute' => Arr::get($data,'my_attribute'),
        ]);
    }

//    public function test_update_failed(): void
//    {
//
//    }

}
