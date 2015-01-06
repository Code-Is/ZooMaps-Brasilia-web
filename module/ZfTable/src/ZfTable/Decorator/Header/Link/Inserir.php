<?php

/**
 * Link inserir 
 *
 * @author    Jerfeson Guerreiro
 * @category  Decorator
 * @package   ZfTable\Decorator\Cell\Link
 * @copyright 2014 Code Is Sistemas
 * @version   1.0.0
 */

namespace ZfTable\Decorator\Header\Link;

use ZfTable\Decorator\Header\Link;

class Inserir extends Link
{
	/**
	 * Atributtes
	 * @var array
	 */
	protected $attrs = array(
    	'class' => 'btn btn-xs btn-success btn-icon icon-left',
    );
	
	/**
	 * Class da tag <i>
	 * @var string
	 */
	protected $classI = 'fa fa-plus';
	
	/**
	 * Label
	 * @var string
	 */
	protected $label = 'Inserir';
}