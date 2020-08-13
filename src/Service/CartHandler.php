<?php

namespace App\Service;

use App\Entity\Cart;
use App\Utils\MoneyTransformer;

class CartHandler {

	private MoneyTransformer $moneyTransformer;

	public function __construct(MoneyTransformer $moneyTransformer) {
		$this->moneyTransformer = $moneyTransformer;
	}

	public function getCartTotal(Cart $cart, $currency = 'EUR') {
		$total = 0.0;

		foreach ($cart->getCartProducts() as $cartProduct) {
			$price = $cartProduct->getProduct()->getPrice();
			$total += $cartProduct->getQuantity() * $this->moneyTransformer->transform($price, $currency);
//			dump('Total '.$total);
		}
		return $total;
	}
}