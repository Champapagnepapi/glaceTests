<?php

declare(strict_types=1);

namespace App;

class Saveur
{
    private static array $identifiantsUtilises = [];

    private string $identifiant;
    private string $nom;
    private bool $disponible;

    public function __construct(string $nom, bool $disponible = true)
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom de la saveur ne peut pas être vide.");
        }

        $this->nom = $nom;
        $this->disponible = $disponible;
    }

    public static function resetIdentifiantsUtilises(): void
    {
        self::$identifiantsUtilises = [];
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

    public function setIdentifiant(string $identifiant): void
    {
        if (in_array($identifiant, self::$identifiantsUtilises)) {
            throw new \InvalidArgumentException("L'identifiant $identifiant est déjà utilisé.");
        }

        $this->identifiant = $identifiant;
        self::$identifiantsUtilises[] = $identifiant;
    }

    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom de la saveur ne peut pas être vide.");
        }

        $this->nom = $nom;
    }

    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }
}