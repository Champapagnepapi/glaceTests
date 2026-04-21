<?php

declare(strict_types=1);

namespace App;

class Stock
{
  
    private array $quantites = [];

    public function ajouter(Glace $glace, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité doit être supérieure à zéro.");
        }

        $id = $glace->getIdentifiant();
        if (!isset($this->quantites[$id])) {
            $this->quantites[$id] = 0;
        }

        $this->quantites[$id] += $quantite;
    }

    public function retirer(Glace $glace, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité doit être supérieure à zéro.");
        }

        $id = $glace->getIdentifiant();
        if (!isset($this->quantites[$id]) || $this->quantites[$id] < $quantite) {
            throw new \InvalidArgumentException("Stock insuffisant pour cette glace.");
        }

        $this->quantites[$id] -= $quantite;
    }

    public function getQuantite(Glace $glace): int
    {
        $id = $glace->getIdentifiant();
        return $this->quantites[$id] ?? 0;
    }

    public function estDisponible(Glace $glace): bool
    {
        return $this->getQuantite($glace) > 0;
    }
}
