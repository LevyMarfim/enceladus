<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $bill = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBill(): ?string
    {
        return $this->bill;
    }

    public function setBill(string $bill): static
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
}
