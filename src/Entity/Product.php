<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product {
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

	/**
	 * @ORM\Column(unique=true, type="string", length=255)
	 */
	private string $code;

	/**
	 * @var CartProduct[]|ArrayCollection $cartProducts
	 * @ORM\OneToMany(targetEntity="App\Entity\CartProduct", mappedBy="product")
	 *
	 */
	private $cartProducts;

	public function __toString() {
		return "Code: ".$this->getCode()." | Name: ".$this->getName()." | Price: ".$this->getPrice();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	public function getPrice(): Money {
		return $this->price;
	}

	public function setPrice(Money $price): self {
		$this->price = $price;

		return $this;
	}

	public function getCode(): ?string {
		return $this->code;
	}

	public function setCode(string $code): self {
		$this->code = $code;

		return $this;
	}

}
