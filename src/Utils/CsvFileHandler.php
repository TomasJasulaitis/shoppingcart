<?php

namespace App\Utils;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CsvFileHandler implements FileSerializerInterface {

	const FORMAT = 'csv';

	private string $projectDir;
	/**
	 * @var Serializer
	 */
	private Serializer $serializer;

	public function __construct(string $projectDir) {
		$this->projectDir = $projectDir;
		$this->serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
	}

	public function decode($path) {
		return $this->serializer->decode(file_get_contents($path), self::FORMAT);
	}

	public function encode($data) {
		return $this->serializer->encode($data, self::FORMAT);
	}
}