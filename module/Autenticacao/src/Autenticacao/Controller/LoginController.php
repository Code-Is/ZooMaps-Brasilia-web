<?php

namespace Autenticacao\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Acl\Permissions\Acl;

class LoginController extends AbstractActionController
{

    /**
     * Formulario de login
     *
     * @var \Auth\Form\LoginForm
     */
    protected $form;

    /**
     * Objeto serviço de autenticação
     *
     * @var AuthenticationService
     */
    protected $authservice;

    /**
     * Objeto serviço de autenticação
     *
     * @var AclService
     */
    protected $aclService;

    /**
     * Retorna objeto serviço de autenticação
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    protected function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        }

        return $this->authservice;
    }

    /**
     * Retorna objeto serviço de autenticação
     *
     * @return \Acl\Event\AclEvent
     */
    protected function getAclService()
    {
        if (!$this->aclService) {
            $this->aclService = $this->getServiceLocator()->get('Acl\Event\AclEvent');
        }

        return $this->aclService;
    }

    /**
     * Retorna formulário de login
     *
     * @return \Auth\Form\LoginForm
     */
    protected function getForm()
    {
        if (!$this->form) {
            $this->form = $this->getServiceLocator()->get('Autenticacao\Form\LoginForm');
        }

        return $this->form;
    }

    /**
     *
     * @return type
     */
    public function indexAction()
    {
        return $this->forward()->dispatch('Autenticacao\Controller\Login', array('action' => 'autenticar'));
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function autenticarAction()
    {
        $form = $this->getForm();
        $data = $this->getRequest()->getPost();
        $form->setData($data);

        if ($form->isValid()) {

            // check authentication...
            $this->getAuthService()
                    ->getAdapter()
                    ->setIdentityValue($data['login'])
                    ->setCredentialValue($data['senha']);

            $result = $this->getAuthService()->authenticate();

            if ($result->isValid()) {

                $identity = $result->getIdentity();
                $this->getAuthService()->getStorage()->write($identity);
                // acl
                $acl = new Acl($identity->getPerfil());
                $this->getAclService()->getStorage()->write($acl);

                return $this->redirect()->toRoute('cadastro/default', array(
                    'controller' => 'index',
                ));
            } else {

                $this->flashmessenger()->addErrorMessage('Usuario ou senha incorretos');

//                foreach ($result->getMessages() as $message) {
//                    $this->flashmessenger()->addErrorMessage($message);
//                }
            }
        }

        $view = new ViewModel(array(
            'form' => $form
        ));

        $view->setTerminal(true);
        $view->setTemplate('autenticacao/login/index');

        return $view;
    }

    /**
     *
     * @return type
     */
    public function logoutAction()
    {
        $this->getAuthService()->clearIdentity();
        $this->getAclService()->clearAcl();

        return $this->redirect()->toRoute('login');
    }

}
