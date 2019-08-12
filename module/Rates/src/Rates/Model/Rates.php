<?php

namespace Rates\Model;

/**
 * Class Rates.
 *
 * @package Rates\Model
 */
class Rates
{
  public $id;
  public $rate;
  public $rates_to;
  public $rates_from;
  public $created_at;
  public $updated_at;

  /**
   * @param $data
   * @throws \Exception
   */
  public function exchangeArray($data)
  {
    $this->id         = $data['id'];
    $this->rate       = $data['rate'];
    $this->rates_to   = $data['rates_to'];
    $this->rates_from = $data['rates_from'];
    $this->created_at = !$data['id'] ? date("Y-m-d H:i:s") : $data['created_at'];
    $this->updated_at = date("Y-m-d H:i:s");
  }
}