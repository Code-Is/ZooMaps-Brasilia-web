<?php

/**
 * Classe de configuração do modulo
 *
 * @author    Jerfeson Guerreiro
 * @category  Module
 * @package   Acl
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */
namespace Acl;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\StaticEventManager;
use Acl\Event\AclEvent;
use Acl\Model\PerfilModel;
use Acl\Form\PermissaoForm;
use Acl\Form\PerfilForm;
use Acl\Controller\FuncaoController;
use Acl\Model\FuncaoModel;
use Acl\Form\FuncaoForm;
use Acl\DataTable\FuncaoDataTable;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array(
            $this,
            'eventAcl'
        ));
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

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'EntityManager' => 'Doctrine\ORM\EntityManager'
            ),
            'factories' => array(
                'Acl\Event\AclEvent' => function ($sm)
                {
                    $acl = new AclEvent();
                    $acl->setAuthService($sm->get('Zend\Authentication\AuthenticationService'));
                    return $acl;
                },
                /**
                 * Model Factories
                 */
                'Acl\Model\PerfilModel' => function ($sm)
                {
                    return new PerfilModel($sm->get('EntityManager'));
                },
                'Acl\Model\FuncaoModel' => function ($sm)
                {
                	return new FuncaoModel($sm->get('EntityManager'));
                },                
                /**
                 * Form Factories
                 */
                'Acl\Form\FuncaoForm' => function ($sm)
                {
                	$form = new FuncaoForm($sm->get('EntityManager'));
                	$form->setInputFilter($sm->get('Acl\Model\FuncaoModel')->getInputFilter());
                	return $form;
                },                
                'Acl\Form\PermissaoForm' => function ($sm)
                {
                    return new PermissaoForm($sm->get('EntityManager'));
                },
                'Acl\Form\PerfilForm' => function ($sm)
                {
                    $autuService = $sm->get('Zend\Authentication\AuthenticationService');
                    $identity = $autuService->getIdentity();
                    
                    $form = new PerfilForm($sm->get('EntityManager'), $identity);
                    
                    return $form;
                },               
            )
        );
    }

    /**
     * Evento de validação ACL
     *
     * @param MvcEvent $event            
     * @return mixed
     */
    public function eventAcl(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        $acl = $sm->get('Acl\Event\AclEvent');
        return $acl->preDispatch($event);
    }

    /**
     * Retornar factories de controllers
     *
     * @return array
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Acl\Controller\Funcao' => function ($controllerManager)
                {
                    $sm = $controllerManager->getServiceLocator();
                    $controller = new FuncaoController($sm);
                    return $controller;
                }
            )
        );
    }
}
