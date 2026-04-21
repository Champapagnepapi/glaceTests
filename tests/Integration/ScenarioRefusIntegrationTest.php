<?php

declare(strict_types=1);

use App\Caisse;
use App\Commande;
use App\Glace;
use App\Saveur;
use App\Stock;
use PHPUnit\Framework\TestCase;

class ScenarioRefusIntegrationTest extends TestCase
{
    private function creerGlace(string $nomSaveur, int $prixVente): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetIdentifiant("G_" . $nomSaveur);
        $glace->SetPrixVente($prixVente);

        return $glace;
    }

    public function testRefuserVenteStockEpuise(): void
    {
        $stock = new Stock();
        $glace = $this->creerGlace("Fraise", 5);

        $stock->ajouter($glace, 1);


        $commande1 = new Commande();
        $commande1->ajouterGlace($glace);
        $stock->retirer($glace, 1);

        $this->assertFalse($stock->estDisponible($glace));


        $commande2 = new Commande();
        $commande2->ajouterGlace($glace);

        $this->expectException(\InvalidArgumentException::class);

        $stock->retirer($glace, 1);
    }

    public function testAbortCommandeSiStockInsuffisant(): void
    {
        $stock = new Stock();
        $caisse = new Caisse();

        $glace1 = $this->creerGlace("Vanille", 4);
        $glace2 = $this->creerGlace("Chocolat", 5);

        $stock->ajouter($glace1, 2);
        $stock->ajouter($glace2, 1);

  
        $commande = new Commande();
        $commande->ajouterGlace($glace1);
        $commande->ajouterGlace($glace1);
        $commande->ajouterGlace($glace2);
        $commande->ajouterGlace($glace2);

        $caisse->encaisser(50);


        $this->assertSame(2, $stock->getQuantite($glace1));
        $this->assertSame(1, $stock->getQuantite($glace2));
        $this->assertSame(50, $caisse->getSolde());


        $this->expectException(\InvalidArgumentException::class);
        $stock->retirer($glace2, 2);
    }

    public function testCommitmentComplet(): void
    {

        $stock = new Stock();
        $caisse = new Caisse();

        $glace = $this->creerGlace("Pistache", 6);
        $stock->ajouter($glace, 5);

        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue($stock->estDisponible($glace));
            $commande = new Commande();
            $commande->ajouterGlace($glace);
            $stock->retirer($glace, 1);
            $caisse->encaisser($commande->getTotal());
        }

        $this->assertFalse($stock->estDisponible($glace));


        $commande6 = new Commande();
        $commande6->ajouterGlace($glace);

        $this->expectException(\InvalidArgumentException::class);
        $stock->retirer($glace, 1);


        $this->assertSame(30, $caisse->getSolde());
        $this->assertSame(0, $stock->getQuantite($glace));
    }
}
