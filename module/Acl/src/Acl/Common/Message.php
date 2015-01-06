<?php
namespace Acl\Common;

class Message
{
    
    const acaoNotUnique = "Ação '%s' já cadastrada.";
    
    const funcaoNotUnique = "Função '%s' já cadastrada.";
    
    const perfilHasUsuario = "Perfil possui usuários cadastrados.";
    
    const perfilNotUnique = "Já existe um perfil cadastrado com este nome.";
    
    const userNotDelete = 'Este usuário já realizou uma ação no sistema e não pode ser removido.';
    
    use \Application\Common\MessageTrait;
    
}

