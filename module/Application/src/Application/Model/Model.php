<?php
namespace Application\Model;

use Doctrine\ORM\EntityManager;
use Zend\InputFilter\Factory;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 */
abstract class Model implements ObjectManagerAwareInterface, ServiceLocatorAwareInterface
{

    const ENTITY = '';

    protected $em;

    protected $repository;

    protected $inputFilter;
    
    /**
     * 
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function __construct(EntityManager $em = null)
    {
        if ($em) {
            $this->em = $em;
            $this->repository = $em->getRepository(static::ENTITY);
        }
    }

    /**
     *
     * @return EntityManager
     * @deprecated
     *
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Set the object manager
     *
     * @param ObjectManager $objectManager            
     * @return Model
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->em = $objectManager;
        return $this;
    }

    /**
     * Get the object manager
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->em;
    }
    
    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
    	$this->serviceLocator = $serviceLocator;
    }
    
    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
    	return $this->serviceLocator;
    }    

    /**
     *
     * @return \Application\Repository\Repository
     */
    public function getRepository()
    {
        if (empty($this->repository)) {
            $this->repository = $this->getEntityManager()->getRepository(static::ENTITY);
        }
        return $this->repository;
    }
    
    public function save($data)
    {
    	$this->getRepository()->save($data);
    }
    
    public function remove($data)
    {
    	$entityManager = $this->getEntityManager();
    	$entityManager->remove($data);
    	$entityManager->flush();
    }    
}