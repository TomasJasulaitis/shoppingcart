<?php

namespace App\DataFixtures;

use App\Entity\Money;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    $product = new Product();
	    $product->setName('Asus Zenbook');
	    $product->setCode('zen');
	    $product->setPrice(new Money(9999, 'USD'));
	    $manager->persist($product);

	    $product = new Product();
	    $product->setName('Macbook Pro');
	    $product->setCode('mbp');
	    $product->setPrice(new Money(2999, 'GBP'));
	    $manager->persist($product);

	    $product = new Product();
	    $product->setName('Lenovo P1');
	    $product->setCode('len');
	    $product->setPrice(new Money(12099, 'EUR'));
	    $manager->persist($product);

        $manager->flush();
    }
}
