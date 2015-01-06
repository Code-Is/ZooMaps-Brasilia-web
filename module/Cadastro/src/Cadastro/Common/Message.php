<?php

namespace Cadastro\Common;

class Message 
{
	const NOT_UNIQUE = 'Já existe %s usando %s';
	const IS_EMPTY = '%s não pode estar em branco.';
	const TOO_SHORT = '%s não pode ter menos de %%min%% caracteres';
	const TOO_LONG = '%s não pode ter mais de %%max%% caracteres';
	const NOT_DIGITS = 'Somente números permitidos.';
	const DATE_INVALID = 'A data %s deve ser preenchida.';
	const DATE_END_INVALID = 'A data final %s deve ser maior que a data inicial.';
	const SELECT_EMPTY = 'Você deve selecionar %s para %s';
	const NOT_ALPHA = 'Somente letras é permitido.';
	
	use \Application\Common\MessageTrait;
}

