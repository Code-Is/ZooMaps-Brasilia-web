<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

/**
 */
abstract class Repository extends EntityRepository
{

    /**
     * 
     * @param int $id
     */
    public function findOrNew($id)
    {
        $entity = $this->find($id);
        if (empty($entity)) {
            $className = $this->getClassName();
            $entity = new $className();
        }
        return $entity;
    }

    /**
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $entity = $this->find($id);
        
        if (! empty($entity)) {
            $em = $this->getEntityManager();
            $em->remove($entity);
            $em->flush();
        }
    }

    /**
     * 
     * @param Entity $data
     */
    public function save($data)
    {
        $em = $this->getEntityManager();
        $em->persist($data);
        $em->flush();
    }
}