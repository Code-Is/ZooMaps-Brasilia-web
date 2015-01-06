<?php

/**
 * Model de funções do sistema
 *
 * @author    Jerfeson Guerreiro
 * @category  Model
 * @package   Acl/Model
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */

namespace Acl\Model;

use Acl\Common\Message;
use DoctrineModule\Validator\UniqueObject;
class FuncaoModel extends \Application\Model\Model
{
	
	const ENTITY = 'Acl\Entity\Funcao';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Model\Model::getInputFilter()
	 */
	public function getInputFilter()
	{
		if (! $this->inputFilter) {
			$filter = new \Zend\InputFilter\InputFilter();
            $factory = new \Zend\InputFilter\Factory();
	
			$nomeJaExiste = new UniqueObject(array(
					"object_manager" => $this->getEntityManager(),
					'object_repository' => $this->getRepository(),
					'fields' => 'nome'
			));
			$nomeJaExiste->setMessage( \Cadastro\Common\Message::NOT_UNIQUE('uma função', 'este nome'), 'objectNotUnique');
	
			$filter->add($factory->createInput(array(
				'name' => 'nome',
				'required' => true,
				'validators' => array(
					$nomeJaExiste,
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								\Zend\Validator\NotEmpty::IS_EMPTY => \Cadastro\Common\Message::IS_EMPTY('O nome')
							)
						)
					),
				)
			)));
	
			$filter->add($factory->createInput(array(
				'name' => 'descricao',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								\Zend\Validator\NotEmpty::IS_EMPTY => \Cadastro\Common\Message::IS_EMPTY('A descrição')
							)
						)
					),
				)
			)));
			
			$filter->add($factory->createInput(array(
				'name' => 'ordem',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								\Zend\Validator\NotEmpty::IS_EMPTY => \Cadastro\Common\Message::IS_EMPTY('A ordem')
							)
						)
					),
				)
			)));
				
			$filter->add ($factory->createInput ( array (
				'name' => 'menu',
				'required' => true,
				'validators' => array (
					array (
						'name' => 'NotEmpty',
						'options' => array (
							'messages' => array (
								\Zend\Validator\NotEmpty::IS_EMPTY => \Cadastro\Common\Message::IS_EMPTY ( 'O menu' ) 
							) 
						) 
					) 
				) 
			) ) );
				
			$filter->add($factory->createInput(array(
				'name' => 'url',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								\Zend\Validator\NotEmpty::IS_EMPTY => \Cadastro\Common\Message::IS_EMPTY('A URL')
							)
						)
					),
				)
			)));
	
			$this->inputFilter = $filter;
		}
		return $this->inputFilter;
	}
}