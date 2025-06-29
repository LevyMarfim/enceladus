<?php

namespace App\Entity;

use App\Enums\OperationEnum;
use App\Enums\TransactionTypeEnum;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $entry = null;

    #[ORM\Column(enumType: OperationEnum::class)]
    private ?OperationEnum $operation = null;

    #[ORM\Column(enumType: TransactionTypeEnum::class)]
    private ?TransactionTypeEnum $type = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(nullable: true)]
    private ?int $invoice = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?Asset $ticker = null;

    #[ORM\Column(nullable: true)]
    private ?int $amount = null;

    #[ORM\Column(nullable: true)]
    private ?float $unitPrice = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $settlementDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $transactionDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getInvoice(): ?int
    {
        return $this->invoice;
    }

    public function setInvoice(int $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getTicker(): ?Asset
    {
        return $this->ticker;
    }

    public function setTicker(?Asset $ticker): static
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

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getSettlementDate(): ?\DateTime
    {
        return $this->settlementDate;
    }

    public function setSettlementDate(\DateTime $settlementDate): static
    {
        $this->settlementDate = $settlementDate;

        return $this;
    }

    public function getTransactionDate(): ?\DateTime
    {
        return $this->transactionDate;
    }

    public function setTransactionDate(\DateTime $transactionDate): static
    {
        $this->transactionDate = $transactionDate;

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
