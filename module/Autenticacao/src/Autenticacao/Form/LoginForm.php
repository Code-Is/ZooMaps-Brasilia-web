<?php

namespace Autenticacao\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class LoginForm extends Form implements InputFilterProviderInterface 
{

    /**
     */
    public function __construct($objectManager) {
        
        parent::__construct('post');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'login',
            'options' => array(
                //'label' => 'Login'
            ),
            'attributes' => array(
                'autofocus' => true,
                'required' => true,
                'autocomplete' => 'off',
                'class' => 'form-control',
                'placeholder' => 'Informe seu usuário',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'senha',
            'options' => array(
                //'label' => 'Senha'
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => 'Informe sua senha',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'confirmar',
            'attributes' => array(
                'class' => 'btn btn-lg btn-primary btn-block',
                'value' => 'Login'
            )
        ));
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification() {
        return array(
            'login' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ),
            'senha' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                )
            ),
        );
    }

}
