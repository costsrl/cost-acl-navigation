<?php
namespace CostAclNavigation\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use CostAclNavigation\Navigation\MenuModulesNavigationMapper as Mapper;
use CostAclNavigation\Model\Entity\Menus as Menu;
use Laminas\ServiceManager\Factory\FactoryInterface;


class MenuModulesNavigationMapperFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $em = $container->get('doctrine.entitymanager.orm_default');
        $oMenuMapperByModule = new Mapper();
        $oMenuMapperByModule->setSource($em->getRepository('CostAclNavigation\Model\Entity\Menus'));
        return $oMenuMapperByModule;
    }

}

?>