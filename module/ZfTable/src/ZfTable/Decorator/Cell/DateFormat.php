<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Decorator\Cell;

use ZfTable\Decorator\Exception;

class DateFormat extends AbstractCellDecorator
{

    /**
     *
     * @var array
     */
    protected $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if(!isset($options['format'])) {
            throw new \Exception('Format not defined');
        }
        
        $this->options = $options;
    }

    /**
     * Rendering decorator
     *
     * @param \Datetime $context
     * @return string
     */
    public function render($context)
    {
        return $context->format($this->options['format']);
    }
}
