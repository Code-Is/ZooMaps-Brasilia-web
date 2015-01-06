<?php
namespace Application\Resources;

abstract class StaticMethods
{

    public static function encode($string, $key)
    {
        $encoded = base64_encode($string);
        return $encoded;
    }

    public static function decode($string, $key)
    {
        $decoded = base64_decode($string);
        return $decoded;
        
    }
    
    /**
     * Função para gerar código aleatório
     *
     * @param integer $tamanho
     * @return string
     */
    public static function gerarCodigo($tamanho = 8)
    {
    	$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$caracteres .= '1234567890';
    
    	$retorno = '';
    
    	$len = strlen($caracteres);
    	for ($n = 1; $n <= $tamanho; $n ++) {
    		$rand = mt_rand(1, $len);
    		$retorno .= $caracteres[$rand - 1];
    	}
    	return strtoupper($retorno);
    }    
}