<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($prod = 1; $prod <= 10; $prod++) { 
            $product = new Products();
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000)); //Entre 9 et 1500€
            $product->setStock($faker->numberBetween(0, 10));
            $category = $this->getReference('cat-' . rand(1,8));
            $items = array("1", "2", "3", "4", "5", "6", "7", "8");
            $exclude = array("1", "5");
            $nItems = array_diff($items, $exclude);
            $rkey = array_rand($nItems);
            $election = $nItems[$rkey];
            $category = $this->getReference('cat-' . $election);

            $product->setCategories($category);
            $this->setReference('prod-' . $prod, $product);

            $manager->persist($product);
        }
        $manager->flush();
    }
}