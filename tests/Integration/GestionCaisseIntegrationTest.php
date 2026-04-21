<?php

declare(strict_types=1);

use App\Caisse;
use App\Glace;
use App\Saveur;

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
}