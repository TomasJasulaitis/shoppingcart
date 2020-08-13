<?php

namespace App\Utils;

interface FileSerializerInterface {

	public function encode(array $data);

	public function decode(string $path);
}