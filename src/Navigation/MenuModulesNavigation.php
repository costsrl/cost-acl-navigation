<?php
namespace CostAclNavigation\Navigation;

use Laminas\Navigation\Service\DefaultNavigationFactory;
use Laminas\Navigation\Page\AbstractPage as AbstractPage;
use Interop\Container\ContainerInterface;
use Laminas\Mvc\Router\Exception;

class MenuModulesNavigation extends DefaultNavigationFactory
{

    protected $module;

    protected $mapper;
    
    protected $serviceManager;

    /**
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     *
     * @param string $module            
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     *
     * @param object $mapper            
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Laminas\Navigation\Service\AbstractNavigationFactory::getPages()
     * Metodo che genera menu definito dalla tabella menus attraverso un mapper che usa doctrine/tablegatway
     * var @$container  Interop\Container\ContainerInterface
     */
    public function getPages(\Interop\Container\ContainerInterface $container)
    {
        $fetchMenu = array();
        if (null === $this->pages) {
            
            $fetchMenu = $this->getMapper()->getPages();
            
            foreach ($fetchMenu as $menu) {
                parse_str($menu->getParams(),$params);
                parse_str($menu->getQuery(),$query);
                
                $privilege_from_db = is_object($menu->getPermission()) ? $menu->getPermission()->getPrivilege() : $menu->getPermission();
                $privilege = explode(",", $privilege_from_db);
                
                if(in_array($menu->getAction(),$privilege)){
                    $privilege = $menu->getAction();
                }
                
                
                $menu_array[$menu->getParentId()][] = array(                                        
                    'menu_id' => $menu->getId(),
                    'id' => $menu->getId(),
                    'route' => $menu->getRoute(),
                    'controller' => $menu->getController(),
                    'action' => $menu->getAction(),
                    'resource' => $menu->getResource(),
                    'privilege' => $privilege,
                    'params'=> $params,
                    'query'=> $query,
                    'label' => $menu->getLabel(),
                    'name' => $menu->getName(),
                    'module' => $menu->getModule(),
                    'icon'  => $menu->getIcon(),
                    'class'  => $menu->getClass()
                );
            }



            
            $application = $this->getServiceManager()->get('Application');
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $routeName = $routeMatch->getMatchedRouteName();
            $router = $application->getMvcEvent()->getRouter();
            $container = new \Laminas\Navigation\Navigation();
            
            foreach ($menu_array as $key => $navigator) {
                foreach ($navigator as $nav) {
                     if (null == $nav['route'] || null==$routeMatch)
                        continue;
                    
                    if ($key == '0') {
                        try {
                            $page = AbstractPage::factory(array(
                                'menu_id' => $nav['menu_id'],
                                'id' => $nav['menu_id'],
                                'route' => $nav['route'],
                                'controller' => $nav['controller'],
                                'action' => $nav['action'],
                                'resource' => $nav['resource'],
                                'privilege' => $nav['privilege'],
                                'label' => $nav['label'],
                                'name' => $nav['name'],
                                'module' => $nav['module'],
                                'icon' =>$nav['icon'],
                                'class' =>$nav['class'],
                                'params'=> $nav['params'],
                                'query'=>$nav['query'],
                                'active'=> ($routeName == $nav['route']) ? true : false
                            ))->setRouter($router);


                        }
                        catch (Exception\RuntimeException $e) {
                            // dosomething
                            echo $e->getMessage();
                        }
                        
                        try {
                            if ($page->getHref()) {
                                // var_dump($page);
                                $container->addPage($page);
                            }
                        } catch (Exception\RuntimeException $e) {
                            // dosomething
                            echo $e->getMessage();
                        }
                    } else {
                        $find = $container->findBy('id', $key);
                        if (is_object($find)) {
                            try {
                                $page = $find->addPage(AbstractPage::factory(array(
                                    'menu_id' => $nav['menu_id'],
                                    'id' => $nav['menu_id'],
                                    'route' => $nav['route'],
                                    'controller' => $nav['controller'],
                                    'action' => $nav['action'],
                                    'resource' => $nav['resource'],
                                    'privilege' => $nav['privilege'],
                                    'label' => $nav['label'],
                                    'name' => $nav['name'],
                                    'module' => $nav['module'],
                                    'icon' =>$nav['icon'],
                                    'params'=> $nav['params'],
                                    'class' =>$nav['class'],
                                    'query'=>$nav['query'],
                                    'active'=> ($routeName == $nav['route']) ? true : false
                                ))->setRouter($router));

                                $rs =  ($routeName == $nav['route']) ? true : false;

                            } catch (Exception\RuntimeException $e) {
                                echo $e->getMessage();
                            }
                        }
                    }
                }
            }
            
            $this->pages = $container;
        }
        return $this->pages;
    }

    public function injectRouter($navigation, $router)
    {
        foreach ($navigation->getPages() as $page) {
            if ($page instanceof \Laminas\Navigation\Page\Mvc) {
                $page->setDefaultRouter($router);
            }
            
            if ($page->hasPages()) {
                $this->injectRouter($page, $router);
            }
        }
        
        return $navigation;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
 
}

?>