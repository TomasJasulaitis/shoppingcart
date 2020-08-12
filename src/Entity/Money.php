<?php

namespace App\Entity;

use App\Repository\MoneyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MoneyRepository::class)
 */

/**
 * @ORM\Embeddable()
 */
class Money
{
    /**
     * @ORM\Column(type="integer", options={ "default" = 0 })
     */
    private $amount;

    /**
     * @Assert\Choice(choices = {"EUR", "GBP", "USD"})
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
