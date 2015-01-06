<?php

namespace Cadastro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animal
 *
 * @ORM\Table(name="animal", uniqueConstraints={@ORM\UniqueConstraint(name="nome_cientifico_UNIQUE", columns={"nome_cientifico"})}, indexes={@ORM\Index(name="fk_animal_ambiente1_idx", columns={"ambiente_id"}), @ORM\Index(name="fk_animal_atividade1_idx", columns={"atividade_id"}), @ORM\Index(name="fk_animal_alimentacao1_idx", columns={"alimentacao_id"}), @ORM\Index(name="fk_animal_recinto1_idx", columns={"recinto_id"})})
 * @ORM\Entity(repositoryClass="Cadastro\Repository\AnimalRepo")
 */
class Animal
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
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_cientifico", type="string", length=255, nullable=false)
     */
    private $nomeCientifico;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_conservacao", type="string", length=255, nullable=false)
     */
    private $estadoConservacao;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=false)
     */
    private $descricao;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagem", type="string", nullable=true)
     */
    private $imagem;

    /**
     * @var string
     *
     * @ORM\Column(name="localizacao_y", type="string", length=255, nullable=false)
     */
    private $localizacaoY;

    /**
     * @var string
     *
     * @ORM\Column(name="localizacao_x", type="string", length=255, nullable=false)
     */
    private $localizacaoX;

    /**
     * @var \Cadastro\Entity\Alimentacao
     *
     * @ORM\ManyToOne(targetEntity="Cadastro\Entity\Alimentacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="alimentacao_id", referencedColumnName="id")
     * })
     */
    private $alimentacao;

    /**
     * @var \Cadastro\Entity\Ambiente
     *
     * @ORM\ManyToOne(targetEntity="Cadastro\Entity\Ambiente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ambiente_id", referencedColumnName="id")
     * })
     */
    private $ambiente;

    /**
     * @var \Cadastro\Entity\Atividade
     *
     * @ORM\ManyToOne(targetEntity="Cadastro\Entity\Atividade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="atividade_id", referencedColumnName="id")
     * })
     */
    private $atividade;

    /**
     * @var \Cadastro\Entity\Recinto
     *
     * @ORM\ManyToOne(targetEntity="Cadastro\Entity\Recinto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recinto_id", referencedColumnName="id")
     * })
     */
    private $recinto;
    
    /**
     *
     * @var array
     */
    private $arquivo;
    
    public function getArquivo()
    {
        return $this->arquivo;
    }
    
    /**
     * 
     * @param array $arquivo
     * @return \Cadastro\Entity\Animal
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
        
        return $this;
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
     * @return Animal
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
     * Set nomeCientifico
     *
     * @param string $nomeCientifico
     * @return Animal
     */
    public function setNomeCientifico($nomeCientifico)
    {
        $this->nomeCientifico = $nomeCientifico;

        return $this;
    }

    /**
     * Get nomeCientifico
     *
     * @return string 
     */
    public function getNomeCientifico()
    {
        return $this->nomeCientifico;
    }

    /**
     * Set estadoConservacao
     *
     * @param string $estadoConservacao
     * @return Animal
     */
    public function setEstadoConservacao($estadoConservacao)
    {
        $this->estadoConservacao = $estadoConservacao;

        return $this;
    }

    /**
     * Get estadoConservacao
     *
     * @return string 
     */
    public function getEstadoConservacao()
    {
        return $this->estadoConservacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Animal
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get imagem
     *
     * @return string 
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set imagem
     *
     * @param string $imagem
     * @return Animal
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set localizacaoY
     *
     * @param string $localizacaoY
     * @return Animal
     */
    public function setLocalizacaoY($localizacaoY)
    {
        $this->localizacaoY = $localizacaoY;

        return $this;
    }

    /**
     * Get localizacaoY
     *
     * @return string 
     */
    public function getLocalizacaoY()
    {
        return $this->localizacaoY;
    }

    /**
     * Set localizacaoX
     *
     * @param string $localizacaoX
     * @return Animal
     */
    public function setLocalizacaoX($localizacaoX)
    {
        $this->localizacaoX = $localizacaoX;

        return $this;
    }

    /**
     * Get localizacaoX
     *
     * @return string 
     */
    public function getLocalizacaoX()
    {
        return $this->localizacaoX;
    }

    /**
     * Set alimentacao
     *
     * @param \Cadastro\Entity\Alimentacao $alimentacao
     * @return Animal
     */
    public function setAlimentacao(\Cadastro\Entity\Alimentacao $alimentacao = null)
    {
        $this->alimentacao = $alimentacao;

        return $this;
    }

    /**
     * Get alimentacao
     *
     * @return \Cadastro\Entity\Alimentacao 
     */
    public function getAlimentacao()
    {
        return $this->alimentacao;
    }

    /**
     * Set ambiente
     *
     * @param \Cadastro\Entity\Ambiente $ambiente
     * @return Animal
     */
    public function setAmbiente(\Cadastro\Entity\Ambiente $ambiente = null)
    {
        $this->ambiente = $ambiente;

        return $this;
    }

    /**
     * Get ambiente
     *
     * @return \Cadastro\Entity\Ambiente 
     */
    public function getAmbiente()
    {
        return $this->ambiente;
    }

    /**
     * Set atividade
     *
     * @param \Cadastro\Entity\Atividade $atividade
     * @return Animal
     */
    public function setAtividade(\Cadastro\Entity\Atividade $atividade = null)
    {
        $this->atividade = $atividade;

        return $this;
    }

    /**
     * Get atividade
     *
     * @return \Cadastro\Entity\Atividade 
     */
    public function getAtividade()
    {
        return $this->atividade;
    }

    /**
     * Set recinto
     *
     * @param \Cadastro\Entity\Recinto $recinto
     * @return Animal
     */
    public function setRecinto(\Cadastro\Entity\Recinto $recinto = null)
    {
        $this->recinto = $recinto;

        return $this;
    }

    /**
     * Get recinto
     *
     * @return \Cadastro\Entity\Recinto 
     */
    public function getRecinto()
    {
        return $this->recinto;
    }
}
