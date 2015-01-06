<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;
use Traversable;

/**
 * Validar um CNPJ
 *
 * @author Jerfeson Guerreiro
 * @category Validator
 * @package Application/Validator
 * @copyright 2014 Code Is Sistemas
 * @version 6.0.0
 */
class CNPJ extends AbstractValidator
{

    /**
     *
     * @var string
     */
    const INVALID = 'cnpjInvalid';
    const INVALID_LENGTH = 'cnpjInvalidLength';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID => "CNPJ inválido informado",
        self::INVALID_LENGTH => "Tamanho do CPNJ informado é inválido"
    );

    /**
     * Sets validator options
     *
     * @param string|array|Traversable $options
     *            OPTIONAL
     */
    public function __construct($options = array())
    {
        if ($options instanceof Traversable) {
            $options = iterator_to_array($options);
        } elseif (! is_array($options)) {
            $options = func_get_args();
            $options = array_shift($options);
        }
        
        parent::__construct($options);
    }

    /**
     * Returns true if $value is a valid CNPJ.
     *
     * @param string|int $value            
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);
        
        $cnpj = $value;
        
        $cnpj = trim($cnpj);
        
        $cnpj = str_replace('.|-|/', '', $cnpj);
        
        // Somente números
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
        
        // Verificar quantidade de digitos
        if (strlen($cnpj) != 14) {
            $this->error(self::INVALID_LENGTH);
            return false;
        }
        
        // Verificar por digitos iguais
        $regex = "/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/";
        
        if (preg_match($regex, $cnpj)) {
            $this->error(self::INVALID);
            return false;
        }
        
        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        
        $pos = $tamanho - 7;
        
        $soma = 0;
        for ($i = $tamanho; $i >= 1; $i --) {
            $soma += $numeros[$tamanho - $i] * $pos --;
            
            if ($pos < 2) {
                $pos = 9;
            }
        }
        
        $resultado = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));
        
        if ($resultado != $digitos[0]) {
            $this->error(self::INVALID);
            return false;
        }
        
        $tamanho ++;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        
        for ($i = $tamanho; $i >= 1; $i --) {
            $soma += $numeros[$tamanho - $i] * $pos --;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        
        $resultado = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));
        
        if ($resultado != $digitos[1]) {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
}
