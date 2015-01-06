<?php

/**
 * Link remover 
 *
 * @author    Jerfeson Guerreiro
 * @category  Decorator
 * @package   ZfTable\Decorator\Cell\Link
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */

namespace ZfTable\Decorator\Cell\Link;

use ZfTable\Decorator\Cell\Link;

class Remover extends Link
{
	/**
	 * Atributtes
	 * @var array
	 */
	protected $attrs = array(
		'class' => 'btn btn-xs btn-danger btn-icon icon-left',
	);
	
	/**
	 * Class da tag <i>
	 * @var string
	 */
	protected $classI = 'fa fa-trash-o';
	
	/**
	 * Label
	 * @var string
	 */
	protected $label = 'Remover';
}