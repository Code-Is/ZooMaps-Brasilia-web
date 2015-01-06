<?php

/**
 * Acl do sistema 
 *
 * @author    Jerfeson Guerreiro
 * @category  Event
 * @package   Acl/Event
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */
namespace Acl\Event;

use Zend\Mvc\MvcEvent as MvcEvent, Zend\Authentication\AuthenticationService as AuthService, Zend\Authentication\Storage\Session;
use Acl\Permissions\Acl as Acl;

class AclEvent
{

    /**
     * Rota padrão de redirecionamento para autenticação
     *
     * @var string
     */
    const ROUTE_DEFAULT = 'login';

    /**
     * Rota padrão de redirecionamento para não permitido
     *
     * @var string
     */
    const ROUTE_ERROR = 'permissao';

    /**
     * Rotas permitidas por default
     *
     * @var string
     */
    public static $ROUTES_ALLOW = array(
        'login',
        'login/autenticar',
        'login/logout',
        'permissao',
        'home',
        'lista',
    );

    /**
     *
     * @var AuthService
     */
    protected $auth = null;

    /**
     *
     * @var Acl\Permissions\Acl
     */
    protected $acl = null;

    /**
     * Persistent storage handler
     *
     * @var \Zend\Authentication\Storage\StorageInterface
     */
    protected $storage = null;

    /**
     * preDispatch Event Handler
     *
     * @param \Zend\Mvc\MvcEvent $event            
     * @throws \Exception
     */
    public function preDispatch(MvcEvent $event)
    {       
        $routeMatch = $event->getRouteMatch();
        
        if (in_array($routeMatch->getMatchedRouteName(), self::$ROUTES_ALLOW) || $this->isSapiCli()) {
            return true;
        }
        
        $auth = $this->getAuthService();
        
        if (! $auth->hasIdentity()) {
            $this->redirect($event, self::ROUTE_DEFAULT);
        }
        
        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');
        
//         if(md5($auth->getIdentity()->getLogin()) == $auth->getIdentity()->getSenha()){
//             if($controller == 'Cadastro\Controller\Parametro' && $action == 'senha') {
//                 return;
//             }
//             $this->redirect($event, 'alterar-senha');
//         }        
        
        if (! $this->isAllowed($controller, $action)) {
            $this->redirect($event);
        }
    }

    /**
     * Tem permissão de acesso?
     *
     * @param string $controller            
     * @param string $action            
     * @return boolean
     */
    public function isAllowed($controller, $action)
    {
        $acl = $this->getAcl();
        $auth = $this->getAuthService();
        $role = $auth->getIdentity()->getPerfil()->getId();
        
        if (! $acl->hasResource($controller)) {
            return false;
        }
        
        if (! $acl->isAllowed($role, $controller, $action)) {
            return false;
        }
        
        return true;
    }

    /**
     * Redirecionar para tela de login
     *
     * @param MvcEvent $event            
     * @return void
     */
    protected function redirect(MvcEvent $event, $route = self::ROUTE_ERROR)
    {
        $url = $event->getRouter()->assemble(array(), array(
            'name' => $route
        ));
        $response = $event->getResponse();
        $response->setStatusCode(302);
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->sendHeaders();
        exit();
    }

    /**
     * Set Authentication Plugin
     *
     * @param \User\Controller\Plugin\UserAuthentication $authenticationPlugin            
     * @return Authentication
     */
    public function setAuthService(AuthService $authenticationPlugin)
    {
        $this->auth = $authenticationPlugin;
        return $this;
    }

    /**
     * Get Authentication Plugin
     *
     * @return \User\Controller\Plugin\UserAuthentication
     */
    public function getAuthService()
    {
        return $this->auth;
    }

    /**
     * Retornar storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Session(__NAMESPACE__, 'Acl_Storage'));
        }
        return $this->storage;
    }

    /**
     * Set storage handler
     *
     * @param \Zend\Authentication\Storage\StorageInterface $storage            
     * @return AuthenticationService Provides a fluent interface
     */
    public function setStorage(\Zend\Authentication\Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Retornar se objeto ACL já está armazenado
     *
     * @return bool
     */
    public function hasAcl()
    {
        return ! $this->getStorage()->isEmpty();
    }

    /**
     * Retornar storage ou null se objeto ACL não armazenado
     *
     * @return \Acl\Permissions\Acl
     */
    public function getAcl()
    {
        $storage = $this->getStorage();
        
        if ($storage->isEmpty()) {
            return null;
        }
        
        return $storage->read();
    }

    /**
     * Apagar ACL do storage
     *
     * @return void
     */
    public function clearAcl()
    {
        $this->getStorage()->clear();
    }

    /**
     */
    private function isSapiCli()
    {
        return php_sapi_name() == 'cli';
    }

    public function teste()
    {
        return 'opz';
    }
}
