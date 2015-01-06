<?php
namespace Cadastro\Form\Fieldset;

use Zend\Form\Fieldset;

class Botoes extends Fieldset
{

    public function __construct()
    {
        parent::__construct('botoes');
        
        $this->add(array(
            'type' => 'button',
            'name' => 'button-enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn-success'
            ),
            'options' => array(
                'glyphicon' => 'ok',
                'label' => 'Confirmar',
                'column-size' => 'sm-12'
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
                'glyphicon' => 'remove',
                'label' => 'Cancelar',
                'column-size' => 'sm-12'
            )
        ));     
        
    }
}
