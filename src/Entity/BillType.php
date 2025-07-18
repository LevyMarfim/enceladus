<?php

namespace App\Entity;

use App\Repository\BillTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillTypeRepository::class)]
class BillType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $bill = null;

    /**
     * @var Collection<int, Bill>
     */
    #[ORM\OneToMany(targetEntity: Bill::class, mappedBy: 'bill')]
    private Collection $bills;

    public function __construct()
    {
        $this->bills = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Bill>
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): static
    {
        if (!$this->bills->contains($bill)) {
            $this->bills->add($bill);
            $bill->setBill($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): static
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getBill() === $this) {
                $bill->setBill(null);
            }
        }

        return $this;
    }
}
