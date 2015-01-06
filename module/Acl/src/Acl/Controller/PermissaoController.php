<?php
namespace Acl\Controller;

use Zend\View\Model\ViewModel;
use Certidao\Form\PedidoForm;
use Application\Controller\AbstractActionController;

class PermissaoController extends AbstractActionController
{

    public function indexAction()
    {
        if ($this->isDataTable()) {
            $dt = $this->getServiceLocator()->get('Acl\DataTable\PermissaoDataTable');
            $result = $dt->getResults();
            return $this->getResponse()->setContent($result);
        }
        
        $view = new ViewModel();
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        return $view;
    }

    public function visualizarAction()
    {
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PermissaoForm');
        
        $id = $this->params('id', 0);
        $object = $model->getRepository()->find($id);
        
        $form->bind($object);
        
        $view = new ViewModel(array(
            'form' => $form
        ));
        
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('acl/permissao/form');
        
        return $view;
    }

    public function atualizarAction()
    {
        $model = $this->getServiceLocator()->get('Acl\Model\PerfilModel');
        $form = $this->getServiceLocator()->get('Acl\Form\PermissaoForm');
        
        $id = $this->params('id', 0);
        $object = $model->getRepository()->find($id);
        
        $form->bind($object);
        
        try {
            $this->gravar($model, $form, 'Permissão atualizada com sucesso');
        } catch (\Exception $e) {
            $this->flashmessenger()->addErrorMessage($e->getMessage());
        }
        
        $view = new ViewModel(array(
            'form' => $form
        ));
        
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        $view->setTemplate('acl/permissao/form');
        
        return $view;
    }

    private function gravar($model, $form, $mensagem)
    {
        if ($this->getRequest()->isPost()) {
            
            $data = $this->getRequest()->getPost();
            
            $form->setData($data);
            
            if ($form->isValid()) {
                
                $dados = $form->getData();
                $model->save($dados);
                
                $this->flashmessenger()->addSuccessMessage($mensagem);
                return $this->redirect()->toRoute('acl', array(
                    'controller' => 'permissao',
                ));
            } else {
                throw new \Exception('Verifique os dados fornecidos');
            }
        }
    }
}