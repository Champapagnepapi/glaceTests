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

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->prixVente = 10;
        $this->identifiant = uniqid('glace_', true);
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
        $this->tempsFabrication = $tempsFabrication;
    }

    public function SetPrixAchat(int $prixAchat): void
    {
        $this->prixAchat = $prixAchat;
    }

    public function SetPrixVente(int $prixVente): void
    {
        $this->prixVente = $prixVente;
    }

    public function SetType(string $type): void
    {
        $this->type = $type;
    }

    public function SetDatePeremption(DateTime $datePeremption): void
    {
        $this->datePeremption = $datePeremption;
    }

    public function SetSaveur(Saveur $saveur): void
    {
        $this->saveur = $saveur;
    }


}