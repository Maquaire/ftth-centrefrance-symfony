<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255)]
    private ?string $manager = null;

    #[ORM\Column(length: 255)]
    private ?string $job = null;

    #[ORM\Column(nullable: true)]
    private ?int $number_dit = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_report = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_sheet_height = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_sheet_carrycot = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_pro = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_d15 = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_refusal_any_work = 0;

    #[ORM\Column(nullable: true)]
    private ?int $number_connexion = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $departement = null;

    #[ORM\Column]
    private ?int $upr = null;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getNumberDit(): ?int
    {
        return $this->number_dit;
    }

    public function setNumberDit(?int $number_dit): self
    {
        $this->number_dit = $number_dit;

        return $this;
    }

    public function getNumberReport(): ?int
    {
        return $this->number_report;
    }

    public function setNumberReport(int $number_report): self
    {
        $this->number_report = $number_report;

        return $this;
    }

    public function getNumberSheetHeight(): ?int
    {
        return $this->number_sheet_height;
    }

    public function setNumberSheetHeight(?int $number_sheet_height): self
    {
        $this->number_sheet_height = $number_sheet_height;

        return $this;
    }

    public function getNumberPro(): ?int
    {
        return $this->number_pro;
    }

    public function setNumberPro(?int $number_pro): self
    {
        $this->number_pro = $number_pro;

        return $this;
    }

    public function getNumberRefusalAnyWork(): ?int
    {
        return $this->number_refusal_any_work;
    }

    public function setNumberRefusalAnyWork(?int $number_refusal_any_work): self
    {
        $this->number_refusal_any_work = $number_refusal_any_work;

        return $this;
    }

    public function getNumberConnexion(): ?int
    {
        return $this->number_connexion;
    }

    public function setNumberConnexion(?int $numer_connexion): self
    {
        $this->number_connexion = $numer_connexion;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getUpr(): ?int
    {
        return $this->upr;
    }

    public function setUpr(int $upr): self
    {
        $this->upr = $upr;

        return $this;
    }

    /**
     * Get the value of number_d15
     */ 
    public function getNumber_d15()
    {
        return $this->number_d15;
    }

    /**
     * Set the value of number_d15
     *
     * @return  self
     */ 
    public function setNumber_d15($number_d15)
    {
        $this->number_d15 = $number_d15;

        return $this;
    }

    /**
     * Get the value of number_sheet_carrycot
     */ 
    public function getNumber_sheet_carrycot()
    {
        return $this->number_sheet_carrycot;
    }

    /**
     * Set the value of number_sheet_carrycot
     *
     * @return  self
     */ 
    public function setNumber_sheet_carrycot($number_sheet_carrycot)
    {
        $this->number_sheet_carrycot = $number_sheet_carrycot;

        return $this;
    }
}
