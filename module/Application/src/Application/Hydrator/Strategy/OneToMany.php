<?php

namespace Application\Hydrator\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

/**
 *
 * @author Jerfeson Guerreiro
 *        
 */
class OneToMany extends AbstractCollectionStrategy
{
	
	/**
	 * 
	 * @var string
	 */
	private $setter;
	
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        $collection      = $this->getCollectionFromObjectByReference();
        $collectionArray = $collection->toArray();

        $toAdd      = array_udiff($value, $collectionArray, array($this, 'compareObjects'));
        $toRemove   = array_udiff($collectionArray, $value, array($this, 'compareObjects'));

        $setter = $this->setter ?: $this->getSetter();
        
        foreach ($toAdd as $element) {
        	$element->$setter($this->getObject());
            $collection->add($element);
        }

        foreach ($toRemove as $element) {
        	$element->$setter(null);
            $collection->removeElement($element);
        }

        return $collection;
    }
    
    /**
     * 
     */
    public function getSetter()
    {
    	$parts = explode('\\', get_class($this->getObject()));
    	return $this->setter = 'set' . end($parts);
    }
	
	/**
	 * 
	 * @param string $setter
	 * @return \Application\Hydrator\Strategy\OneToMany
	 */
	public function setSetter($setter)
	{
		$this->setter = $setter;
		return $this;
	}
	
}

