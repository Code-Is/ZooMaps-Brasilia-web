<?php

/**
 * Link atualizar
 *
 * @author    Jerfeson Guerreiro
 * @category  Decorator
 * @package   ZfTable\Decorator\Cell\Link
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */

namespace ZfTable\Decorator\Cell\Link;

use ZfTable\Decorator\Cell\Link;

class Atualizar extends Link
{
	/**
	 * Atributtes
	 * @var array
	 */
	protected $attrs = array(
    	'class' => 'btn btn-xs btn-primary btn-icon icon-left',
    );
	
	/**
	 * Class da tag <i>
	 * @var string
	 */
	protected $classI = 'fa fa-edit';
	
	/**
	 * Label
	 * @var string
	 */
	protected $label = 'Atualizar';
}