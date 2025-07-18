<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(inversedBy: 'bills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BillType $bill = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    private ?Company $company = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateReference = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBill(): ?BillType
    {
        return $this->bill;
    }

    public function setBill(?BillType $bill): static
    {
        $this->bill = $bill;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getDateReference(): ?\DateTime
    {
        return $this->dateReference;
    }

    public function setDateReference(\DateTime $dateReference): static
    {
        $this->dateReference = $dateReference;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
