<?php

namespace App\Entity;

use App\Repository\StatistiquesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatistiquesRepository::class)]
class Statistiques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pp37 = null;

    #[ORM\Column]
    private ?int $sav37 = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getpp37(): ?int
    {
        return $this->pp37;
    }

    public function setpp37(int $pp37): self
    {
        $this->pp37 = $pp37;

        return $this;
    }

    public function getsav37(): ?int
    {
        return $this->sav37;
    }

    public function setsav37(int $sav37): self
    {
        $this->sav37 = $sav37;

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
}
