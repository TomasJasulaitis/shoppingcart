<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Repository\CartProductRepository;
use App\Utils\MoneyTransformer;
use Doctrine\ORM\EntityManagerInterface;

class CartHandler {

	private MoneyTransformer $moneyTransformer;
	private CartProductRepository $cartProductRepository;
	private EntityManagerInterface $entityManager;

	public function __construct(MoneyTransformer $moneyTransformer, CartProductRepository $cartProductRepository, EntityManagerInterface $entityManager) {
		$this->moneyTransformer = $moneyTransformer;
		$this->cartProductRepository = $cartProductRepository;
		$this->entityManager = $entityManager;
	}

	public function getCartTotal(Cart $cart, $currency = 'EUR') {
		$total = 0.0;

		foreach ($cart->getCartProducts() as $cartProduct) {
			$price = $cartProduct->getProduct()->getPrice();
			$total += $cartProduct->getQuantity() * $this->moneyTransformer->transform($price, $currency);
		}
		return $total / 100;
	}

	/**
	 * @param Cart $cart
	 * @param CartProduct $cartProduct
	 * @return string
	 * @throws \Exception
	 */
	public function handleCartProduct(Cart $cart, CartProduct $cartProduct) {

		$cartProductInDatabase = $cart->getIfHasCartProduct($cartProduct);

		if ((int)$cartProduct->getQuantity() < 0) {
			if (!$cartProductInDatabase) {
				throw new \Exception(sprintf('Unable to remove product because it is not in database: %s', $cartProduct));
			}
			$cart->removeCartProduct($cartProductInDatabase);
			$this->entityManager->flush();
			return sprintf("Removed product from cart: %s", $cartProductInDatabase);
		}

		if ($cartProductInDatabase) {
			$message = sprintf("Updated product information: \nprevious - %s \nnew- %s", $cartProductInDatabase, $cartProduct);
			$cartProductInDatabase->setQuantity($cartProduct->getQuantity());
			$cartProductInDatabase->setProduct($cartProduct->getProduct());
			$this->entityManager->flush();
			return $message;
		}
		$cart->addCartProduct($cartProduct);
		$this->entityManager->persist($cartProduct);
		$this->entityManager->persist($cart);
		$this->entityManager->flush();
		return sprintf("Added new product to cart: %s", $cartProduct);
	}
}