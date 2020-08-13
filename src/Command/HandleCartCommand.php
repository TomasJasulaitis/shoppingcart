<?php

namespace App\Command;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Money;
use App\Entity\Product;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\CartHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HandleCartCommand extends Command
{
    protected static $defaultName = 'handleCartCommand';
	/**
	 * @var EntityManagerInterface
	 */
	private EntityManagerInterface $entityManager;
	/**
	 * @var ProductRepository
	 */
	private ProductRepository $productRepository;
	/**
	 * @var CartHandler
	 */
	private CartHandler $cartHandler;
	private CartRepository $cartRepository;

	public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartHandler $cartHandler, CartRepository $cartRepository) {
		$this->productRepository = $productRepository;
    	$this->entityManager = $entityManager;
    	$this->cartHandler = $cartHandler;
    	$this->cartRepository = $cartRepository;
	    parent::__construct();
    }

	protected function configure()
    {
        $this->setDescription('Handles all cart actions: add, remove, update');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

//        $product = new Product();
//        $product->setName('test');
//        $product->setPrice(new Money(100, 'USD'));
//
//        $cartProduct = new CartProduct();
//        $cartProduct->setProduct($product);
//        $cartProduct->setQuantity(5);

        $cart = $this->cartRepository->find(1);
//        $cart->addCartProduct($cartProduct);
//
//        $this->entityManager->persist($product);
//        $this->entityManager->persist($cartProduct);
//        $this->entityManager->persist($cart);
//        $this->entityManager->flush();

	    $currentTotal = $this->cartHandler->getCartTotal($cart);
	    $io->writeln(sprintf('<info>Current total is: %.2f </info>>', $currentTotal));

        return 0;
    }
}
