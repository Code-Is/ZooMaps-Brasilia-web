<?php
namespace Application\Filter;

use Zend\Filter\FilterInterface;
use Cra\Entity\DevedorRegistro as Devedor;

/**
 * Adiciona máscara ao documento conforme comprimento do mesmo se tipo não for
 * passado. Caso contrário, respeitará parâmetro tipo.  
 * 
 * @author Jerfeson Guerreiro
 *        
 */
final class Documento implements FilterInterface
{
    /**
     * 
     * @var string
     */
    public $value;
    
    /**
     * 
     * @var string
     */
    public $tipo;

    /**
     * 
     * @param string $value
     */
    public function __construct($value = null, $tipo = null)
    {
        $this->value = $value;
        $this->tipo = $tipo;
    }
    
    /**
     * Se tamanho do documento igual a 14, então adiciona máscara de CNPJ. Se
     * tamanho igual a 14, CPF. Se nenhum, retorna valor original. 
     *
     * @return string documento com máscara
     */
    public function filter($value)
    {
        // Filtro 
        $mask = new \Application\Filter\Mask();
        $length = strlen($value);
        $tipo = $this->tipo;
        
        // Máscara para CPF
        if ($tipo == 1 || $length == 11) {
            $value = substr($value, -11);
            $documento = $mask->mask($value, '###.###.###-##');
        } elseif ($tipo == 2 || $length == 14) {
            // Máscara para CNPJ
            $documento = $mask->mask($value, '##.###.###/####-##');
        } else {
            // Não aplicar caso número de dígitos não batam
            $documento = $value;
        }
        
        return $documento;
    }
    
    /**
     * Para utilizar fora do contexto dos formulários
     * 
     * @return string 
     */
    public function __toString()
    {
        return $this->filter($this->value);
    }
}

