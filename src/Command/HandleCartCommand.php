<?php

namespace App\Command;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Money;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\CartHandler;
use App\Utils\FileHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HandleCartCommand extends Command {
	protected static $defaultName = 'handleCartCommand';

	private EntityManagerInterface $entityManager;
	private ProductRepository $productRepository;
	private CartHandler $cartHandler;
	private CartRepository $cartRepository;
	private string $projectDir;
	private FileHandler $fileHandler;
	private EncoderInterface $csvEncoder;

	public function __construct(
		ProductRepository $productRepository,
		CartHandler $cartHandler,
		CartRepository $cartRepository,
		$projectDir,
		FileHandler $fileHandler,
		EntityManagerInterface $entityManager
	) {
		parent::__construct();
		$this->entityManager = $entityManager;
		$this->productRepository = $productRepository;
		$this->cartHandler = $cartHandler;
		$this->cartRepository = $cartRepository;
		$this->projectDir = $projectDir;
		$this->fileHandler = $fileHandler;
	}

	protected function configure() {
		$this->setDescription('Handles all cart actions: add, remove, update');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$io = new SymfonyStyle($input, $output);
		$this->csvEncoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		//CSV is possible with only one delimiter.
		$this->fileHandler->replaceDelimiters($this->getCsvPath(), ';');
		$productData = $this->csvEncoder->decode(file_get_contents($this->getCsvPath()), CsvEncoder::FORMAT, [CsvEncoder::DELIMITER_KEY => ';']);
		$cart = $this->cartRepository->find(3);

		$usableData = $productData[0];
		dump($usableData);

		$product = new Product();
		$product->setName($usableData['product_name']);
		$product->setCode($usableData['product_code']);
		$product->setPrice(new Money((int)$usableData['product_price'] * 100, $usableData['product_currency']));
		$this->entityManager->persist($product);
		$this->entityManager->flush();

        $cartProduct = new CartProduct();
        $cartProduct->setProduct($product);
        $cartProduct->setQuantity($usableData['product_quantity']);
        $cartProduct->setCart($cart);

		$io->write($this->cartHandler->handleCartProduct($cart, $cartProduct));

		$io->write(sprintf("\nCart products:"));
		foreach ($cart->getCartProducts() as $cartProduct) {
			$io->write(sprintf('<info>%s</info>', $cartProduct));
		}
		$io->write(sprintf("\n<info>Current total is: %.2f </info>", $this->cartHandler->getCartTotal($cart)));
		return 0;
	}

	private function getCsvPath() {
		return $this->projectDir.'/src/Data/data.csv';
	}
}
