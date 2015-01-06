<?php
namespace Application\Filter;

use Zend\Filter\FilterInterface;
/**
 *
 * @author Jerfeson Guerreiro
 *        
 */
final class Mask implements FilterInterface
{
    /**
     * 
     * @var string
     */
    protected $value;
    
    /**
     * 
     * @var string
     */
    protected $mask;

    /**
     * 
     * @param string $mask
     */
    public function __construct($value = null, $mask = null)
    {
        $this->value = $value;
        $this->mask = $mask;
    }
    
    /**
     * Somente caso for usar nos formulários
     *
     * @return string 
     */
    public function filter($value)
    {
        $masked = $this->mask($value, $this->mask);
        return $masked;
    }
    

    /**
     * Adiciona máscara
     *
     * @param string $val
     * @param string $mask
     * @return string
     */
    public function mask($val, $mask = null)
    {
        if ($val == '') {
            return $val;
        }
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
    
    /**
     * Para utilizar fora do contexto dos formulários
     * 
     * @return string 
     */
    public function __toString()
    {
        return $this->mask($this->value, $this->mask);
    }
}

