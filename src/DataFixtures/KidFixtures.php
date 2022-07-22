<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Kid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class KidFixtures extends Fixture
{
    public const KIDS = [
        [
            'name' => 'Thomas',
            'birthdate' => '14-07-2021'
            
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::KIDS as $kidName) {
            $kid= new Kid();
            $kid->setName($kidName['name']);
            $kid->setBirthDate(new DateTime($kidName['birthdate']));
            $manager->persist($kid);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
