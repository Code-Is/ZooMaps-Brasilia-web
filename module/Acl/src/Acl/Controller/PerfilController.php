<?php
namespace Acl\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\QueryBuilder;

class PerfilController extends AbstractActionController
{

    public function indexAction()
    {
    	if ($this->isDataTable()) {
    		$dt = $this->getServiceLocator()->get('Acl\DataTable\PerfilDataTable');
    		
    		$dt->addComplemento(function(QueryBuilder $qb) {
    			$expr = $qb->expr();
    			$qb->join('Perfil.instituicao', 'Instituicao');
    			$qb->where($expr->andX($expr->eq('Instituicao.id', "'" . $this->getInstituicao()->getId() . "'")));
    		});   
    		 		
    		$result = $dt->getResults();
    		return $this->getResponse()->setContent($result);
    	}
    
    	$view = new ViewModel();
    	$view->setTerminal($this->getRequest()->isXmlHttpRequest());
    	return $view;
    }
    
    public function inserirAction()
    {
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PerfilForm');
    
        $form->getObject()->addInstituicao($this->getInstituicao());
        
    	$id = $this->params('id', 0);
    	$object = $model->getRepository()->find($id);
    
    	try {
    		$this->salvar($model, $form, self::SAVE, 'Perfil cadastrado com sucesso');
    	} catch (\Exception $e) {
    		$this->flashmessenger()->addErrorMessage($e->getMessage());
    	}
    
    	$view = new ViewModel(array(
			'form' => $form
    	));
    
    	$view->setTerminal($this->getRequest()->isXmlHttpRequest());
    	$view->setTemplate('acl/perfil/form');
    
    	return $view;
    }
    
    public function visualizarAction()
    {
        if ($this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('acl', array(
                'controller' => 'perfil'
            ));
        }    
        		  
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PerfilForm');
    
    	$id = $this->params('id', 0);
    	$object = $model->getRepository()->find($id);
    
    	$form->bind($object);
    
    	$view = new ViewModel(array(
			'form' => $form
    	));
    
    	$view->setTerminal($this->getRequest()->isXmlHttpRequest());
    	$view->setTemplate('acl/perfil/form');
    
    	return $view;
    }
    
    public function atualizarAction()
    {
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PerfilForm');
    
    	$id = $this->params('id', 0);
    	$object = $model->getRepository()->find($id);
    
    	$form->bind($object);
    
    	try {
    		$this->salvar($model, $form, self::SAVE,  'Perfil atualizado com sucesso');
    	} catch (\Exception $e) {
    		$this->flashmessenger()->addErrorMessage($e->getMessage());
    	}
    
    	$view = new ViewModel(array(
    			'form' => $form
    	));
    
    	$view->setTerminal($this->getRequest()->isXmlHttpRequest());
    	$view->setTemplate('acl/perfil/form');
    
    	return $view;
    }
    
    public function removerAction()
    {
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PerfilForm');
    
    	$id = $this->params('id', 0);
    	$object = $model->getRepository()->find($id);
    
    	$form->bind($object);
    
    	try {
    		$this->salvar($model, $form, self::REMOVE,  'Perfil removido com sucesso');
    	} catch (\Exception $e) {
    		$this->flashmessenger()->addErrorMessage($e->getMessage());
    	}
    
    	$view = new ViewModel(array(
    			'form' => $form
    	));
    
    	$view->setTerminal($this->getRequest()->isXmlHttpRequest());
    	$view->setTemplate('acl/perfil/form');
    
    	return $view;
    }
    
    private function salvar($model, $form, $metodo, $mensagem)
    {
    	if ($this->getRequest()->isPost()) {
    
    		$data = $this->getRequest()->getPost();
    		$form->setData($data);
    
    		if ($form->isValid()) {
    
    			$dados = $form->getData();
    			$model->$metodo($dados);
    
    			$this->flashmessenger()->addSuccessMessage($mensagem);
    			return $this->redirect()->toRoute('acl', array(
					'controller' => 'perfil'
    			));
    		} else {
    			throw new \Exception('Verifique os dados fornecidos');
    		}
    	}
    }
}