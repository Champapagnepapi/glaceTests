<?php

declare(strict_types=1);

use App\Client;
use App\Commande;
use App\Glace;
use App\Saveur;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private function creerGlace(string $nomSaveur, int $prixVente): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetPrixVente($prixVente);

        return $glace;
    }

    private function creerCommande(array $glaces): Commande
    {
        $commande = new Commande();
        foreach ($glaces as $glace) {
            $commande->ajouterGlace($glace);
        }

        return $commande;
    }

    public function testClientNomNonVide(): void
    {
        $client = new Client("Alice");

        $this->assertSame("Alice", $client->getNom());
    }

    public function testClientNomVideInterdit(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Le nom du client ne peut pas être vide.");

        new Client("");
    }

    public function testClientSansCommandeATotalZero(): void
    {
        $client = new Client("Bob");

        $this->assertSame(0, $client->getTotalDepense());
    }

    public function testClientTotalDepenseDescommandes(): void
    {
        $client = new Client("Charlie");

        $commande1 = $this->creerCommande([
            $this->creerGlace("Vanille", 5),
            $this->creerGlace("Chocolat", 4),
        ]);

        $commande2 = $this->creerCommande([
            $this->creerGlace("Fraise", 6),
        ]);

        $client->ajouterCommande($commande1);
        $client->ajouterCommande($commande2);

        $this->assertSame(15, $client->getTotalDepense());
    }
}
