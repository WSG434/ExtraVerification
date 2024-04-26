<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
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


    public function test_sendVerificationCode_success(): void
    {
        $this->withoutExceptionHandling();

        $verifyCode = $this->post(route('sendVerificationCode'),
            [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'verification_type' => 'Email'
            ]);
        $verifyCode->assertOk();
    }

    public function test_checkVerificationCode_success(): void
    {
        $this->withoutExceptionHandling();

        $this->post(route('sendVerificationCode'), $this->user->toArray());

        $CodeByUser = [
            'code' => $this->user->verification_code->where('expires_at','>=', Carbon::now())->sortByDesc('expires_at')->first()->code
        ];

        $checkCode = $this->post(route('checkEmailVerification'), $CodeByUser);
        $checkCode->assertOk();
        $this->assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'extra_verified_expires_at' => Carbon::parse(json_decode($checkCode->getContent()), true)->setTimezone(env('APP_TIMEZONE', 'Europe/Moscow'))
        ]);
    }

    public function test_update_success(): void
    {
        $this->withoutExceptionHandling();

        $formData = [
            'my_attribute' => 'new value',
        ];

        $response = $this->patch(route('updateProtectedFields'), $formData);
        $response->assertOk();

        $response->assertJson([
            'my_attribute' => Arr::get($formData,'my_attribute'),
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'my_attribute' => Arr::get($formData,'my_attribute'),
        ]);
    }




}
