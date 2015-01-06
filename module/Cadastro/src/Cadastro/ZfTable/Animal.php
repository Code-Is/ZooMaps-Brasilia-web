<?php

namespace Cadastro\ZfTable;

use ZfTable\AbstractTable;
use Doctrine\ORM\QueryBuilder;

class Animal extends AbstractTable
{
    
    protected $config = array(
        'showPagination' => true,
        'showQuickSearch' => true,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    );

    protected $headers = array(
        'nome' => array(
            'tableAlias' => 'Animal',
            'title' => 'Nome',
            'width' => '130',
            'filters' => 'text'
        ),
        'nomeCientifico' => array(
            'tableAlias' => 'Animal',
            'title' => 'Nome científico',
            'width' => '150',
            'filters' => 'text'
        ),
        'alimentacao' => array(
            'tableAlias' => 'Alimentacao',
            'column' => 'nome',
            'title' => 'Alimentação',
            'width' => '50',
            'filters' => 'text'
        ),
        'ambiente' => array(
            'tableAlias' => 'Ambiente',
            'column' => 'nome',
            'title' => 'Ambiente',
            'width' => '50',
            'filters' => 'text'
        ),
        'id' => array(
            'tableAlias' => 'Animal',
            'title' => '&nbsp;',
            'width' => '200'
        ) ,
    );
    
    /**
     * 
     * @param \Application\Repository\Repository $repo
     * @param \Zend\Stdlib\Parameters $post
     */
    public function __construct(\Application\Repository\Repository $repo, \Zend\Stdlib\Parameters $post)
    {
        $qb = $repo->createQueryBuilder('Animal');
        
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
    		'url' => '/cadastro/animal/inserir/',
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('visualizar', array(
    		'url' => '/cadastro/animal/visualizar/%s',
    		'vars' => array('id'),
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('atualizar', array(
    		'url' => '/cadastro/animal/atualizar/%s',
    		'vars' => array('id'),
    	));
    	
    	$this->getHeader('id')->getCell()->addDecorator('remover', array(
    		'url' => '/cadastro/animal/remover/%s',
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
           $qb->andWhere($qb->expr()->like('Animal.nome', "'%" . $value . "%'"));
        }
    }
}