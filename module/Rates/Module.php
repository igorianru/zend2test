<?php

namespace Rates;

use Rates\Model\Rates;
use Rates\Model\RatesTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
  public function onBootstrap(MvcEvent $e)
  {
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);
  }

  public function getConfig()
  {
    return include __DIR__ . '/config/module.config.php';
  }

  public function getAutoloaderConfig()
  {
    return [
      'Zend\Loader\StandardAutoloader' => [
        'namespaces' => [
          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        ],
      ],
    ];
  }

  /**
   * @return array
   */
  public function getServiceConfig()
  {
    return array(
      'factories' => array(
        'Rates\Model\RatesTable' =>  function($sm) {
          $tableGateway = $sm->get('RatesTableGateway');
          $table = new RatesTable($tableGateway);
          return $table;
        },
        'RatesTableGateway' => function ($sm) {
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Rates());
          return new TableGateway('rates', $dbAdapter, null, $resultSetPrototype);
        },
      ),
    );
  }

}
