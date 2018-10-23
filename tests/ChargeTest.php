<?php
namespace OpenNode;

class ChargeTest extends \PHPUnit\Framework\TestCase
{
    public function testGetChargeNotFound()
    {
        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Charge::find(0, array(), self::getAuthParams()));

        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Charge::findOrFail(0, array(), self::getAuthParams()));
    }

    public function testGetCharge()
    {
        $order = Merchant\Charge::create(self::getChargeParams(), self::getAuthParams());
        $this->assertNotFalse(Merchant\Charge::find($order->id, array(), self::getAuthParams()));
    }

    public function testCreateInvalidCharge()
    {
        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Charge::create(array(), self::getAuthParams()));

        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Charge::createOrFail(array(), self::getGoodAugetAuthParamsthentication()));

    }

    public function testCreateValidCharge()
    {
        $this->assertNotFalse(Merchant\Charge::create(self::getChargeParams(), self::getAuthParams()));
    }

    public static function getAuthParams() {
      return array(
        'environment'               => 'dev',
        'auth_token'                => '2114c54b-81a4-491f-9522-2fb75de53efc'
      );
    }

    public static function getChargeParams() {
        return array(
          'amount' => 100000, //In Satoshis
          'description' => '1x Melo',
          'success_url' => 'https://google.com'
        );
    }
}
