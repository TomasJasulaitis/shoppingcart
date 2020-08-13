<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;
	/**
	 * @ORM\Embedded(class="Money")
	 */
    private Money $price;

    public function __toString() {
    	return "Id: ".$this->getId()." | Name: ".$this->getName()." | Price: ".$this->getPrice();
    }

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

	public function getPrice(): Money
	{
		return $this->price;
	}

	public function setPrice(Money $price): self
	{
		$this->price = $price;

		return $this;
	}
}
