<?php

declare(strict_types=1);

namespace App;

class Commande
{
    private array $glaces = [];

    public function ajouterGlace(Glace $glace): void
    {
        $this->glaces[] = $glace;
    }


    public function getGlaces(): array
    {
        return $this->glaces;
    }

    public function getNombreGlaces(): int
    {
        return count($this->glaces);
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->glaces as $glace) {
            $total += $glace->getPrixVente();
        }

        return $total;
    }
}