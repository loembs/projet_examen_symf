<?php

namespace App\Entity;

use App\enum\Etatdemande;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(enumType: EtatDemande::class)]
    private ?EtatDemande $etat = EtatDemande::EN_COURS;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $dateRelance = null;

    #[ORM\Column(type: "float")]
    private ?float $montantDemande = null;

    #[ORM\OneToMany(mappedBy: "demande", targetEntity: Detail::class)]
    private Collection $details;


    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->updateAt = new \DateTimeImmutable();
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getEtat(): ?EtatDemande
    {
        return $this->etat;
    }

    public function setEtat(EtatDemande $etat): static
    {
        $this->etat = $etat;
        return $this;
    }

    public function getDateRelance(): ?\DateTimeImmutable
    {
        return $this->dateRelance;
    }

    public function setDateRelance(\DateTimeImmutable $dateRelance): static
    {
        $this->dateRelance = $dateRelance;
        return $this;
    }

    public function getMontantDemande(): ?float
    {
        return $this->montantDemande;
    }

    public function setMontantDemande(float $montantDemande): static
    {
        $this->montantDemande = $montantDemande;
        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setDemandesDette($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        $this->details->removeElement($detail);
        // set the owning side to null (unless already changed)
        if ($detail->getDemandesDette() === $this) {
            $detail->setDemandesDette(null);
        }

        return $this;
    }

}
