<?php
namespace CostAclNavigation;

use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Console\Request as ConsoleRequest;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../src/' . __NAMESPACE__
                )
            )
        );
    }
    
    
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setAclMenuNavigation'), -120);
    }
    
    
    public function setAclMenuNavigation(MvcEvent $event)
    {
        $services       = $event->getApplication()->getServiceManager();
        $config         = $services->get('config');
        $request        = $event->getRequest();

        if ($request instanceof ConsoleRequest) {
            return true;
        }
    
        $authService    = $services->get('Laminas\Authentication\AuthenticationService');
        $oAcl           = $services->get('aclDoctrine');
    
        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity();
            $sRole = $user->getRole()->getName();
        }
        else
            $sRole = \CostAuthorization\Acl\Acl::DEFAULT_ROLE; // The default role is guest $acl
       
        
        \Laminas\View\Helper\Navigation\AbstractHelper::setDefaultAcl($oAcl);
        \Laminas\View\Helper\Navigation\AbstractHelper::setDefaultRole($sRole);
    
    }
}