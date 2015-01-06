<?php

/**
 * Validator de documento (cpf ou cnpj) 
 * 
 * @author    Jerfeson Guerreiro
 * @category  Validator
 * @package   Application/Validator
 * @copyright 2014  Code Is Sistemas
 * @version   6.0.0
 */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class Documento extends AbstractValidator
{
	const INVALID = 'documentoInvalid';
	
	/**
	 * Mensagens
	 * @var array
	 */
	protected $messageTemplates = array(
		self::INVALID => \Application\Common\Message::DOCUMENTO_INVALID,
		CPF::INVALID => '',
		CNPJ::INVALID => '',			
	);
	
	/**
	 * Validar documento (cpf ou cnpj)
	 * 
	 * @param $value
	 * @return boolean
	 */
	public function isValid($value = null)
    {
    	$this->setValue($value);

    	if (strlen($value) == 11) {
    		$validator = new CPF();
    	} else if (strlen($value) == 14) {
    		$validator = new CNPJ();
    	} else {
    		$this->error(self::INVALID);
    		return false;
    	}
    	
    	if (!$validator->isValid($value)) {
			$this->setMessages($validator->getMessages());
			$this->error($validator::INVALID);
    		return false;
    	}
    
    	return true;
    }
}