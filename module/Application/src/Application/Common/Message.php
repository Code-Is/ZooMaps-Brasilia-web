<?php
namespace Application\Common;

class Message extends \Application\Common\MessageTrait
{
    const CREATE_SUCCESS = 'Registro inserido com sucesso';
    const UPDATE_SUCCESS = 'Registro alterado com sucesso';
    const DELETE_SUCCESS = 'Registro removido com sucesso';
    const FORM_INVALID   = 'Verifique dados fornecidos';
    
    const NOT_UNIQUE = 'Já existe %s usando %s';
    const NOT_EXISTS = 'Não existe %s cadastrado usando %s';
    const IS_EMPTY = '%s não pode estar em branco.';
    const TOO_SHORT = '%s não pode ter menos de %%min%% caracteres';
    const TOO_LONG = '%s não pode ter mais de %%max%% caracteres';
    const NOT_DIGITS = 'Somente números permitidos.';
    
    const DOCUMENTO_INVALID = 'Documento no formato inválido';
    
    const DATE_INVALID = 'A data %s deve ser preenchida';
    const DATE_END_INVALID = 'A data final %s deve ser maior que a data inicial.';
    const DATE_INTERSECT = 'Já existe algum %s cadastrado nessa data, verifique a intersecção';
    
    const SELECT_EMPTY = 'Você deve selecionar %s para %s';
    const NOT_ALPHA = 'Somente letras é permitido';

    
    
}

