<?php
namespace OpenNode\Merchant;

use OpenNode\OpenNode;
use OpenNode\Merchant;
use OpenNode\ChargeIsNotValid;
use OpenNode\ChargeNotFound;
use OpenNode\BadCredentials;

class Charge extends Merchant
{
    private $charge;

    public function __construct($charge)
    {
        $this->charge = $charge;
    }

    public function toHash()
    {
        return $this->charge;
    }

    public function __get($name)
    {
        return $this->charge[$name];
    }

    public static function find($chargeId, $options = array(), $authentication = array())
    {
        try {
            return self::findOrFail($chargeId, $options, $authentication);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function findOrFail($chargeId, $options = array(), $authentication = array())
    {
        $charge = OpenNode::request('/charge/' . $chargeId, 'GET', array(), $authentication);

        return new self($charge);
    }

    public static function findAllPaid($authentication = array()){
      try {
        return self::findAllPaidOrFail($authentication);
      }
      catch (Exception $e) {
        return false;
      }
    }

    public static function findAllPaidOrFail($authentication = array()){
        $charges = OpenNode::request('/charges', 'GET', array(), $authentication);

        foreach ($charges as $charge) {
          $charge = new self($charge);
        }

        return $charges;
    }

    public static function create($params, $authentication = array())
    {
        try {
            return self::createOrFail($params, array(), $authentication);
        } catch (ChargeIsNotValid $e) {
            return false;
        }
    }

    public static function createOrFail($params, $options = array(), $authentication = array())
    {
        $charge = OpenNode::request('/charges', 'POST', $params, $authentication);

        return new self($charge);
    }
}
