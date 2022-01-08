<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 10; $i++)
        {
            $subject = new Subject;
            $subject->setCode("WEBG301");
            $subject->setName("Project Web");
            $subject->setImage("subpic.png");
            $subject->setDescription("2nd part of Computing Research Project!");
            $subject->setFee("3200000"); 

            $manager->persist($subject);
        }

        $manager->flush();
    }
}
