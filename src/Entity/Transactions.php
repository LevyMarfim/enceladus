<?php

namespace App\Entity;

use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use App\Repository\TransactionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $settlement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $transaction = null;

    #[ORM\Column(length: 255)]
    private ?OperationEnum $operation = null;

    #[ORM\Column(length: 255)]
    private ?TransactionTypeEnum $type = null;

    #[ORM\Column(length: 255)]
    private ?string $entry = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $invoice = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    private ?Assets $ticker = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?float $unitPrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSettlement(): ?\DateTime
    {
        return $this->settlement;
    }

    public function setSettlement(\DateTime $settlement): static
    {
        $this->settlement = $settlement;

        return $this;
    }

    public function getTransaction(): ?\DateTime
    {
        return $this->transaction;
    }

    public function setTransaction(\DateTime $transaction): static
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getOperation(): ?OperationEnum
    {
        return $this->operation;
    }

    public function setOperation(OperationEnum $operation): static
    {
        $this->operation = $operation;

        return $this;
    }

    public function getType(): ?TransactionTypeEnum
    {
        return $this->type;
    }

    public function setType(TransactionTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEntry(): ?string
    {
        return $this->entry;
    }

    public function setEntry(string $entry): static
    {
        $this->entry = $entry;

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

    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    public function setInvoice(?string $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getTicker(): ?Assets
    {
        return $this->ticker;
    }

    public function setTicker(?Assets $ticker): static
    {
        $this->ticker = $ticker;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;

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

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
