<?php

declare(strict_types=1);

namespace App;

class Saveur
{
    private string $identifiant;
    private string $nom;

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function SetIdentifiant(string $identifiant): void
    {
        $this->identifiant = $identifiant;
    }

    public function SetNom(string $nom): void
    {
        $this->nom = $nom;
    }
}