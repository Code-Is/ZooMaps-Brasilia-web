<?php
namespace Application\Event;

use Zend\Mvc\MvcEvent;

class RedirectEvent
{

    private $mvcEvent;

    public function cancelar(MvcEvent $e)
    {
        $this->mvcEvent = $e;
        
        $sm = $e->getApplication()->getServiceManager();
        $request = $sm->get('Request');
        $route = $e->getRouteMatch()->getMatchedRouteName();
        
        $this->isCancelar($route, $request);
    }

    /**
     * Verifica se o botão "Cancelar" no formulário foi acionado
     *
     * @return boolean
     */
    private function isCancelar($route, $request)
    {
        $post = $request->getPost();
        
        if (isset($post['button-cancelar']) || isset($post['botoes']['button-cancelar'])) {
            $this->mvcEvent->stopPropagation(true);
            $this->redirect($route);
            return true;
        }
        return false;
    }

    /**
     * Redirecionar para tela de login
     *
     * @param MvcEvent $event            
     * @return void
     */
    protected function redirect($route)
    {
        $event = $this->mvcEvent;
        
        $url = $event->getRouter()->assemble(array(
            'controller' => $this->getController()
        ), array(
            'name' => $route
        ));
        
        $response = $event->getResponse();
        $response->setStatusCode(302);
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->sendHeaders();
    }

    private function getController()
    {
        $e = $this->mvcEvent;
        $controller = $e->getRouteMatch()->getParam('__CONTROLLER__');
        
        return $controller;
    }
}