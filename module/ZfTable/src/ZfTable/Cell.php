<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable;

use ZfTable\AbstractElement;
use ZfTable\Decorator\DecoratorFactory;
use Zend\Validator\Explode;

class Cell extends AbstractElement
{

    /**
     * Header object
     * @var Header
     */
    protected $header;

    /**
     *
     * @param Header $header
     */
    public function __construct($header)
    {
        $this->header = $header;
    }

    /**
     *
     * @param string $name type
     * @param array  $options type
     * @return Decorator\AbstractDecorator
     */
    public function addDecorator($name, $options = array())
    {
        $decorator = DecoratorFactory::factoryCell($name, $options);
        $decorator->setCell($this);
        $this->attachDecorator($decorator);
        return $decorator;
    }

    /**
     * Get header object
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set header object
     *
     * @param Header $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * Get actual row
     *
     * @return array
     */
    public function getActualRow()
    {
        return $this->getTable()->getRow()->getActualRow();
    }

    /**
     * Rendering single cell
     *
     * @return string
     */
    public function render($type = 'html')
    {
        $row = $this->getTable()->getRow()->getActualRow();

        $value = '';

        if (is_array($row) || $row instanceof \ArrayAccess) {
            $value = (isset($row[$this->getHeader()->getName()])) ? $row[$this->getHeader()->getName()] : '';
        } elseif (is_object($row)) {
            $tableAlias = $this->getHeader()->getTableAlias();
            $headerName = $this->getHeader()->getColumn() ? $this->getHeader()->getColumn() : $this->getHeader()->getName();
            $classActual = explode('\\', get_class($row));
            if (end($classActual) == $tableAlias) {
            	$value = $this->extract($row, $headerName);
            } else {
            	$methodAlias = 'get' . ucfirst($tableAlias);
            	$row = $row->$methodAlias();
            	$value = $this->extract($row, $headerName);
            }
        }

        if (count($this->decorators)) {
	        $return = '';
	        foreach ($this->decorators as $decorator) {
	            if ($decorator->validConditions()) {
	                $return .= $decorator->render($value);
	            }
	        }
        } else {
        	$return = $value;
        }

        if ($type == 'html') {
            $ret = sprintf("<td %s>%s</td>", $this->getAttributes(), $return);
            $this->clearVar();
            return $ret;

        } else {
            return $return;
        }
    }
    
    /**
     * Extrair valor do atributo na row
     * 
     * @param  Object $row
     * @param  string $headerName
     * @return string
     */
    protected function extract($row, $headerName)
    {
        if(is_null($row)) {
            return '';
        }
        
    	$methodName = 'get' . ucfirst($headerName);
    	if (method_exists($row, $methodName)) {
    		$value = $row->$methodName();
    	} else {
    		$value = (property_exists($row, $headerName)) ? $row->$headerName : '';
    	}
    	return $value;
    }
}
