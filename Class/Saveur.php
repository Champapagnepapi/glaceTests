<?php

declare(strict_types=1);

namespace App;

class Saveur
{
    private int $identifiant;
    private string $nom;

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function getIdentifiant(): int
    {
        return $this->identifiant;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function SetIdentifiant(int $identifiant): void
    {
        $this->identifiant = $identifiant;
    }

    public function SetNom(string $nom): void
    {
        $this->nom = $nom;
    }
}