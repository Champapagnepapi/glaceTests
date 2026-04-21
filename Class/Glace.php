<?php

declare(strict_types=1);

namespace App;

use DateTime;

class Glace
{
    private string $identifiant;
    private int $tempsFabrication;
    private int $prixAchat;
    private int $prixVente;
    private string $type;
    private DateTime $datePeremption;
    private Saveur $saveur;

    public function __construct(
        string $type, 
        Saveur $saveur,
        int $prixVente = 10,
        string $identifiant = "", 
        ?DateTime $datePeremption = null,
        int $tempsFabrication = 0, 
        int $prixAchat = 0
    ) {
        $this->type = $type;
        $this->saveur = $saveur;
        $this->prixVente = $prixVente;
        $this->identifiant = $identifiant;
        $this->datePeremption = $datePeremption ?? new DateTime('+1 year');
        $this->tempsFabrication = $tempsFabrication;
        $this->prixAchat = $prixAchat;
    }

    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }

    public function getTempsFabrication(): int
    {
        return $this->tempsFabrication;
    }

    public function getPrixAchat(): int
    {
        return $this->prixAchat;
    }

    public function getPrixVente(): int
    {
        return $this->prixVente;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDatePeremption(): DateTime
    {
        return $this->datePeremption;
    }

    public function getSaveur(): Saveur
    {
        return $this->saveur;
    }

    public function SetIdentifiant(string $identifiant): void
    {
        $this->identifiant = $identifiant;
    }

    public function SetTempsFabrication(int $tempsFabrication): void
    {
        if($tempsFabrication <= 0) {
            throw new \InvalidArgumentException("Le temps de fabrication doit être supérieur à zéro.");
        }
        $this->tempsFabrication = $tempsFabrication;
    }

    public function SetPrixAchat(int $prixAchat): void
    {
        if($prixAchat <= 0) {
            throw new \InvalidArgumentException("Le prix d'achat doit être supérieur à zéro.");
        }
        $this->prixAchat = $prixAchat;
    }

    public function SetPrixVente(int $prixVente): void
    {
        if($prixVente <= 0) {
            throw new \InvalidArgumentException("Le prix de vente doit être supérieur à zéro.");
        }
        $this->prixVente = $prixVente;
    }

    public function SetType(string $type): void
    {
        if(!in_array($type, ["cornet", "pot"])) {
            throw new \InvalidArgumentException("Le type doit être 'cornet' ou 'pot'.");
        }
        $this->type = $type;
    }

    public function SetDatePeremption(DateTime $datePeremption): void
    {
        if($datePeremption <= new DateTime()) {
            throw new \InvalidArgumentException("La date de péremption doit être dans le futur.");
        }
        $this->datePeremption = $datePeremption;
    }

    public function SetSaveur(Saveur $saveur): void
    {
        $this->saveur = $saveur;
    }


}