<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Glace;
use App\Saveur;

class GlaceTest extends TestCase
{
   public function testIdentifiant(): void
   {
        $saveur = new Saveur("Chocolat");
        $glace1 = new Glace("Chocolat", $saveur);
        $glace2 = new Glace("Vanille", $saveur);

        $this->assertIsString($glace1->getIdentifiant());
        $this->assertIsString($glace2->getIdentifiant());
   }

   public function testFabricationValide() : void 
   {
     $saveur = new Saveur("Fraise");
     $glace = new Glace("Fraise", $saveur);
     $glace->SetTempsFabrication(500);
     $this->assertGreaterThan(0, $glace->getTempsFabrication());
     $this->assertNotNull($glace->getTempsFabrication());
   }

   public function testTypeValide() : void 
   {
     $saveur = new Saveur("Pistache");
     $glace = new Glace("Pistache", $saveur);
     $glace->SetType("cornet");
     $this->assertContains($glace->getType(), ["cornet", "pot"]);
     $this->assertNotNull($glace->getType());
   }

   public function testPrixAchatValide() : void 
   {
     $saveur = new Saveur("Mangue");
     $glace = new Glace("Mangue", $saveur);
     $glace->SetPrixAchat(2);

     $this->assertIsInt($glace->getPrixAchat());
     $this->assertGreaterThan(0, $glace->getPrixAchat());
     $this->assertLessThan($glace->getPrixVente(), $glace->getPrixAchat());
   }

   public function testPrixVenteValide () : void 
   {
     $saveur = new Saveur("Citron");
     $glace = new Glace("Citron", $saveur);
     $glace->SetPrixAchat(2);
     $glace->SetPrixVente(5);

     $this->assertGreaterThan(0, $glace->getPrixVente());
     $this->assertGreaterThan($glace->getPrixAchat(), $glace->getPrixVente());
     $this->assertIsInt($glace->getPrixVente());
     $this->assertNotNull($glace->getPrixVente());
   }

   public function testDatePeremptionValide() : void 
   {
     $saveur = new Saveur("Framboise");
     $glace = new Glace("Framboise", $saveur);
     $dateFuture = (new DateTime())->modify('+1 day');
     $glace->SetDatePeremption($dateFuture);

     $this->assertGreaterThan(new DateTime(), $glace->getDatePeremption());
     $this->assertNotNull($glace->getDatePeremption());
   }

   public function testSaveurValide() : void 
   {
     $saveur = new Saveur("Menthe");
     $glace = new Glace("Menthe", $saveur);
     $glace->SetSaveur($saveur);

     $this->assertInstanceOf(Saveur::class, $glace->getSaveur());
     $this->assertNotNull($glace->getSaveur());
   }
}