<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $accountHolder;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $accountManager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getAccountHolder(): ?User
    {
        return $this->accountHolder;
    }

    public function setAccountHolder(?User $accountHolder): self
    {
        $this->accountHolder = $accountHolder;

        return $this;
    }

    public function getAccountManager(): ?User
    {
        return $this->accountManager;
    }

    public function setAccountManager(User $accountManager): self
    {
        $this->accountManager = $accountManager;

        return $this;
    }
}
