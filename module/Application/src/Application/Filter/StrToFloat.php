<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Filter;

use Zend\Filter\FilterInterface;

class StrToFloat implements FilterInterface
{

    /**
     * 
     * @param  string $value
     * @return string
     * @TODO Remover para usar o padrão já existente do PHP
     */
    public function filter($value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->filter($item);
            }
            return $value;
        }
        if (is_numeric($value)) {
            return $value;
        }
        $value = preg_replace(['#\.#', '#,#', '#[\$a-z\s]#i'], ['', '.', ''], $value);
        return number_format(floatval($value), 2, '.', '');
    }
}
