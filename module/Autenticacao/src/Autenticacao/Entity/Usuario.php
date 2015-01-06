<?php

namespace Autenticacao\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="fk_usuario_perfil1_idx", columns={"perfil_id"})})
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=32, nullable=false)
     */
    private $senha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    private $dataCriacao;

    /**
     * @var \Acl\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil_id", referencedColumnName="id")
     * })
     */
    private $perfil;
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
    	return $this->id;
    }
    
    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuario
     */
    public function setNome($nome)
    {
    	$this->nome = $nome;
    
    	return $this;
    }
    
    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
    	return $this->nome;
    }
    
    /**
     * Set login
     *
     * @param string $login
     * @return Usuario
     */
    public function setLogin($login)
    {
    	$this->login = $login;
    
    	return $this;
    }
    
    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
    	return $this->login;
    }
    
    /**
     * Set senha
     *
     * @param string $senha
     * @return Usuario
     */
    public function setSenha($senha)
    {
    	$this->senha = $senha;
    
    	return $this;
    }
    
    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha()
    {
    	return $this->senha;
    }
    
    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Usuario
     */
    public function setAtivo($ativo)
    {
    	$this->ativo = $ativo;
    
    	return $this;
    }
    
    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
    	return $this->ativo;
    }
    
    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     * @return Usuario
     */
    public function setDataCriacao($dataCriacao)
    {
    	$this->dataCriacao = $dataCriacao;
    
    	return $this;
    }
    
    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
    	return $this->dataCriacao;
    }
        
    /**
     * Set perfil
     *
     * @param \Acl\Entity\Perfil $perfil
     * @return Usuario
     */
    public function setPerfil(\Acl\Entity\Perfil $perfil = null)
    {
    	$this->perfil = $perfil;
    
    	return $this;
    }
    
    /**
     * Get perfil
     *
     * @return \Acl\Entity\Perfil
     */
    public function getPerfil()
    {
    	return $this->perfil;
    }

}
