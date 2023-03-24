<?php
namespace CostAclNavigation\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use CostAclNavigation\Navigation\MenuModulesNavigation as MenuModule;

class MenuAdminFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $aConfigMenu = $container->get('menu_module_acl');
        $oMapper     = $container->get('menu_module_navigation_mapper');
        $menuModule  = new MenuModule();
        $menuModule->setModule($aConfigMenu['name']);
        $menuModule->setMapper($oMapper);
        $menuModule->setServiceManager($container);
        return $menuModule->createService($container);
    }
}

?>