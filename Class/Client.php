<?php

declare(strict_types=1);

namespace App;

class Client
{
    private string $nom;
    private array $commandes = [];

    public function __construct(string $nom)
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom du client ne peut pas être vide.");
        }
        $this->nom = $nom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function ajouterCommande(Commande $commande): void
    {
        $this->commandes[] = $commande;
    }


    public function getCommandes(): array
    {
        return $this->commandes;
    }

    public function getNombreCommandes(): int
    {
        return count($this->commandes);
    }

    public function getTotalDepense(): int
    {
        $total = 0;

        foreach ($this->commandes as $commande) {
            $total += $commande->getTotal();
        }

        return $total;
    }
}
