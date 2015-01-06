<?php

namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Zend\Stdlib\AbstractOptions;

class Datetime extends AbstractOptions implements StrategyInterface
{
	
	/**
	 * 
	 * @var string
	 */
	protected $format = 'd/m/Y';
	
	/**
	 * 
	 * @var string
	 */
	protected $timeZone = 'America/Sao_paulo';
	
	/**
	 * 
	 * @var \DateTimeZone
	 */
	protected $dateTimeZone;
	
	/**
	 * Retuns \Datetime without any treatment.
	 * @return \Datetime
	 */
	public function extract($value)
	{
		return $value;
	}
	
	/**
	 * Retuns Datetime object from a string value.
	 * 
	 * @param string $value
	 * @return \Datetime
	 */
	public function hydrate($value)
	{
		$dateObject = \Datetime::createFromFormat(
			$this->getFormat(),
			$value,
			$this->getDateTimeZone()
		);
		return $dateObject;
	}
	
	public function getFormat()
	{
		return $this->format;
	}
	
	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	} 
	
	public function getTimeZone()
	{
		return $this->timeZone;
	}
	
	public function setTimeZone($timeZone)
	{
		$this->timeZone = $timeZone;
		return $this;
	} 
	
	public function getDateTimeZone()
	{
		if (!$this->dateTimeZone) {
			$this->setDateTimeZone(new \DateTimeZone($this->getTimeZone()));
		}
		return $this->dateTimeZone;
	}
	
	public function setDateTimeZone($dateTimeZone)
	{
		$this->dateTimeZone = $dateTimeZone;
		return $this;
	} 
	
}

