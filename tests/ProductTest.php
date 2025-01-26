<?php

namespace Tests;

use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testCreationProduct(): void
    {
        $product = new Product("ballon",["USD"=>10,"EUR"=>11],"other");
        $this->assertEquals("ballon",$product->getName());
        $this->assertEquals("other",$product->getType());
        $this->assertEquals(["USD"=>10,"EUR"=>11],$product->getPrices());
    }

    public function testBadTypeCreationProduct(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product("ballon",["USD"=>10,"EUR"=>11],"rien");
    }

    public function testTaxeTVA(): void
    {
        $product = new Product("ballon",["USD"=>10,"EUR"=>11],"other");
        $this->assertEquals(0.2,$product->getTVA());
    }

    public function testTaxeTVAFood(): void
    {
        $product = new Product("poulet",["USD"=>10,"EUR"=>11],"food");
        $this->assertEquals(0.1,$product->getTVA());
    }

    public function testListCurrencies(): void
    {
        $product = new Product("poulet",["USD"=>10,"EUR"=>11,"YEN"=>30],"food");
        $list = $product->listCurrencies();
        $this->assertIsArray($list);
        $this->assertCount(2, $list);
        //$this->assertEquals(['USD','EUR','YEN'],$list);
    }

    public function testGetPrice(): void
    {
        $product = new Product("poulet",["USD"=>10,"EUR"=>11,"YEN"=>30],"food");
        $this->assertEquals(11,$product->getPrice("EUR"));
    }

    public function testBadWalletGetPrice(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product("poulet",["USD"=>10,"EUR"=>11,"YEN"=>30],"food");
        $product->getPrice("YEN");
    }


    public function testNotFoundWalletGetPrice(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product("poulet",["EUR"=>11,"YEN"=>30],"food");
        $product->getPrice("USD");
    }


}