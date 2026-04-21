<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Saveur;

class SaveurTest extends TestCase
{
     public function testIdentifiant(): void
     {
                $saveur1 = new Saveur("Chocolat", true);
                $saveur2 = new Saveur("Vanille", true);
                $saveur1->SetIdentifiant("S1");
                $saveur2->SetIdentifiant("S2");

                $this->assertIsString($saveur1->getIdentifiant());
                $this->assertIsString($saveur2->getIdentifiant());
     }

     public function testNomValide() : void
     {
         $saveur = new Saveur("Fraise", true);
         $saveur->SetNom("Pistache");

         $this->assertIsString($saveur->getNom());
         $this->assertNotNull($saveur->getNom());
     }

     public function testDisponibiliteValide() : void
     {
         $saveur = new Saveur("Mangue", true);
         $saveur->SetDisponible(false);

         $this->assertIsBool($saveur->isDisponible());
         $this->assertFalse($saveur->isDisponible());
     }

     public function testNomVideInterdit(): void
     {
       
         $this->expectException(InvalidArgumentException::class);
         $this->expectExceptionMessage("Le nom de la saveur ne peut pas être vide.");

         new Saveur("");
     }

        public function testIdentifiantUnique(): void
        {
            $saveur1 = new Saveur("Citron", true);
            $saveur2 = new Saveur("Orange", true);
    
            $saveur1->SetIdentifiant("S3");
    
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage("L'identifiant S3 est déjà utilisé.");
    
            $saveur2->SetIdentifiant("S3");
        }

}
