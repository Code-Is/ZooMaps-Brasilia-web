<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;
use Traversable;

/**
 * Validar um CPF
 *
 * @author Jerfeson Guerreiro
 * @category Validator
 * @package Application/Validator
 * @copyright 2014 code is Sistemas
 * @version 6.0.0
 */
class CPF extends AbstractValidator
{

    /**
     *
     * @var string
     */
    const INVALID = 'cpfInvalid';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID => "CPF inválido informado"
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
     * Returns true if $value is a valid CPF.
     *
     * @param string|int $value            
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);
        
        $cpf = $value;
        
        $cpf = trim($cpf);
        
        // Somente números
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        // Verificar uantidade de dígitos
        if (strlen($cpf) != 11) {
            $this->error(self::INVALID);
            return false;
        }
        
        // Verificar por digitos iguais
        $regex = "/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/";
        
        if (preg_match($regex, $cpf)) {
            $this->error(self::INVALID);
            return false;
        }
        
        $tcpf = $cpf;
        $b = 0;
        $c = 11;
        for ($i = 0; $i < 11; $i ++) {
            if ($i < 9) {
                $b += ($tcpf[$i] * -- $c);
            }
        }
        
        $x = $b % 11;
        $tcpf[9] = ($x < 2) ? 0 : 11 - $x;
        
        $b = 0;
        $c = 11;
        for ($y = 0; $y < 10; $y ++) {
            $b += ($tcpf[$y] * $c --);
        }
        
        $x = $b % 11;
        $tcpf[10] = ($x < 2) ? 0 : 11 - $x;
        
        if (($cpf[9] != $tcpf[9]) || ($cpf[10] != $tcpf[10])) {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
}
