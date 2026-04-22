<?php

declare(strict_types=1);

namespace App;

class ApplicationService
{
    private Caisse $caisse;
    private Stock $stock;
    private Client $client;

    private array $catalogue = [];

    public function __construct(string $nomClient)
    {
        $this->caisse = new Caisse();
        $this->stock = new Stock();
        $this->client = new Client($nomClient);

        $this->initialiserCatalogueEtStock();
    }

    private function initialiserCatalogueEtStock(): void
    {
        $this->ajouterAuCatalogue('Chocolat', 5, 3);
        $this->ajouterAuCatalogue('Vanille', 4, 3);
        $this->ajouterAuCatalogue('Fraise', 6, 2);
    }

    private function ajouterAuCatalogue(string $saveurNom, int $prixVente, int $stockInitial): void
    {
        $saveur = new Saveur($saveurNom);
        $glace = new Glace($saveurNom, $saveur);
        $glace->SetIdentifiant('G_' . $saveurNom);
        $glace->SetPrixVente($prixVente);

        $this->catalogue[$saveurNom] = $glace;
        $this->stock->ajouter($glace, $stockInitial);
    }


    public function passerCommande(array $saveurs): array
    {
        $this->verifierCommandePossible($saveurs);

        $commande = new Commande();
        foreach ($saveurs as $saveurNom) {
            $glace = $this->catalogue[$saveurNom];
            $commande->ajouterGlace($glace);
            $this->stock->retirer($glace, 1);
        }

        $this->client->ajouterCommande($commande);
        $this->caisse->encaisser($commande->getTotal());

        return $this->etatApplication('ok');
    }


    public function passerPlusieursCommandes(array $commandes): array
    {
        foreach ($commandes as $commande) {
            $this->passerCommande($commande);
        }

        return $this->etatApplication('ok');
    }


    private function verifierCommandePossible(array $saveurs): void
    {
        $compteParSaveur = [];

        foreach ($saveurs as $saveurNom) {
            if (!isset($this->catalogue[$saveurNom])) {
                throw new \InvalidArgumentException('Saveur inconnue: ' . $saveurNom);
            }

            if (!isset($compteParSaveur[$saveurNom])) {
                $compteParSaveur[$saveurNom] = 0;
            }
            $compteParSaveur[$saveurNom]++;
        }

        foreach ($compteParSaveur as $saveurNom => $quantiteDemandee) {
            $glace = $this->catalogue[$saveurNom];
            if ($this->stock->getQuantite($glace) < $quantiteDemandee) {
                throw new \InvalidArgumentException('Stock insuffisant pour cette glace.');
            }
        }
    }

    private function etatApplication(string $status): array
    {
        $stockEtat = [];
        foreach ($this->catalogue as $saveurNom => $glace) {
            $stockEtat[$saveurNom] = $this->stock->getQuantite($glace);
        }

        return [
            'status' => $status,
            'client' => $this->client->getNom(),
            'nombreCommandes' => $this->client->getNombreCommandes(),
            'totalClient' => $this->client->getTotalDepense(),
            'soldeCaisse' => $this->caisse->getSolde(),
            'stock' => $stockEtat,
        ];
    }
}