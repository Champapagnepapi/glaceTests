<?php

declare(strict_types=1);

use App\Commande;
use App\Glace;
use App\Saveur;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    private function creerGlace(string $nomSaveur, int $prixVente): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetPrixVente($prixVente);

        return $glace;
    }

    public function testCommandeVideATotalZero(): void
    {
        $commande = new Commande();

        $this->assertSame(0, $commande->getTotal());
    }

    public function testAjouterGlaceAugmenteLeNombre(): void
    {
        $commande = new Commande();

        $commande->ajouterGlace($this->creerGlace('Vanille', 5));

        $this->assertSame(1, $commande->getNombreGlaces());
    }

    public function testTotalCommandeAdditionneLesPrixDeVente(): void
    {
        $commande = new Commande();

        $commande->ajouterGlace($this->creerGlace('Chocolat', 4));
        $commande->ajouterGlace($this->creerGlace('Fraise', 6));

        $this->assertSame(10, $commande->getTotal());
    }
}