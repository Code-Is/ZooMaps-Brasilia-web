<?php
namespace Acl\Repository;

use Cadastro\Entity\Instituicao;
/**
 *
 * Repositório Perfil
 *
 * @author Jerfeson Guerreiro
 * @category Repository
 * @package Acl/Repository
 * @copyright 2014 Code Is Sistemas
 * @version 1.0.0
 */
class PerfilRepo extends \Application\Repository\Repository
{
	/**
	 * Retornar lista de perfis admin ou da instituição
	 *
	 * @param int $criteria
	 *            (informar id da instituição)
	 * @return Ambigous <multitype:, \Doctrine\ORM\mixed, mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function findPerfilLocal($id)
	{
		$query = $this->getPerfilLocalQuery($id);
	
		return $query->getQuery()->getResult();
	}
	/**
	 *
	 * @param int $id
	 * @return Ambigous <\Doctrine\ORM\QueryBuilder, boolean, \Doctrine\ORM\QueryBuilder>
	 */
	public function getPerfilLocalQuery($id)
	{
		$query = $this->createQueryBuilder('p')
		->innerJoin('p.instituicao', 'i')
		->where("p.admin = '0'")
		->andWhere("i.id = :instituicao")
		->setParameter('instituicao', $id);
		return $query;
	}
	
	/**
	 * Retorna perfil administrador de uma instituição instituição
	 *
	 * @return \Acl\Entity\Perfil
	 */
	public function findPerfilAdmin(Instituicao $instituicao)
	{
		$dql = "
	        SELECT p
	        FROM Acl\Entity\Perfil p
	        WHERE p.admin = :admin
        ";
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('admin', $instituicao->getTipo());
		$result = $query->getSingleResult();
		return $result;
	}
}

