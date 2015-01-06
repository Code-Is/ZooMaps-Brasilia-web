<?php
namespace Application\Common;

/**
 * 
 * 
 * @author Jerfeson Guerreiro
 * @package Application\Common
 * @version 1.0.0
 */
class MessageTrait
{
    
    /**
     * Identifica mensagem pela $msgid e a formata 
     * 
     * @throws \DomainException Se constante não estiver definida, gera exceção.
     * @param string $msgid Id da mensagem (nome da constante)
     * @param array $args Parâmetros
     * @return string
     * 
     * @todo Inserir na camada de serviço para permitir traduções
     * @todo Retirar exceções e adicionar validadores utilizando api zend.
     * @todo Criar filtros usando api zend
     */
    public static function __callstatic($msgid, $args = null)
    {
        $const = "static::$msgid";
        
        if (!defined($const)) {
            throw new \DomainException(Message::CONSTANT_NOT_FOUND($const));
        }

        $msg = constant($const);
        
        return static::format($msg, $args);
    }
    
    /**
     * Formata uma string de acordo com seus parâmetros.
     * 
     * @param string $msgid
     * @param array $args
     * @throws \InvalidArgumentException
     */
    public static function format($msg, $args = array())
    {
        if (!$args && preg_match('#%(\d\$)?[sd]#', $msg)) {
            $msg = preg_replace('#%(\d\$)?[sd]#', '', $msg);
        }
        
        array_unshift($args, $msg);
        $msg = @call_user_func_array('sprintf', $args);
        
        if(error_get_last()) {
            //throw new \InvalidArgumentException('INVALID_PARAMETERS');
        }
        
        $msg = preg_replace(array('#(\s)\s+#', '#%+#'), array('\1', '%'), $msg);
        return $msg;
    }
    
}

