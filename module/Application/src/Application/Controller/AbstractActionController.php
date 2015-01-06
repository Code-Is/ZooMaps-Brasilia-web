<?php
namespace Application\Controller;

use Application\Common\Message;

abstract class AbstractActionController extends \Zend\Mvc\Controller\AbstractActionController
{

    const SAVE = 'save';

    const REMOVE = 'remove';

    /**
     * Form
     * 
     * @var \Zend\Form\Form
     */
    protected $form;

    /**
     * Model
     * 
     * @var \Application\Model\Model
     */
    protected $model;

    /**
     * Retorna o usuário atual
     *
     * @return \Autenticacao\Entity\Usuario
     */
    protected function getIdentity()
    {
        $autuService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $identity = $autuService->getIdentity();
        
        return $identity;
    }

    /**
     * Retorna a instituição atual
     *
     * @return \Cadastro\Entity\Instituicao
     */
    protected function getInstituicao()
    {
        $identity = $this->getIdentity();
        return $identity->getInstituicao();
    }

    /**
     *
     * @param string $method            
     * @param string $message            
     * @param string $route            
     * @param array $params            
     * @throws \Exception
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Application\Controller\AbstractActionController
     */
    public function salvar($method, $message, $route, array $params)
    {
        if ($this->getRequest()->isPost()) {
            
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
           
            $this->form->setData($data);
            
            if ($method == self::REMOVE) {
                $this->model->remove($this->object);
            } elseif ($method == self::SAVE) {
                if ($this->form->isValid()) {
                    $this->model->save($this->form->getData());
                } else {
                    throw new \Exception(Message::FORM_INVALID);
                }
            } else {
                throw new \Exception('$method deve ser self::SAVE ou self::REMOVE, no entanto foi recebido ' . $method);
            }
            
            $this->flashmessenger()->addSuccessMessage($message);
            return $this->redirect()->toRoute($route, $params);
        }
        
        return $this;
    }

    /**
     * Desabilita todos os campos do form
     *
     * @return \Application\Controller\AbstractActionController
     */
    protected function disableInputs()
    {
        $this->disabledElements($this->form->getElements());
        foreach ($this->form->getFieldsets() as $fieldset) {
            $this->disabledElements($fieldset->getElements());
        }
        
        return $this;
    }

    /**
     * Desabilitar elementos de um form ou fieldset
     *
     * @param array $elements            
     * @return \Application\Controller\AbstractActionController
     */
    protected function disabledElements(array $elements)
    {
        $notDisables = array(
            'submit',
            'hidden'
        );
        
        foreach ($elements as $element) {
            
            if (! in_array($element->getAttribute('type'), $notDisables)) {
                $element->setAttribute('disabled', true);
            }
        }
        return $this;
    }

    /**
     * Altera o label do botão cancelar para voltar e remove o botão confirmar
     *
     * @return \Application\Controller\AbstractActionController
     */
    protected function formView()
    {
        $this->disableInputs();
        $this->form->get('botoes')->remove('button-enviar');
        $this->form->get('botoes')->get('button-cancelar')
            ->setOption('label', 'Voltar')
            ->setOption('glyphicon', 'chevron-left')
            ->setAttribute('class', 'btn-primary');
        
        return $this;
    }

    /**
     * Altera o lavel do botão confirmar para Remover e muda a cor pra vermelho
     *
     * @return \Application\Controller\AbstractActionController
     */
    protected function formRemove()
    {
        $this->disableInputs();
        $this->form->get('botoes')->get('button-enviar')
            ->setOption('label', 'Remover')
            ->setAttribute('class', 'btn-danger')
            ->setAttribute('formnovalidate', 'formnovalidate');
        
        return $this;
    }

    /**
     *
     * @param string $repo            
     */
    protected function getRepository($repo)
    {
        $em = $this->getServiceLocator()->get('EntityManager');
        return $em->getRepository($repo);
    }

    /**
     *
     * @return \Zend\Stdlib\Parameters
     */
    protected function getPost()
    {
        return $this->getRequest()->getPost();
    }
}

