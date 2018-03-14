<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\OperationMinus;
use App\Entity\OperationPlus;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Collection;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $time = date("h:i:s");
        $date = date("j-m-Y");

        for ($j = 1; $j < 6; $j++) {
            $balance = rand(500, 10000);
            $interestedDraft = rand (1*10, 3*10) / 10;
            $overdraft = rand(0, -500);

            $account = new Account();
            $account->setLibelle('Account N°'.$j);
            $account->setType(1); // 1 : Visa | 2 : Mastercard | 0 : Autres
            $account->setBalance($balance);
            $account->setInterestDraft($interestedDraft);
            $account->setOverdraft($overdraft);
            if ($j == 1 || $j == 2) {
                $account->setUser($this->getReference(UserFixtures::ELIE_USER_REF));
            } elseif ($j == 3 || $j == 4) {
                $account->setUser($this->getReference(UserFixtures::TEST_USER_REF));
            } else {
                $account->setUser($this->getReference(UserFixtures::ADMIN_USER_REF));
            }


            for ($i = 1; $i < 11; $i++) {
                $plusSum = rand(0, 1000);

                $operationPlus = new OperationPlus();
                $operationPlus->setLibelle('Account N°'.$j.' Operation N°'.$i);
                $operationPlus->setDatetime(DateTime::createFromFormat('d-m-Y H:i:s', $date.' '.$time));
                $operationPlus->setSum($plusSum);
                $operationPlus->setAccount($account);
                $manager->persist($operationPlus);
            }

            for ($i = 1; $i < 11; $i++) {
                $minusSum = rand(0, 1000);

                $operationMinus = new OperationMinus();
                $operationMinus->setLibelle('Account N°'.$j.' Operation N°'.$i);
                $operationMinus->setDatetime(DateTime::createFromFormat('d-m-Y H:i:s', $date.' '.$time));
                $operationMinus->setSum($minusSum);
                $operationMinus->setAccount($account);
                $manager->persist($operationMinus);
            }

            $manager->persist($account);
        }



        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return array(
          UserFixtures::class
        );
    }
}
