<?php
namespace Acl\DataTable;

use DataTable\Model\DataTable;

class PerfilDataTable extends DataTable
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
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \DataTable\Model\DataTableFunctions::gerarLinks()
     */
    public function gerarLinks($id)
    {
        $route = $this->getRoute();
        $helper = $this->getViewHelperManager();
        $visualizar = $helper->get('linkVisualizar');
        $atualizar = $helper->get('linkAtualizar');
        $remover = $helper->get('linkRemover');
        
        $return = '';
        $return .= $visualizar($route, $this->getUrlParams('visualizar', [
            'id' => $id
        ])) . ' &nbsp;';
        $return .= $atualizar($route, $this->getUrlParams('atualizar', [
            'id' => $id
        ])) . ' &nbsp;';
        $return .= $remover($route, $this->getUrlParams('remover', [
            'id' => $id
        ])) . ' &nbsp;';
        
        return $return;
    }
}
