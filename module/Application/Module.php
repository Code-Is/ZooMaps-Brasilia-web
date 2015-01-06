<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);        
        
        // evento do botao cancelar
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            new \Application\Event\RedirectEvent(),
            'cancelar'
        ), 10);
        
        $em = $e->getApplication()
            ->getServiceManager()
            ->get('EntityManager');
        
        $conn = $em->getConnection();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        
        $translator = $e->getApplication()
            ->getServiceManager()
            ->get('translator');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'menuCreator' => function ($sm) {
                    $helper = new \Application\View\Helper\MenuCreator($sm);
                    return $helper;
                },
                'listaBanco' => function ($sm) {
                    $helper = new \Application\View\Helper\ListaBanco($sm);
                    return $helper;
                },
                'mask' => function ($val, $mask) {
                    $mask = new \Application\View\Helper\Mask($val, $mask);
                    return $mask;
                }
            ),
            'invokables' => array()
            // 'formataCPF' => new View\Helper\FormataCPF(),
            
        );
    }
}
