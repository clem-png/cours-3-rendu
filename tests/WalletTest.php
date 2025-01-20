<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testCreationWallet(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
        $this->assertEquals(0, $wallet->getBalance());
    }

    public function testSetBalance(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testSetBalanceNegative(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('USD');
        $wallet->setBalance(-100);
    }

    public function testSetCurrency(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setCurrency('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    public function testSetCurrencyNotGood(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('USD');
        $wallet->setCurrency('APU');
    }

    public function testRemoveFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $wallet->removeFund(50);
        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testRemoveFundInsufficient(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('USD');
        $wallet->setBalance(50);
        $wallet->removeFund(100);
    }

    public function testAddFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(50);
        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testAddFundNegative(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('USD');
        $wallet->addFund(-50);
    }
}
