<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Mask extends AbstractHelper
{

    const CPF = '###.###.###-##';
    const CNPJ = '##.###.###/####-##';

    const TIPO_DOCUMENTO = 'documento';

    /**
     * Invoca a função para mascarar campos
     *
     * @param string $value            
     * @param string $mask            
     * @return string
     */
    public function __invoke($value, $mask = '', $tipo = null)
    {
        if ($tipo == self::TIPO_DOCUMENTO) {
            if (strlen($value) == 14) {
                $mask = self::CNPJ;
            } else {
                $mask = self::CPF;
            }
        }
        return $this->mask($value, $mask);
    }

    /**
     *
     * @param string $val            
     * @param string $mask            
     * @return string
     */
    protected function mask($val, $mask)
    {
        if ($val == '')
            return $val;
        
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i ++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k ++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}