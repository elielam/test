<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="APP_OPERATIONS_MINUS")
 * @ORM\Entity(repositoryClass="App\Repository\OperationMinusRepository")
 */
class OperationMinus implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=false, nullable=false)
     */
    private $libelle;

    /**
     * @Assert\DateTime()
     * @ORM\Column(type="datetime", unique=false, nullable=false)
     */
    private $datetime;

    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     */
    private $sum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaymentCategory", inversedBy="operationsMinus")
     * @ORM\JoinColumn(nullable=true, unique=false, referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="operationsMinus")
     * @ORM\JoinColumn(nullable=true, unique=false, referencedColumnName="id")
     */
    private $account;

    /**
     * @ORM\Column(type="boolean", unique=false, nullable=false)
     */
    private $isDebit;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime($datetime): void
    {
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return mixed $account
     */
    public function setAccount($account): void
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getIsDebit()
    {
        return $this->isDebit;
    }

    /**
     * @param mixed $isDebit
     */
    public function setIsDebit($isDebit): void
    {
        $this->isDebit = $isDebit;
    }

    /**
     * @return PaymentCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function validateOperationMinus () {
        if($this->isDebit === false) {
            $account = $this->getAccount();
            $balance = $account->getBalance();
            $newBalance = $balance - $this->getSum();
            $account->setBalance($newBalance);
            $this->isDebit = true;
        }
    }

    public function invalidateOperationMinus () {
        if($this->isDebit === true) {
            $account = $this->getAccount();
            $balance = $account->getBalance();
            $newBalance = $balance + $this->getSum();
            $account->setBalance($newBalance);
            $this->isDebit = false;
        }
    }

    public function serialize()
    {

    }

    public function unserialize($serialized)
    {

    }
}
