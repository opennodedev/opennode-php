<?php
namespace OpenNode;

class WithdrawalTest extends \PHPUnit\Framework\TestCase
{
    public function testGetWithdrawalNotFound()
    {
        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Withdrawal::find(0, self::getReadAuthParams()));

        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Withdrawal::findOrFail(0, self::getReadAuthParams()));

    }

    public function testGetWithdrawal()
    {
        $order = Merchant\Withdrawal::create(self::getWithdrawalParams(), self::getWriteAuthParams());
        $this->assertNotFalse(Merchant\Withdrawal::find($order->id, self::getWriteAuthParams()));
    }



    public function testCreateInvalidWithdrawal()
    {
        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Withdrawal::create(array(), self::getWriteAuthParams()));
        sleep(3);
        $this->expectException(BadRequest::class);
        $this->assertFalse(Merchant\Withdrawal::createOrFail(array(), self::getWriteAuthParams()));
    }

    public function testCreateUnauthorizedWitdrawal()
    {
        $this->expectException(Unauthorized::class);
        $this->assertFalse(Merchant\Withdrawal::create(array(), self::getReadAuthParams()));
        sleep(3);
        $this->expectException(Unauthorized::class);
        $this->assertFalse(Merchant\Withdrawal::createOrFail(array(), self::getReadAuthParams()));
        sleep(3);

    }

    public function testCreateValidWithdrawal()
    {
        $this->assertNotFalse(Merchant\Withdrawal::create(self::getWithdrawalParams(), self::getWriteAuthParams()));
    }

    public static function getReadAuthParams() {
      return array(
        'environment' => 'dev',
        'auth_token'  => '2114c54b-81a4-491f-9522-2fb75de53efc'
      );
    }

    public static function getWriteAuthParams() {
      return array(
        'environment' => 'dev',
        'auth_token'  => '4f36591a-a909-4d06-86f0-064068969c8d'
      );
    }

    public static function getWithdrawalParams() {
        return array(
          'type'    =>  'chain',
          'amount'  =>  350000, //Satoshis
          'address' =>  'tb1qmjr60qjf2aw850g99hdvsl3kmgzn74ehenu33j'
        );
    }
}
