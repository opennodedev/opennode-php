<?php
namespace OpenNode\Merchant;

use OpenNode\OpenNode;
use OpenNode\Merchant;
use OpenNode\BadCredentials;

class Withdrawal extends Merchant
{
    private $withdrawal;

    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function toHash()
    {
        return $this->withdrawal;
    }

    public function __get($name)
    {
        return $this->withdrawal[$name];
    }

    public static function find($withdrawalId, $authentication = array())
    {
        try {
            return self::findOrFail($withdrawalId, $authentication);
        } catch (WithdrawalNotFound $e) {
            return false;
        }
    }

    public static function findOrFail($withdrawalId, $authentication = array())
    {
      try {
        $withdrawal = OpenNode::request('/withdrawal/' . $withdrawalId, 'GET', array(), $authentication);

        return new self($withdrawal);
      } catch (Exception $e) {

        throw $e;

      }
    }

    public static function findAll($authentication = array()){
      try {
        return self::findAllOrFail($authentication);
      }
      catch (BadCredentials $e) {
        return false;
      }
    }

    public static function findAllOrFail($authentication = array()){
        $withdrawals = OpenNode::request('/withdrawals', 'GET', array(), $authentication);

        foreach ($withdrawals as $withdrawal) {
          $withdrawal = new self($withdrawal);
        }

        return $withdrawals;
    }

    public static function create($params, $authentication = array())
    {
        try {
            return self::createOrFail($params, array(), $authentication);
        } catch (withdrawalIsNotValid $e) {
            return false;
        }
    }

    public static function createOrFail($params, $options = array(), $authentication = array())
    {
        $withdrawal = OpenNode::request('/withdrawals', 'POST', $params, $authentication);

        return new self($withdrawal);
    }
}
