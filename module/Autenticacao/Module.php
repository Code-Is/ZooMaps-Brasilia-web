<?php

/**
 * Classe referente configurações do módulo
 *
 * @author    Jerfeson Guerreiro
 * @category  Module
 * @package   Autenticacao
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */
namespace Autenticacao;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{

    /**
     * Inicialização default
     *
     * @param MvcEvent $e            
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Realiza include do arquivo de configuração do módulo
     *
     * @return void
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Retorna config de autoloader
     *
     * (non-PHPdoc)
     *
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     */
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

    /**
     * Retorna array com serviços para configuração do módulo
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function ($sm) {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                },
                'Autenticacao\Form\LoginForm' => function ($sm) {
                    return new \Autenticacao\Form\LoginForm($sm->get('EntityManager'));
                },                        
            )
        );
    }

    /**
     * Retornar factories de controllers
     *
     * @return array
     */
    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'Autenticacao\Controller\Login' => 'Autenticacao\Controller\LoginController'
            ),
            'factories' => array(
                
            )
        );
    }
}
