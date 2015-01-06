<?php

namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * Strategy para conversão da codificação do valor
 *
 * @author Jerfeson Guerreiro
 * @category Strategy
 * @package Application\Hydrator\Strategy
 * @copyright 2014  Code Is Sistemas
 * @version 12.0.0
 */
class Utf8 implements StrategyInterface
{
	/**
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\Hydrator\Strategy\StrategyInterface::extract()
	 */
	public function extract($value)
    {
    	return utf8_decode($value);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Stdlib\Hydrator\Strategy\StrategyInterface::hydrate()
     */
	public function hydrate($value)
    {
    	return utf8_decode($value);
	}
 }