<?php

declare(strict_types=1);

use App\Caisse;
use App\Glace;
use App\Saveur;
use App\Commande;
use App\Stock;
use App\Client;

use PHPUnit\Framework\TestCase;

class GestionCaisseIntegrationTest extends TestCase
{
    private function creerGlace(string $nomSaveur, int $prixVente): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetIdentifiant("G_" . $nomSaveur);
        $glace->SetPrixVente($prixVente);

        return $glace;
    }

        public function testCaisseEncaissementMultiple(): void
    {
        $caisse = new Caisse();

        $this->assertSame(0, $caisse->getSolde());

        $caisse->encaisser(100);
        $this->assertSame(100, $caisse->getSolde());

        $caisse->encaisser(50);
        $this->assertSame(150, $caisse->getSolde());
    }

        public function testCaisseDecaissementValide(): void
    {
        $caisse = new Caisse();

        $caisse->encaisser(200);
        $caisse->decaisser(75);

        $this->assertSame(125, $caisse->getSolde());
    }

    public function testCaisseDecaissementInsuffisant(): void
    {
        $caisse = new Caisse();

        $caisse->encaisser(50);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Solde insuffisant pour ce décaissement.");

        $caisse->decaisser(100);
    }

    public function testCycleVenteAchatCaisse(): void
    {
        $stock = new Stock();
        $caisse = new Caisse();

        $glace = $this->creerGlace("Chocolat", 10);
        $stock->ajouter($glace, 5);


        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($stock->estDisponible($glace));
            $commande = new Commande();
            $commande->ajouterGlace($glace);
            $stock->retirer($glace, 1);
            $caisse->encaisser($commande->getTotal());
        }

        $this->assertSame(30, $caisse->getSolde());
        $this->assertSame(2, $stock->getQuantite($glace));
    }

}