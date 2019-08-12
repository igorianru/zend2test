<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rates;

return [
  'router' => [
    'routes' => [
      'home'  => [
        'type'    => 'Zend\Mvc\Router\Http\Literal',
        'options' => [
          'route'    => '/',
          'defaults' => [
            'controller' => 'Rates\Controller\Index',
            'action'     => 'updateCurrency',
          ],
        ],
      ],

      'update-currency' => [
        'type'    => 'segment',
        'options' => [
          'route'       => '/update-currency',
          'defaults'    => [
            'controller' => 'Rates\Controller\Index',
            'action'     => 'updateCurrency',
          ],
        ],
      ],
    ],
  ],

  'controllers'  => [
    'invokables' => [
      'Rates\Controller\Index' => Controller\IndexController::class,
    ],
  ],
  'view_manager' => [
    'display_not_found_reason' => true,
    'display_exceptions'       => true,
    'doctype'                  => 'HTML5',
    'not_found_template'       => 'error/404',
    'exception_template'       => 'error/index',
    'template_map'             => [
      'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
      'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
      'error/404'               => __DIR__ . '/../view/error/404.phtml',
      'error/index'             => __DIR__ . '/../view/error/index.phtml',
    ],
    'template_path_stack'      => [
      __DIR__ . '/../view',
    ],
  ],

  // Placeholder for console routes
  'console'      => [
    'router' => [
      'routes' => [
      ],
    ],
  ],
];
