<?php

namespace Cadastro\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\AbstractActionController;
use Application\Common\Message;

class RecintoController extends AbstractActionController
{

    /**
     * Index
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $table = $this->getServiceLocator()->get('Cadastro\ZfTable\Recinto');
            return $this->getResponse()->setContent($table->render('html'));
        }

        $view = new ViewModel(array());
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
        $this->model = $this->getServiceLocator()->get('Cadastro\Model\RecintoModel');
        $this->form = $this->getServiceLocator()->get('Cadastro\Form\RecintoForm');

        try {
            $this->salvar(self::SAVE, Message::CREATE_SUCCESS, 'cadastro/default', array('controller' => 'recinto'));
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }

        $view = new ViewModel(array(
            'form' => $this->form
        ));

        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('cadastro/recinto/form');

        return $view;
    }

    /**
     * Visualizar
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function visualizarAction()
    {
        $this->model = $this->getServiceLocator()->get('Cadastro\Model\RecintoModel');
        $this->form = $this->getServiceLocator()->get('Cadastro\Form\RecintoForm');
        $this->formView();

        $id = $this->params('id', null);

        $this->object = $this->model->getRepository()->find($id);
        $this->form->bind($this->object);

        $view = new ViewModel(array(
            'form' => $this->form
        ));

        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('cadastro/recinto/form');

        return $view;
    }

    /**
     * Atualizar
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function atualizarAction()
    {
        $this->model = $this->getServiceLocator()->get('Cadastro\Model\RecintoModel');
        $this->form = $this->getServiceLocator()->get('Cadastro\Form\RecintoForm');

        $id = $this->params('id', null);

        $this->object = $this->model->getRepository()->find($id);
        $this->form->bind($this->object);

        try {
            $this->salvar(self::SAVE, Message::UPDATE_SUCCESS, 'cadastro/default', array('controller' => 'recinto'));
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }

        $view = new ViewModel(array(
            'form' => $this->form
        ));

        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('cadastro/recinto/form');

        return $view;
    }

    /**
     * Remover
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function removerAction()
    {
        $this->model = $this->getServiceLocator()->get('Cadastro\Model\RecintoModel');
        $this->form = $this->getServiceLocator()->get('Cadastro\Form\RecintoForm');
        $this->formRemove();

        $id = $this->params('id', null);

        $this->object = $this->model->getRepository()->find($id);
        $this->form->bind($this->object);

        try {
            $this->salvar(self::REMOVE, Message::DELETE_SUCCESS, 'cadastro/default', array('controller' => 'recinto'));
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }

        $view = new ViewModel(array(
            'form' => $this->form
        ));

        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('cadastro/recinto/form');

        return $view;
    }

}
