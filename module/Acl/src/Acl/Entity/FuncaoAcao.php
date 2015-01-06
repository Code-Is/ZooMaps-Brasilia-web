<?php

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FuncaoAcao
 *
 * @ORM\Table(name="funcao_acao", indexes={@ORM\Index(name="fk_funcao_acao_funcao1_idx", columns={"funcao_id"}), @ORM\Index(name="fk_funcao_acao_acao1_idx", columns={"acao_id"})})
 * @ORM\Entity(repositoryClass="Cadastro\Repository\FuncaoAcaoRepo")
 */
class FuncaoAcao
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
     * @var \Acl\Entity\Funcao
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Funcao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="funcao_id", referencedColumnName="id")
     * })
     */
    private $funcao;

    /**
     * @var \Acl\Entity\Acao
     *
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Acao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="acao_id", referencedColumnName="id")
     * })
     */
    private $acao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acl\Entity\Perfil", mappedBy="funcaoAcao")
     */
    private $perfil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->perfil = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set funcao
     *
     * @param \Acl\Entity\Funcao $funcao
     * @return FuncaoAcao
     */
    public function setFuncao(\Acl\Entity\Funcao $funcao = null)
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get funcao
     *
     * @return \Acl\Entity\Funcao 
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Set acao
     *
     * @param \Acl\Entity\Acao $acao
     * @return FuncaoAcao
     */
    public function setAcao(\Acl\Entity\Acao $acao = null)
    {
        $this->acao = $acao;

        return $this;
    }

    /**
     * Get acao
     *
     * @return \Acl\Entity\Acao 
     */
    public function getAcao()
    {
        return $this->acao;
    }

    /**
     * Add perfil
     *
     * @param \Acl\Entity\Perfil $perfil
     * @return FuncaoAcao
     */
    public function addPerfil(\Acl\Entity\Perfil $perfil)
    {
        $this->perfil[] = $perfil;

        return $this;
    }

    /**
     * Remove perfil
     *
     * @param \Acl\Entity\Perfil $perfil
     */
    public function removePerfil(\Acl\Entity\Perfil $perfil)
    {
        $this->perfil->removeElement($perfil);
    }

    /**
     * Get perfil
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}
