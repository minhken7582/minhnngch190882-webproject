<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 10; $i++)
        {
            $teacher = new Teacher;
            $teacher->setName("Teacher $i");
            $teacher->setBirthday(\DateTime::createFromFormat('Y-m-d','1979-11-12'));
            $teacher->setAddress("Ha Noi");
            $teacher->setMobile("0912345678");
            $teacher->setEmail("teacher@fpt.edu.vn"); 

            $manager->persist($teacher);
        }
        
        $manager->flush();
    }
}
