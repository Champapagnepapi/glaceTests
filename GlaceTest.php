<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GlaceTest extends TestCase
{
   public function testIdentifiant(): void
   {
        $glace1 = new Glace("Chocolat");
        $glace2 = new Glace("Vanille");

        $this->assertNotEquals($glace1->getIdentifiant(), $glace2->getIdentifiant());
        $this->assertIsString($glace1->getIdentifiant());
        $this->assertIsString($glace2->getIdentifiant());
   }

   public function fabricationValide() : void 
   {
     $glace = new Glace("Fraise");
     $glace->SetTempsFabrication(500);
     $this->assertGreaterThan(0, $glace->getTempsFabrication());
     $this->assertNotNull($glace->getTempsFabrication());
   }

   public function typeValide() : void 
   {
     $glace = new Glace("pistache");
     $glace->SetType("cornet");
     $this->assertContains($glace->getType(), ["cornet", "pot"]);
     $this->assertNotNull($glace->getType());
   }

   public function prixAchatValide() : void 
   {

    $glace = new Glace("mangue");
    $glace->SetPrixAchat(2);

    $this->assertIsInt($glace->getPrixAchat());
    $this->assertGreaterThan(0, $glace->getPrixAchat());
    $this->assertLessThan($glace->getPrixVente(), $glace->getPrixAchat());

   }

   public function prixVenteValide () : void 
   {
    
    $glace = new Glace("citron");
    $glace->SetPrixAchat(2);
    $glace->SetPrixVente(5);

    $this->assertGreaterThan(0, $glace->getPrixVente());
    $this->assertGreaterThan($glace->getPrixAchat(), $glace->getPrixVente());
    $this->assertIsInt($glace->getPrixVente());
    $this->assertNotNull($glace->getPrixVente());
   }

   public function datePeremptionValide() : void 
   {
    $glace = new Glace("framboise");
    $dateFuture = (new DateTime())->modify('+1 day');
    $glace->SetDatePeremption($dateFuture);

    $this->assertGreaterThan(new DateTime(), $glace->getDatePeremption());
    $this->assertNotNull($glace->getDatePeremption());

   }

   public function saveurValide() : void 
   {
    $saveur = new Saveur("menthe");
    $glace = new Glace("menthe");
    $glace->SetSaveur($saveur);


    $this->assertInstanceOf(Saveur::class, $glace->getSaveur());
    $this->assertNotNull($glace->getSaveur());
   }
}