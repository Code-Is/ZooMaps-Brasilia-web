<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil")
 * @ORM\Entity(repositoryClass="Cadastro\Repository\PerfilRepo")
 */
class Perfil
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
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acl\Entity\FuncaoAcao", inversedBy="perfil")
     * @ORM\JoinTable(name="permissao",
     *   joinColumns={
     *     @ORM\JoinColumn(name="perfil_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="funcao_acao_id", referencedColumnName="id")
     *   }
     * )
     */
    private $funcaoAcao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->funcaoAcao = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * @return Perfil
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
     * Get instituicao
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * Add funcaoAcao
     *
     * @param \Acl\Entity\FuncaoAcao $funcaoAcao
     * @return Perfil
     */
    public function addFuncaoAcao(\Acl\Entity\FuncaoAcao $funcaoAcao)
    {
        $this->funcaoAcao[] = $funcaoAcao;

        return $this;
    }

    /**
     * Remove funcaoAcao
     *
     * @param \Acl\Entity\FuncaoAcao $funcaoAcao
     */
    public function removeFuncaoAcao(\Acl\Entity\FuncaoAcao $funcaoAcao)
    {
        $this->funcaoAcao->removeElement($funcaoAcao);
    }

    /**
     * Get funcaoAcao
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFuncaoAcao()
    {
        return $this->funcaoAcao;
    }
}
