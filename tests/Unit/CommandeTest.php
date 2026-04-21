<?php

declare(strict_types=1);

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

   
}