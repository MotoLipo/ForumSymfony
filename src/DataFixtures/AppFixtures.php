<?php

namespace App\DataFixtures;

use App\Entity\Topics;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $topics = new Topics();
        $topics->setName('test1');
        $topics->setText('text1');
        $topics->setSlug('slug1');
        $manager->persist($topics);

        $topics = new Topics();
        $topics->setName('test2');
        $topics->setText('text2');
        $topics->setSlug('slug2');
        $manager->persist($topics);

        $topics = new Topics();
        $topics->setName('test3');
        $topics->setText('text3');
        $topics->setSlug('slug3');
        $manager->persist($topics);
        $manager->flush();
    }
}
