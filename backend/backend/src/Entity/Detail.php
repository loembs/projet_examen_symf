<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
#[ORM\Table(name: "details")]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $qteVendu = null;

    #[ORM\Column]
    private ?float $prixVente = null;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: "details")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    #[ORM\ManyToOne(targetEntity: Dette::class, inversedBy: "details", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dette $dette = null;

    #[ORM\ManyToOne(targetEntity: Demande::class)]
    private ?Demande $demandesDette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteVendu(): ?int
    {
        return $this->qteVendu;
    }

    public function setQteVendu(int $qteVendu): static
    {
        $this->qteVendu = $qteVendu;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getDette(): ?Dette
    {
        return $this->dette;
    }

    public function setDette(?Dette $dette): static
    {
        $this->dette = $dette;

        return $this;
    }

    public function getDemandesDette(): ?Demande
    {
        return $this->demandesDette;
    }

    public function setDemandesDette(?Demande $demandesDette): static
    {
        $this->demandesDette = $demandesDette;

        return $this;
    }
}
