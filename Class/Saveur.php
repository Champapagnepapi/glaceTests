<?php

declare(strict_types=1);

namespace App;

class Saveur
{
    private string $identifiant;
    private string $nom;
    private bool $disponible;

    public function __construct(string $nom, bool $disponible)
    {
        $this->nom = $nom;
        $this->disponible = $disponible;
    }

    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function SetIdentifiant(string $identifiant): void
    {
        $this->identifiant = $identifiant;
    }

    public function SetNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function SetDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }
}