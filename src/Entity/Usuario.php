<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 * @UniqueEntity("email", message="Esse e-mail já está em uso.")
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Campo nome não pode ser vazio!")
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Campo e-mail não pode ser vazio!")
     * @Assert\Email(message="Informe um e-mail válido")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Informe sua senha!")
     */
    private $senha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     */
    private $data_cadastro;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $data_alteracao;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Servico", mappedBy="usuario")
     */
    private $servicos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contratacoes", mappedBy="cliente")
     */
    private $compras;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contratacoes", mappedBy="freelancer")
     */
    private $vendas;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DadosPessoais", cascade={"persist", "remove"})
     */
    private $dados_pessoais;

    public function __construct()
    {
        $this->status = false;
        $this->servicos = new ArrayCollection();
        $this->compras = new ArrayCollection();
        $this->vendas = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

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

    public function setRoles($roles) : self
    {
        $this->roles[] = $roles;
        return $this;
    }

    public function limparRoles(): self
    {
        $this->roles = [];
        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() : string
    {
        return $this->senha;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() : string
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
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
            $servico->setUsuario($this);
        }

        return $this;
    }

    public function removeServico(Servico $servico): self
    {
        if ($this->servicos->contains($servico)) {
            $this->servicos->removeElement($servico);
            // set the owning side to null (unless already changed)
            if ($servico->getUsuario() === $this) {
                $servico->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contratacoes[]
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Contratacoes $compra): self
    {
        if (!$this->compras->contains($compra)) {
            $this->compras[] = $compra;
            $compra->setCliente($this);
        }

        return $this;
    }

    public function removeCompra(Contratacoes $compra): self
    {
        if ($this->compras->contains($compra)) {
            $this->compras->removeElement($compra);
            // set the owning side to null (unless already changed)
            if ($compra->getCliente() === $this) {
                $compra->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contratacoes[]
     */
    public function getVendas(): Collection
    {
        return $this->vendas;
    }

    public function addVenda(Contratacoes $venda): self
    {
        if (!$this->vendas->contains($venda)) {
            $this->vendas[] = $venda;
            $venda->setFreelancer($this);
        }

        return $this;
    }

    public function removeVenda(Contratacoes $venda): self
    {
        if ($this->vendas->contains($venda)) {
            $this->vendas->removeElement($venda);
            // set the owning side to null (unless already changed)
            if ($venda->getFreelancer() === $this) {
                $venda->setFreelancer(null);
            }
        }

        return $this;
    }

    public function getDadosPessoais(): ?DadosPessoais
    {
        return $this->dados_pessoais;
    }

    public function setDadosPessoais(?DadosPessoais $dados_pessoais): self
    {
        $this->dados_pessoais = $dados_pessoais;

        return $this;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->nome,
            $this->email,
            $this->senha,
            $this->roles,
            $this->status
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->nome,
            $this->email,
            $this->senha,
            $this->roles,
            $this->status
            ) = unserialize($serialized, ['allowed_class' => false]);
    }
}
