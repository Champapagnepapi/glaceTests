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


}
