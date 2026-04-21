<?php

declare(strict_types=1);

use App\Glace;
use App\Saveur;
use App\Stock;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    private function creerGlace(string $nomSaveur): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetIdentifiant("G_" . $nomSaveur);

        return $glace;
    }

    public function testStockVideNePasDisponible(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Vanille");

        $this->assertFalse($stock->estDisponible($glace));
    }

    public function testAjouterGlaceAuStock(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Chocolat");

        $stock->ajouter($glace, 5);

        $this->assertSame(5, $stock->getQuantite($glace));
    }

    public function testRetirerGlaceAuStock(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Fraise");

        $stock->ajouter($glace, 10);
        $stock->retirer($glace, 3);

        $this->assertSame(7, $stock->getQuantite($glace));
    }

    public function testEstDisponibleSiQuantitePositive(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Pistache");

        $stock->ajouter($glace, 2);

        $this->assertTrue($stock->estDisponible($glace));
    }

    public function testRetirerPlusQueStockInterdit(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Menthe");

        $stock->ajouter($glace, 2);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Stock insuffisant pour cette glace.");

        $stock->retirer($glace, 3);
    }
}
