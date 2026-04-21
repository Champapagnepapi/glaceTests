<?php

declare(strict_types=1);

class StockTest extends TestCase
{
    private function creerGlace(string $nomSaveur): Glace
    {
        $saveur = new Saveur($nomSaveur);
        $glace = new Glace($nomSaveur, $saveur);
        $glace->SetIdentifiant("G_" . $nomSaveur);

        return $glace;
    }
}