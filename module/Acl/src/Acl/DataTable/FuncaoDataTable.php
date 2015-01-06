<?php

/**
 * DataTable de funções.
 *
 * @author    Jerfeson Guerreiro
 * @category  DataTable
 * @package   Acl/DataTable
 * @copyright 2014  Code Is Sistemas
 * @version   6.0.0
 */
namespace Acl\DataTable;

use Application\Model\Model;
use DataTable\Model\DataTable;

class FuncaoDataTable extends DataTable
{

    /**
     * (non-PHPdoc)
     *
     * @see \DataTable\Model\DataTable::customizeRow()
     */
    public function customizeRow()
    {
    	$id = &$this->item['id'];
        $id = $this->gerarLinks($id);
        
	    // formatar ações
        $descricao = &$this->item['funcaoAcao']['acao']['descricao'];
        if (is_array($descricao)) {
        	$descricao = implode(', ', $descricao);
        }
    }
}