<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class NumberFormat extends AbstractHelper
{

    /**
     *
     * @param number $valor            
     * @return string
     */
    public function __invoke($valor)
    {
        if (is_numeric($valor)) {
            return number_format($valor, 2, ',', '.');
        } else {
            return $valor;
        }
    }
}