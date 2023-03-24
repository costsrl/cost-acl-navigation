<?php
namespace CostAclNavigation;

$fixture = include("fixture.config.php");
return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__.'_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Model/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__.'\Model\Entity' =>  __NAMESPACE__.'_driver'
                ),
            ),
        ),
        'fixture' => [
            'CostAclNavigation' => __DIR__ . '/../src/Fixture'
        ]
    ),
    'table-gateway' => array(
        'map' => array(
            'menus'         => 'CostAclNavigation\Model\TableGateway\Menu',
        )
    ),
    'service_manager'=>array(
        'services'=>array(
            'menu_module_acl'=>array(
                'name'=>'admin_application'
            ),
            "menu-fixture"=> $fixture

        ),
        'factories'=>[
            'menu_module_navigation_mapper' => 'CostAclNavigation\Service\Factory\MenuModulesNavigationMapperFactory',
            'navigation_default'            => 'CostAclNavigation\Service\Factory\MenuAdminFactory'
        ]
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);