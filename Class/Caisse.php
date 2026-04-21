<?php

declare(strict_types=1);

namespace App;

class Caisse
{
    private int $solde = 0;

    public function getSolde(): int
    {
        return $this->solde;
    }

    public function encaisser(int $montant): void
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException("Le montant doit être supérieur à zéro.");
        }

        $this->solde += $montant;
    }

    public function decaisser(int $montant): void
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException("Le montant doit être supérieur à zéro.");
        }

        if ($this->solde < $montant) {
            throw new \InvalidArgumentException("Solde insuffisant pour ce décaissement.");
        }

        $this->solde -= $montant;
    }
}
