<?php

/**
 * Classe de registro do controle de acesso
 *
 * @author    Jerfeson Guerreiro
 * @category  Acl
 * @package   Acl/Permissions
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */

namespace Acl\Permissions;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl 
{
	/**
	 * Objeto perfil 
	 * @var \Acl\Entity\Perfil
	 */
    protected $perfil;
    
    /**
     * Recebe o objeto perfil para poder apontar as funções e permissões
     * 
     * @param  \Acl\Entity\Perfil $perfil
     * @return void
     */
    public function __construct(\Acl\Entity\Perfil $perfil) 
    {
        $this->perfil = $perfil;
        // init
        $this->loadRoles();
        $this->loadResources();
        $this->loadPrivileges();
    }
    
    /**
     * Carregar roles
     * 
     * @return void 
     */
    protected function loadRoles()
    {
		$this->addRole(new Role($this->perfil->getId()));
    }
    
    /**
     * Carregar resources
     *
     * @return void
     */
    protected function loadResources()
    {
    	$resources = array();
        foreach($this->perfil->getFuncaoAcao() as $funcaoAcao) {
        	/* @var $funcaoAcao \Acl\Entity\FuncaoAcao */
            if (!in_array($funcaoAcao->getFuncao()->getNome(), $resources)) {
            	$resources[] = $funcaoAcao->getFuncao()->getNome();
            }
        }
        
        foreach($resources as $resource) {
        	$this->addResource(new Resource($resource));
        }
    }
    
    /**
     * Carregar permissões
     *
     * @return void
     */
    protected function loadPrivileges()
    {
        foreach($this->perfil->getFuncaoAcao() as $funcaoAcao) {
        	/* @var $funcaoAcao \Acl\Entity\FuncaoAcao */
            $this->allow($this->perfil->getId(), $funcaoAcao->getFuncao()->getNome(), $funcaoAcao->getAcao()->getNome());
        }
    }
}
