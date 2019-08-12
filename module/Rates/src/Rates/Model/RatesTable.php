<?php

namespace Rates\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class RatesTable
{
  /**
   * @var TableGateway
   */
  protected $tableGateway;

  /**
   * RatesTable constructor.
   * @param TableGateway $tableGateway
   */
  public function __construct(TableGateway $tableGateway)
  {
    $this->tableGateway = $tableGateway;
  }

  /**
   * Get All Rates.
   *
   * @return \Zend\Db\ResultSet\ResultSet
   */
  public function fetchAll()
  {
    return $this->tableGateway->select();
  }

  public function getRateFromTo($rates_from, $rates_to)
  {
    return $this->tableGateway->select(
      function(Select $select) use ($rates_from, $rates_to) {
        $select->where->equalTo('rates_from', $rates_from);
        $select->where->equalTo('rates_to', $rates_to);
      }
    )->current();
  }

  /**
   * Create or Update Rate.
   *
   * @param Rates $rates
   * @throws \Exception
   */
  public function saveRate(Rates $rates)
  {
    $data = [
      'rate'       => $rates->rate,
      'rates_to'   => $rates->rates_to,
      'rates_from' => $rates->rates_from,
      'created_at' => $rates->created_at,
      'updated_at' => $rates->updated_at,
    ];

    $id = (int) $rates->id;

    if($id == 0) {
      $this->tableGateway->insert($data);
    } else {
      if($this->getRate($id)) {
        $this->tableGateway->update($data, ['id' => $id]);
      } else {
        throw new \Exception('Rate id does not exist');
      }
    }
  }

  /**
   * Get Rate By ID.
   *
   * @param $id
   * @return array|\ArrayObject|null
   * @throws \Exception
   */
  public function getRate($id)
  {
    $id  = (int) $id;
    $row = $this->tableGateway->select(['id' => $id])->current();

    if(!$row) {
      throw new \Exception("Could not find row $id");
    }

    return $row;
  }

  /**
   * Delete Rate row.
   *
   * @param $id
   */
  public function deleteRate($id)
  {
    $this->tableGateway->delete(['id' => (int) $id]);
  }
}