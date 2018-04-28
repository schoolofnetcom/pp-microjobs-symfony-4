<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $data_cadastro;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $data_alteracao;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Servico", inversedBy="categorias")
     */
    private $servicos;

    public function __construct()
    {
        $this->servicos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeImmutable
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro(\DateTimeImmutable $data_cadastro): self
    {
        $this->data_cadastro = $data_cadastro;

        return $this;
    }

    public function getDataAlteracao(): ?\DateTimeImmutable
    {
        return $this->data_alteracao;
    }

    public function setDataAlteracao(?\DateTimeImmutable $data_alteracao): self
    {
        $this->data_alteracao = $data_alteracao;

        return $this;
    }

    /**
     * @return Collection|Servico[]
     */
    public function getServicos(): Collection
    {
        return $this->servicos;
    }

    public function addServico(Servico $servico): self
    {
        if (!$this->servicos->contains($servico)) {
            $this->servicos[] = $servico;
        }

        return $this;
    }

    public function removeServico(Servico $servico): self
    {
        if ($this->servicos->contains($servico)) {
            $this->servicos->removeElement($servico);
        }

        return $this;
    }
}
