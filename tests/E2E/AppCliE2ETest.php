<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class AppCliE2ETest extends TestCase
{

    private function executerPointEntree(array $args): array
    {
        $cmdParts = [PHP_BINARY, __DIR__ . '/../../bin/app.php'];
        foreach ($args as $arg) {
            $cmdParts[] = $arg;
        }

        $escaped = array_map('escapeshellarg', $cmdParts);
        $commande = implode(' ', $escaped);

        $output = shell_exec($commande);
        $this->assertNotFalse($output);

        $json = json_decode(trim((string) $output), true);
        $this->assertIsArray($json);

        return $json;
    }

    public function testPasserCommandeValideDepuisCli(): void
    {
        $resultat = $this->executerPointEntree(['order', 'Alice', 'Chocolat,Vanille']);

        $this->assertSame('ok', $resultat['status']);
        $this->assertSame('Alice', $resultat['client']);
        $this->assertSame(1, $resultat['nombreCommandes']);
        $this->assertSame(9, $resultat['soldeCaisse']);
        $this->assertSame(2, $resultat['stock']['Chocolat']);
        $this->assertSame(2, $resultat['stock']['Vanille']);
    }

    public function testRefuserCommandeQuandStockInsuffisantDepuisCli(): void
    {
        $resultat = $this->executerPointEntree(['order', 'Bob', 'Chocolat,Chocolat,Chocolat,Chocolat']);

        $this->assertSame('error', $resultat['status']);
        $this->assertSame('Stock insuffisant pour cette glace.', $resultat['message']);
    }

    public function testEnchainerPlusieursCommandesDepuisCli(): void
    {
        $resultat = $this->executerPointEntree(['batch', 'Charlie', 'Chocolat|Vanille,Fraise']);

        $this->assertSame('ok', $resultat['status']);
        $this->assertSame(2, $resultat['nombreCommandes']);
        $this->assertSame(15, $resultat['soldeCaisse']);
        $this->assertSame(2, $resultat['stock']['Chocolat']);
        $this->assertSame(2, $resultat['stock']['Vanille']);
        $this->assertSame(1, $resultat['stock']['Fraise']);
    }
}