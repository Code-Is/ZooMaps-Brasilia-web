<?php

namespace Cadastro\ZfTable;

use ZfTable\AbstractTable;
use Doctrine\ORM\QueryBuilder;

class Recinto extends AbstractTable
{
    
    protected $config = array(
        'showPagination' => true,
        'showQuickSearch' => true,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    );

    protected $headers = array(
        'nome' => array(
            'tableAlias' => 'Recinto',
            'title' => 'Nome',
            'width' => '300',
            'filters' => 'text'
        ),
        'id' => array(
            'tableAlias' => 'Recinto',
            'title' => '&nbsp;',
            'width' => '180'
        ) ,
    );
    
    /**
     * 
     * @param \Application\Repository\Repository $repo
     * @param \Zend\Stdlib\Parameters $post
     */
    public function __construct(\Application\Repository\Repository $repo, \Zend\Stdlib\Parameters $post)
    {
        $qb = $repo->createQueryBuilder('Recinto');
        
        $this->setSource($qb);
        $this->setParamAdapter($post);
    }

    /**
     * (non-PHPdoc)
     * @see \ZfTable\AbstractTable::init()
     */
    public function init()
    {
    	$this->getHeader('id')->addDecorator('inserir', array(
    		'url' => '/cadastro/recinto/inserir/',
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('visualizar', array(
    		'url' => '/cadastro/recinto/visualizar/%s',
    		'vars' => array('id'),
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('atualizar', array(
    		'url' => '/cadastro/recinto/atualizar/%s',
    		'vars' => array('id'),
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('remover', array(
    		'url' => '/cadastro/recinto/remover/%s',
    		'vars' => array('id'),
    	));
    }

    /**
     * (non-PHPdoc)
     * @see \ZfTable\AbstractTable::initFilters()
     */
    public function initFilters(QueryBuilder $qb)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('nome')) {
           $qb->andWhere($qb->expr()->like('Recinto.nome', "'%" . $value . "%'"));
        }
    }
}