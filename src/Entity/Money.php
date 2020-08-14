<?php

namespace App\Entity;

use App\Repository\MoneyRepository;
use App\Utils\MoneyTransformerInterface;
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
	private int $amount;

    /**
     * @ORM\Column(type="string", length=255, options={"default"="EUR"})
     */
	private string $currency;

	public function __construct(int $amount, string $currency) {
	    $this->amount = $amount;
	    $this->currency = $currency;
    }

    public function __toString() {
		return "Amount: ".$this->getAmount()." Currency: ".$this->getCurrency();
    }

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

    public function areCurrenciesEqual(string $currency) {
		if (strtoupper($this->currency) === strtoupper($currency)) {
			return true;
		}
		return false;
    }
}
