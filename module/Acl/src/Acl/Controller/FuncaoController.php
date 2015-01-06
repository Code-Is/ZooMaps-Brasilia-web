<?php

/**
 * Controller de funções.
 *
 * @author    Jerfeson Guerreiro
 * @category  Controller
 * @package   Acl/Controller
 * @copyright 2014 Code Is Sistemas
 * @version   6.0.0
 */
namespace Acl\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\Message;
use Zend\ServiceManager\ServiceLocatorInterface;

class FuncaoController extends AbstractActionController
{

    /**
     *
     * @var \Acl\Form\FuncaoForm
     */
    protected $form;

    /**
     *
     * @var \Acl\Model\FuncaoModel
     */
    protected $model;
    
    /**
     *
     * @var string
     */
    protected $message;
    
    /**
     *
     * @var string
     */
    public $titulo;
    
    /**
     *
     * @var string
     */
    public $route;
    
    /**
     * Model
     */
    public function __construct(ServiceLocatorInterface $sm)
    {
        $this->form = $sm->get('Acl\Form\FuncaoForm');
        $this->model = $sm->get('Acl\Model\FuncaoModel');
        $this->route = 'funcao';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
   	    if ($this->isDataTable()) {
            $dt = $this->getServiceLocator()->get('Acl\DataTable\FuncaoDataTable');
            $result = $dt->getResults();
            return $this->getResponse()->setContent($result);
        }
        
        $view = new ViewModel();
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        return $view;
    }

    /**
     * Inserir
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function inserirAction()
    {
        try {
        	$this->message = Message::CREATE_SUCCESS;
            $this->gravar();
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }
        
        $view = new ViewModel(array(
            'oForm' => $this->form,
        ));
        $view->setTemplate('acl/funcao/form');
        return $view;
    }
    
    /**
     * Visualizar
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function visualizarAction()
    {
    	$id = $this->params('id', 0);
        $funcao = $this->model->getRepository()->find($id);
        $this->form->bind($funcao);
    
    	$view = new ViewModel(array(
    		'oForm' => $this->form,
    	));
    
    	$view->setTemplate('acl/funcao/form');
    	return $view;
    }

    /**
     * Atualizar
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function atualizarAction()
    {
        $id = $this->params('id', 0);
        $funcao = $this->model->getRepository()->find($id);
        $this->form->bind($funcao);
        
        try {
        	$this->message = Message::UPDATE_SUCCESS;
            $this->gravar();
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }
        
        $view = new ViewModel(array(
            'oForm' => $this->form,
        ));
        $view->setTemplate('acl/funcao/form');
        return $view;
    }

    /**
     * Remover
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function removerAction()
    {
        $id = $this->params('id', 0);
        $funcao = $this->model->getRepository()->find($id);
        $this->form->bind($funcao);
        
        try {
            if ($this->request->isPost()) {
                $this->model->remove($funcao);
                $this->flashmessenger()->addSuccessMessage(Message::DELETE_SUCCESS);
                return $this->redirect()->toRoute('acl', array(
                    'controller' => $this->route,
                ));
            }
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }
        
        $view = new ViewModel(array(
            'oForm' => $this->form,
        ));
        $view->setTemplate('acl/funcao/form');
        return $view;
    }

    /**
     * Gravar
     * 
     * @throws \Exception
     * @return void
     */
    private function gravar()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $this->form->setData($data);
            
            if ($this->form->isValid()) {
                $this->model->save($this->form->getObject());
                $this->flashmessenger()->addSuccessMessage($this->message);
                $this->redirect()->toRoute('acl', array(
                	'controller' => $this->route
                ));
            } else {
                throw new \Exception(Message::FORM_INVALID);
            }
        }
    }
}

