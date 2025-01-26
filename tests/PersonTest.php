<?php


namespace Tests;

use App\Entity\Product;
use App\Entity\Wallet;
use App\Entity\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testCreationPerson(): void
    {
        $person = new Person("john","USD");
        $this->assertEquals('john', $person->getName());
        $this->assertEquals('USD', $person->getWallet()->getCurrency());
    }

    public function testSetName(): void
    {
        $person = new Person("john","USD");
        $person->setName("ouioui");
        $this->assertEquals('ouioui', $person->getName());
    }

    public function testSetWallet(): void
    {
        $person = new Person("john","USD");
        $person->setWallet(new Wallet("EUR"));
        $this->assertEquals('EUR', $person->getWallet()->getCurrency());
    }

    public function testHasFund(): void
    {
        $person = new Person("john","USD");
        $wallet = new Wallet("EUR");
        $wallet->setBalance(20);
        $person->setWallet($wallet);
        $this->assertEquals(true, $person->hasFund());
    }

    public function testHasNotFund(): void
    {
        $person = new Person("john","USD");
        $this->assertEquals(false, $person->hasFund());
    }

    public function testGoodtransfertFund(): void
    {
        $person1 = new Person("john","USD");
        $person1->wallet->addFund(90);
        $person2 = new Person("wick","USD");
        $person1->transfertFund(30,$person2);
        $this->assertEquals(30.0,$person2->getWallet()->getBalance());
    }

    public function testBadCurrencytransfertFund(): void
    {
        $this->expectException(\Exception::class);
        $person1 = new Person("john","USD");
        $person1->wallet->addFund(90);
        $person2 = new Person("wick","EUR");
        $person1->transfertFund(30,$person2);
    }

    public function testDivideWallet(): void
    {
        $personDonnant = new Person("john","USD");
        $personDonnant->wallet->addFund(90);

        $person1 = new Person("Doe", "USD");
        $person2 = new Person("wick","USD");

        $personDonnant->divideWallet([$person1,$person2]);
        $this->assertEquals(45,$person1->getWallet()->getBalance());
        $this->assertEquals(45,$person2->getWallet()->getBalance());
    }

    public function testBuyProduct(): void
    {
        $person = new Person("john","USD");
        $person->wallet->addFund(90);
        $product = new Product("ballon",["USD"=>10,"EUR"=>11],"other");
        $person->buyProduct($product);
        $this->assertEquals(80,$person->getWallet()->getBalance());
    }

    public function testBadCurrencieBuyProduct(): void
    {
        $this->expectException(\Exception::class);
        $person = new Person("john","USD");
        $person->wallet->addFund(90);
        $product = new Product("ballon",["EUR"=>11],"other");
        $person->buyProduct($product);
    }

}