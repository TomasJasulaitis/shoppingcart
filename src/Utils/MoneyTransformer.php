<?php

namespace App\Utils;

use App\Entity\Money;

final class MoneyTransformer {

	private array $currencyRates;
	private string $defaultCurrency;

	public function __construct($currencyRates, $defaultCurrency) { //Filled from services.yaml
		$this->currencyRates = $currencyRates;
		$this->defaultCurrency = $defaultCurrency;
	}

	/**
	 * @inheritDoc
	 */
	public function transform(Money $money, $currency) {

		$currentCurrency = $money->getCurrency();

		if (empty($currentCurrency)) {
			$money->setCurrency($this->defaultCurrency);
		}

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