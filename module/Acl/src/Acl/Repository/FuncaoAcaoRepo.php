<?php
namespace Acl\Repository;

/**
 *
 *
 * Repositório Funcao Acao
 *
 * @author Jerfeson Guerreiro
 * @category Repository
 * @package Acl/Repository
 * @copyright 2014 CodeIs Sistemas
 * @version 1.0.0
 */
class FuncaoAcaoRepo extends \Application\Repository\Repository
{

    public function findPermission()
    {
        $qb = $this->createQueryBuilder("FuncaoAcao");
        $qb->join("FuncaoAcao.funcao", "Funcao");
        $qb->orderBy("Funcao.nome", "ASC");
        
        return $qb->getQuery()->getResult();
    }
    
    public function findPermissionByPerfil(\Acl\Entity\Perfil $perfil)
    {
        $qb = $this->createQueryBuilder("FuncaoAcao");
        $qb->join("FuncaoAcao.perfil", "Perfil");
        $qb->join("FuncaoAcao.funcao", "Funcao");
        $qb->andWhere($qb->expr()->eq("Perfil", $perfil->getId()));
        $qb->orderBy("Funcao.nome", "ASC");
        
        
        return $qb->getQuery()->getResult();
    }
}

