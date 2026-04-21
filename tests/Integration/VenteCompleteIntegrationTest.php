<?php

declare(strict_types=1);

use App\Caisse;
use App\Client;
use App\Commande;
use App\Glace;
use App\Saveur;
use App\Stock;
use PHPUnit\Framework\TestCase;

class VenteCompleteIntegrationTest extends TestCase
{
    private function creerGlace(string $nomSaveur, int $prixVente, int $prixAchat = 2): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetIdentifiant("G_" . $nomSaveur);
        $glace->SetPrixVente($prixVente);
        $glace->SetPrixAchat($prixAchat);

        return $glace;
    }

    public function testVenteComplete(): void
    {
       
        $stock = new Stock();
        $glaceChocolat = $this->creerGlace("Chocolat", 5, 2);
        $glaceVanille = $this->creerGlace("Vanille", 4, 2);

        $stock->ajouter($glaceChocolat, 10);
        $stock->ajouter($glaceVanille, 10);

        $client = new Client("Alice");
        $commande = new Commande();

        $commande->ajouterGlace($glaceChocolat);
        $commande->ajouterGlace($glaceVanille);


        $this->assertTrue($stock->estDisponible($glaceChocolat));
        $this->assertTrue($stock->estDisponible($glaceVanille));

        $stock->retirer($glaceChocolat, 1);
        $stock->retirer($glaceVanille, 1);


        $caisse = new Caisse();
        $caisse->encaisser($commande->getTotal());

        $this->assertSame(9, $stock->getQuantite($glaceChocolat));
        $this->assertSame(9, $stock->getQuantite($glaceVanille));
        $this->assertSame(9, $caisse->getSolde());
    }

    public function testRefuserCommandeStockInsuffisant(): void
    {
   
        $stock = new Stock();
        $glaceChocolat = $this->creerGlace("Chocolat", 5);

        $stock->ajouter($glaceChocolat, 1);


        $client = new Client("Bob");
        $commande = new Commande();

        for ($i = 0; $i < 3; $i++) {
            $commande->ajouterGlace($glaceChocolat);
        }

    
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Stock insuffisant pour cette glace.");

        $stock->retirer($glaceChocolat, 3);
    }

    public function testPlusieursCommandesConsecutives(): void
    {
        $stock = new Stock();
        $glaceChocolat = $this->creerGlace("Chocolat", 5);
        $glaceVanille = $this->creerGlace("Vanille", 4);

        $stock->ajouter($glaceChocolat, 10);
        $stock->ajouter($glaceVanille, 10);

        $client = new Client("Charlie");
        $caisse = new Caisse();


        $commande1 = new Commande();
        $commande1->ajouterGlace($glaceChocolat);
        $stock->retirer($glaceChocolat, 1);
        $caisse->encaisser($commande1->getTotal());
        $client->ajouterCommande($commande1);


        $commande2 = new Commande();
        $commande2->ajouterGlace($glaceVanille);
        $commande2->ajouterGlace($glaceChocolat);
        $stock->retirer($glaceVanille, 1);
        $stock->retirer($glaceChocolat, 1);
        $caisse->encaisser($commande2->getTotal());
        $client->ajouterCommande($commande2);

        $this->assertSame(2, $client->getNombreCommandes());
        $this->assertSame(14, $caisse->getSolde());
        $this->assertSame(8, $stock->getQuantite($glaceChocolat));
        $this->assertSame(9, $stock->getQuantite($glaceVanille));
        $this->assertSame(14, $client->getTotalDepense());
    }
}
