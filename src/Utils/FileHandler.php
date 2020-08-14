<?php

namespace App\Utils;

class FileHandler {

	const SEMICOLON = ';';
	const COMMA = ',';

	private array $delimiters = [
		self::SEMICOLON,
		self::COMMA,
	];

	public function replaceDelimiters(string $path, string $delimiter, $delimiters = []) {

		if (empty($path) or !realpath($path)) {
			return false;
		}

		if (empty($delimiter)) {
			return false;
		}

		if (empty($delimiters)) {
			$delimiters = $this->delimiters;
		}
		$str = file_get_contents($path);
		$str = str_replace($delimiters, $delimiter, $str);
		file_put_contents($path, $str);
		return true;
	}
}