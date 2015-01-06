<?php

namespace Application\ZfTable;

use ZfTable\AbstractTable;
use Doctrine\ORM\QueryBuilder;

class Usuario extends AbstractTable
{
    
    protected $config = array(
        'showPagination' => true,
        'showQuickSearch' => true,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    );

    protected $headers = array(
        'nome' => array(
            'tableAlias' => 'Usuario',
            'title' => 'Nome',
            'width' => '100',
            'filters' => 'text'
        ),
        'login' => array(
            'tableAlias' => 'Usuario',
            'title' => 'Login',
            'width' => '100',
            'filters' => 'text'
        ),
        'email' => array(
            'tableAlias' => 'Usuario',
            'title' => 'E-mail',
            'width' => '100',
            'filters' => 'text'
        ),
        'ativo' => array(
            'tableAlias' => 'Usuario',
            'title' => 'Status',
            'width' => '25',
            'filters' => array(
                null => 'Todos',
                '1' => 'Ativo',
                '0' => 'Inativo'
            )
        ),
        'regDate' => array(
            'tableAlias' => 'Usuario',
            'title' => 'Data',
            'width' => '100',
            'filters' => 'text'
        ),
        'id' => array(
            'tableAlias' => 'Usuario',
            'title' => '&nbsp;',
            'width' => '150'
        ) ,
    );

    /**
     * (non-PHPdoc)
     * @see \ZfTable\AbstractTable::init()
     */
    public function init()
    {
        $this->getHeader('regDate')->getCell()->addDecorator('dateformat', array('format' => 'd/m/Y'));
        $this->getHeader('status')->getCell()->addDecorator('status', array());
        
        $this->getHeader('id')->getCell()->addDecorator('callable', array(
        	'callable' => function($record, $context) {
        	   return self::linkCallback($context, $record);
            }
        ));
    }

    /**
     * (non-PHPdoc)
     * @see \ZfTable\AbstractTable::initFilters()
     */
    public function initFilters(QueryBuilder $qb)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('nome')) {
           $qb->andWhere($qb->expr()->like('Usuario.nome', "'%" . $value . "%'"));
        }
        
        if ($value = $this->getParamAdapter()->getValueOfFilter('login')) {
           $qb->andWhere($qb->expr()->like('Usuario.login', "'%" . $value . "%'"));
        }
        
        if ($value = $this->getParamAdapter()->getValueOfFilter('email')) {
           $qb->andWhere($qb->expr()->like('Usuario.email', "'%" . $value . "%'"));
        }
        
        if ($value = $this->getParamAdapter()->getValueOfFilter('regDate')) {
            $data = \DateTime::createFromFormat('d/m/Y', $value);
            $data = $data->format('Y-m-d');
            $qb->andWhere($qb->expr()->like('Usuario.regDate', "'" . $data . "%'"));
        }
        
        $value = $this->getParamAdapter()->getValueOfFilter('status');
        if ($value !== '' && !is_null($value)) {
            $qb->andWhere($qb->expr()->eq('Usuario.ativo', $value));
        }         
    }
    
    private function linkCallback($context, $record) 
    {
        $link = '<a class="btn btn-xs btn-default" href="/' . $record . '"><i class="fa fa-search"> Visualizar</i> </a>&nbsp;';
        $link .= '<a class="btn btn-xs btn-primary" href="/' . $record . '"><i class="fa fa-edit"> Atualizar</i> </a>&nbsp;';
        $link .= '<a class="btn btn-xs btn-danger" href="/' . $record . '"><i class="fa fa-trash-o"> Remover</i> </a>&nbsp;';
        return $link;
    }
}