<?php
/**
 * Created by PhpStorm.
 * User: renato
 * Date: 05/04/18
 * Time: 14.46
 */

namespace CostAclNavigation\Fixture;

use CostAclNavigation\Model\Entity\Menus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CostAuthentication\Container\ContainerAwareTrait;
use CostAuthentication\Container\ContainerAwareInterface;



class AclNavigationFixture extends AbstractFixture implements FixtureInterface,OrderedFixtureInterface,ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $aMenuFixture = $this->container->get('menu-fixture');

        foreach ($aMenuFixture as $name => $menu){
            if($menu["parent"]) {
                $oParent = $this->getReference("menu-${menu['parent']}");
                if($oParent instanceof Menus){
                    $idParent = $oParent->getId();
                }
            }
            else $idParent = 0;

            $oPrivilege     = $this->getReference("permission-${menu['permission']}");
            $eMenu          = new Menus();
            $eMenu->setName($name);
            $eMenu->setLabel($menu["label"]);
            $eMenu->setController($menu["controller"]);
            $eMenu->setAction($menu["action"]);
            $eMenu->setRoute($menu["ruote"]);
            $eMenu->setModule($menu["module"]);
            $eMenu->setParentId($idParent);
            $eMenu->setResource($menu["resource"]);
            $eMenu->setPrivilege($oPrivilege);
            $eMenu->setQuery($menu["query"]);
            $eMenu->setClass($menu["class"]);
            $eMenu->setParams($menu["params"]);
            $eMenu->setIcon($menu["icon"]);
            $eMenu->setOrder($menu["sort"]);
            $manager->persist($eMenu);
            $this->addReference("menu-$name", $eMenu);
            $manager->flush();
        }
    }


    public function getOrder(){
        return 5;
    }
}