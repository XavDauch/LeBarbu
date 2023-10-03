<?php

namespace App\DataFixtures;

use App\Entity\Bottle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class BottleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bottle= new Bottle();
        $bottle->setName('whisky');
        $bottle->setBrand('shivas');
        $bottle->setDescription('lorem ipsum');
        $manager->persist($bottle);
        $manager->flush();
    }
}
