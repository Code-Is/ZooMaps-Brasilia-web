<?php
namespace Application\Filter;

use Zend\Filter\FilterInterface;
use Zend\Filter\StringTrim;

class DateRanger implements FilterInterface
{

    /**
     * Filtrar campo dateRanger para array com as datas
     *
     * @param string $value            
     * @return array
     */
    public function filter($value)
    {        
        $trim = new StringTrim();
        $value = $trim->filter($value);
        $datas = explode('-', $value);
        
        $dataInicial = \Datetime::createFromFormat('d/m/Y', $trim->filter($datas[0]));
        $dataInicial->setTime(0, 0, 0);
        
        $dataFinal = \Datetime::createFromFormat('d/m/Y', $trim->filter($datas[1]));
        $dataFinal->setTime(23, 59, 59);
        
        return array(
            'dataInicial' => $dataInicial,
            'dataFinal' => $dataFinal
        );
    }
}
