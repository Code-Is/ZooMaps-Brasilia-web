<?php
namespace ZfTable\Source;

use ZfTable\Source\AbstractSource;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class DoctrineQueryBuilder extends AbstractSource
{

    /**
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;

    /**
     *
     * @var \Zend\Paginator\Paginator
     */
    protected $paginator;

    /**
     *
     * @param \Doctrine\ORM\QueryBuilder $query            
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     *
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator()
    {
        if (! $this->paginator) {
            
            $this->order();
            $this->search();
            
            $adapter = new DoctrineAdapter(new ORMPaginator($this->query));
            $this->paginator = new Paginator($adapter);
            $this->initPaginator();
        }
        
        return $this->paginator;
    }

    /**
     * Quick search
     * 
     * @return \ZfTable\Source\DoctrineQueryBuilder
     */
    protected function search()
    {
        if ($search = $this->getParamAdapter()->getQuickSearch()) {
            foreach ($this->getTable()->getHeaders() as $k => $v) {
                $column = isset($v['column']) ? $v['column'] : $k;
                $this->query->orWhere($this->query->expr()->like($v['tableAlias'] . '.' . $column, "'%" . $search . "%'"));
            }
        }
        
        return $this;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \ZfTable\Source\AbstractSource::order()
     */
    protected function order()
    {
        $column = $this->getParamAdapter()->getColumn();
        $order = $this->getParamAdapter()->getOrder();
        
        if (! $column) {
            return;
        }
        
        $header = $this->getTable()->getHeader($column);
        $tableAlias = ($header) ? $header->getTableAlias() : 'q';
        $column = $header->getColumn() ? $header->getColumn() : $column;
        
        if ($column) {
            $this->query->orderBy($tableAlias . '.' . $column, $order);
        }
        
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getSource()
    {
        return $this->query;
    }
}
