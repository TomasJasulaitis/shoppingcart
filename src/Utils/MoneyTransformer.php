<?php

namespace App\Utils;

use App\Entity\Money;

final class MoneyTransformer {

	private array $currencyRates;

	public function __construct($currencyRates) { //Filled from services.yaml
		$this->currencyRates = $currencyRates;
	}

	/**
	 * @inheritDoc
	 */
	public function transform(Money $money, $currency) {

		if ($money->areCurrenciesEqual($currency)) {
			return $money->getAmount();
		}
		$baseCurrency = $this->currencyRates[strtoupper($money->getCurrency())];
		$exchangeRate = $baseCurrency[strtoupper($currency)];
//		dump('Currency '.$money->getCurrency());
//		dump('Exchange Rate '.$exchangeRate);
//		dump('Amount '.$money->getAmount());
//		dump('Transformed '.$money->getAmount() * $exchangeRate);
		return $money->getAmount() * $exchangeRate;
	}
}