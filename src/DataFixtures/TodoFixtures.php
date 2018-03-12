<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Todo;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $time = date("h:i:s");
        $date = date("j-m-Y");

        for ($i = 0; $i <= 5; $i++) {
            $todo = new Todo();
            $todo->setLibelle('TODO '.$i);
            $todo->setDescription('This is the '.$i.' description sample !');
            $todo->setDatetime(DateTime::createFromFormat('d-m-Y H:i:s', $date.' '.$time));
            $todo->setState(1);
            $todo->setUid(1);
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
