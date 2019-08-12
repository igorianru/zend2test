<?php

namespace Rates\Controller;

use Rates\Model\Rates;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController.
 *
 * @package Rates\Controller
 */
class IndexController extends AbstractActionController
{
  /**
   * @var
   */
  protected $ratesTable;


  public $currencies = [
    'USD' => 'R01235',
    'EUR' => 'R01239',
  ];

  public function indexAction()
  {
    return new ViewModel();
  }

  public function getRatesTable()
  {
    if (!$this->ratesTable) {
      $sm = $this->getServiceLocator();
      $this->ratesTable = $sm->get('Rates\Model\RatesTable');
    }

    return $this->ratesTable;
  }

  /**
   * Update Currency.
   */
  public function updateCurrencyAction()
  {
    try {
    $from          = date('d/m/Y', strtotime('today'));
    $till          = date('d/m/Y', strtotime('today'));
    $from_currency = 'RUR';

      foreach($this->currencies as $key => $currency) {
        $url = 'http://www.cbr.ru/scripts/XML_dynamic.asp?' . http_build_query(
            [
              'date_req1' => $from,
              'date_req2' => $till,
              'VAL_NM_RQ' => $currency,
            ]
          );

        $context = stream_context_create(
          [
            'http' => [
              'max_redirects' => 101,
            ],
          ]
        );

        $rate     = $this->getRatesTable()->getRateFromTo($key, $from_currency);
        $response = simplexml_load_string(file_get_contents($url, false, $context));



        if(isset($response->Record)) {
          if(!$rate)
            $rate = new Rates();

          $rate->rates_from = $key;
          $rate->rates_to   = $from_currency;
          $rate->rate       = floatval(str_replace(',', '.', $response->Record->Value) / $response->Record->Nominal);

          $this->getRatesTable()->saveRate($rate);
        }
      }

      return new ViewModel(['rates' => $this->getRatesTable()->fetchAll()]);
    } catch(\Exception $ex) {
      $ex->getMessage();
    }
  }
}
