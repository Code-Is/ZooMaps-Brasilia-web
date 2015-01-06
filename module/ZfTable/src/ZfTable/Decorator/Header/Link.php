<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Decorator\Header;

use ZfTable\Decorator\Exception;

class Link extends AbstractHeaderDecorator
{

    /**
     * Array of variable attribute for link
     * @var array
     */
    protected $vars;

    /**
     * Link url
     * @var string
     */
    protected $url;
    
    /**
     * Atributtes
     * @var array
     */
    protected $attrs;
    
    /**
     * Class da tag <i>
     * @var string
     */
    protected $classI;
    
    /**
     * Label
     * @var string
     */
    protected $label;

    /**
     * Constructor
     *
     * @param array $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['url'])) {
            throw new Exception\InvalidArgumentException('Url key in options argument required');
        }

        $this->url = $options['url'];
        
        if (isset($options['vars'])) {
            $this->vars = is_array($options['vars']) ? $options['vars'] : $this->vars;
        }
        
        if (isset($options['attrs'])) {
        	$this->attrs = is_array($options['attrs']) ? $options['attrs'] : $this->attrs;
        }
        
        $this->classI = isset($options['class_i']) ? $options['class_i'] : $this->classI;
        
        $this->label = isset($options['label']) ? $options['label'] : $this->label;
    }

    /**
     * Rendering decorator
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        $values = array();
        if (count($this->vars)) {
            $actualRow = $this->getHeader();
            foreach ($this->vars as $var) {
            	if (is_array($actualRow)) {
                	$values[] = $actualRow[$var];
            	} else {
            		$method = 'get' . ucfirst($var); 
            		$values[] = $actualRow->$method();
            	}
            }
        }
        $this->attrs['href'] = vsprintf($this->url, $values);
        $context = $this->label ? $this->label : $context;
        
        return sprintf('<a %s><i %s></i>%s</a>&nbsp;', $this->renderAttributes(), 'class="' . $this->classI . '"', $context);
	}
        
	/**
     * Renderizar atributos
     *
     * @return string
     */
	protected function renderAttributes()
    {
    	$strings = array();
        foreach ($this->attrs as $key => $value) {
        	$strings[] = sprintf('%s="%s"', $key, $value);
        }
        
    	return implode(' ', $strings);
	}
}
