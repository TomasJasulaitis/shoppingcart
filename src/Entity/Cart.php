<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity=CartProduct::class, mappedBy="cart", orphanRemoval=true)
	 */
	private $cartProducts;

	public function __construct() {
		$this->cartProducts = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return Collection|CartProduct[]
	 */
	public function getCartProducts(): Collection {
		return $this->cartProducts;
	}

	public function addCartProduct(CartProduct $cartProduct): self {
		if (!$this->cartProducts->contains($cartProduct)) {
			$this->cartProducts[] = $cartProduct;
			$cartProduct->setCart($this);
		}

		return $this;
	}

	public function removeCartProduct(CartProduct $cartProduct): self {
		if ($this->cartProducts->contains($cartProduct)) {
			$this->cartProducts->removeElement($cartProduct);
			// set the owning side to null (unless already changed)
			if ($cartProduct->getCart() === $this) {
				$cartProduct->setCart(null);
			}
		}
		return $this;
	}

	public function getIfHasCartProduct(CartProduct $cartProduct) {
		foreach ($this->getCartProducts() as $currentCartProduct) {
			if ($currentCartProduct->hasProduct($cartProduct->getProduct()->getCode())) {
				return $currentCartProduct;
			}
		}
		return null;
	}
}
