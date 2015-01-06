<?php

/**
 * Model de usuários do sistema
 *
 * @author    Jerfeson Guerreiro
 * @category  Model
 * @package   Autenticacao/Model
 * @copyright 2014 Code Is Sistemas
 * @version   1.0.0
 */

namespace Autenticacao\Model;

class UsuarioModel extends \Application\Model\Model
{
	/**
	 * Entidade relacionada
	 * @var string
	 */
	const ENTITY = 'Autenticacao\Entity\Usuario';
}