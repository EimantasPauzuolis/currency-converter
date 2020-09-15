<?php

namespace Tests\Feature;

use App\Conversion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ConversionApiTest extends TestCase
{
    use RefreshDatabase {
        refreshDatabase as parentRefresh;
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testReturnsCorrectCurrencyCodes()
    {
        $expectedArray = json_encode(Config::get('currency'));
        $response = $this->getJson('/api/codes');

        $this->assertEquals(200, $response->status());

        $this->assertEqualsCanonicalizing($expectedArray, $response->getContent());
    }
    public function testSuccessResponseGettingConversions()
    {
        $user = factory(User::class)->make();
        $user->save();
        $conversions = factory(Conversion::class, 3)->make();
        $user->conversions()->saveMany($conversions);

        $this->actingAs($user);
        $response = $this->getJson('/api/conversions');

        $this->assertEquals(200, $response->status());
        $this->assertEquals(3, count(json_decode($response->getContent())));
    }
    public function testConversionsUnavailableForUnauthenticatedUsers()
    {
        $response = $this->getJson('/api/conversions');
        $this->assertEquals(401, $response->status());
    }
    public function testSuccessStatusWhenCreatingConversion()
    {
        $user = factory(User::class)->make();
        $user->save();
        $this->actingAs($user);
        $conversion = $conversion = factory(Conversion::class)->states('request')->make();
        $response = $this->postJson('/api/conversion', $conversion->toArray());
        $this->assertEquals(200, $response->status());
    }
    public function testReturnErrorsWhenCreationDataInvalid()
    {
        $user = factory(User::class)->make();
        $user->save();
        $this->actingAs($user);
        $dummy = [
            'field' => 'value',
            'field2' => 'value2'
        ];
        $response = $this->postJson('/api/conversion', $dummy);
        $this->assertEquals(422, $response->status());
    }
    public function testCanUpdateOnlyOwnConversions()
    {
        $conversion = factory(Conversion::class)->make();
        $userA = factory(User::class)->make();
        $userA->save();
        $userA->conversions()->save($conversion);

        $requestConversion = factory(Conversion::class)->states('request')->make();
        $requestFields = collect($requestConversion)->only(['source', 'target', 'value']);
        unset($conversion['sourceCurrency']);
        unset($conversion['targetCurrency']);
        unset($conversion['amount']);

        $requestModel = collect($requestConversion)->merge($requestFields);
        $this->actingAs($userA);

        $response = $this->postJson('/api/conversion/' . $conversion->id, $requestModel->toArray());

        $this->assertEquals(200, $response->status());

        $userB = factory(User::class)->make();
        $userB->save();

        $this->actingAs($userB);

        $response = $this->postJson('/api/conversion/' . $conversion->id, $requestModel->toArray());

        $this->assertEquals(403, $response->status());
    }
}
