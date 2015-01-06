<?php

/**
 * Cadastro de motivos de protesto.
 *
 * @author    Jerfeson Guerreiro
 * @category  Form
 * @package   Acl/Form
 * @copyright 2014 Code Is Sistemas
 * @version   6.0.0
 */
namespace Acl\Form;

use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Element\Submit;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByReference;
use Acl\Entity\Funcao;

class FuncaoForm extends Form
{

    /**
     * Construtor
     *
     * @param ObjectManager $objectManager            
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('funcao');
        $this->setHydrator(new DoctrineObject($objectManager))->setObject(new Funcao());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nome',
            'attributes' => array(
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o nome'
            ),
            'options' => array(
                'label' => 'Nome',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'descricao',
            'attributes' => array(
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe a descricao'
            ),
            'options' => array(
                'label' => 'Descrição',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'ordem',
            'attributes' => array(
                'required' => true,
                'type' => 'number',
                'placeholder' => 'Informe a ordem'
            ),
            'options' => array(
                'label' => 'Ordem',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'menu',
            'attributes' => array(
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o menu'
            ),
            'options' => array(
                'label' => 'Menu',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'url',
            'attributes' => array(
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe a URL'
            ),
            'options' => array(
                'label' => 'URL',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'funcaoAcao',
            'options' => array(
                'label' => 'Ações',
                'column-size' => 'sm-6',
                'label_attributes' => array(
                    'class' => 'col-sm-2'
                ),
                'object_manager' => $objectManager,
                'target_class' => 'Acl\Entity\Acao',
                'property' => 'descricao'
            )
        ));
        
        // $this->getHydrator()->addStrategy('acoes', new AllowRemoveByReference());
        
        $this->add(array(
            'type' => 'button',
            'name' => 'button-enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn-primary'
            ),
            'options' => array(
                'label' => 'Confirmar',
                'column-size' => 'sm-10 col-sm-offset-2'
            )
        ));
        
        $this->add(array(
            'type' => 'button',
            'name' => 'button-cancelar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn-default',
                'formnovalidate' => 'formnovalidate'
            ),
            'options' => array(
                'label' => 'Cancelar',
                'column-size' => 'sm-10 col-sm-offset-2'
            )
        ));
    }
}

