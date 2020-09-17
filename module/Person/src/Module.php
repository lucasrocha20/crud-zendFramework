<?php

namespace Person;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Person\Controller\PersonController;

class Module implements ConfigProviderInterface {
 
    public function getConfig() 
    {
        return include __DIR__ . "/../config/module.config.php";
    }

    public function getServiceConfig() {
        return [
            'factories' => [
                Model\PersonTable::class => function($container) {
                    $tableGateway = $container->get(Model\PersonTableGateway::class);
                    return new Model\PersonTable($tableGateway);
                },
                Model\PersonTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Person());
                    return new TableGateway('person', $dbAdapter, null, $resultSetPrototype);
                }
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                PersonController::class => function($container) {
                    $tableGateway = $container->get(Model\PersonTable::class);
                    return new PersonController($tableGateway);
                }
            ]
        ];
    }
}