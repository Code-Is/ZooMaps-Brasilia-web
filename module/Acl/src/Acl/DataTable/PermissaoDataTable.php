<?php
namespace Acl\DataTable;

use DataTable\Model\DataTable;

class PermissaoDataTable extends DataTable
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
        $atualizar = $helper->get('linkAtualizar');
        
        $return = '';
        $return .= $atualizar($route, $this->getUrlParams('atualizar', [
            'id' => $id
        ])) . ' &nbsp;';
        
        return $return;
    }
}
