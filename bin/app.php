<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\ApplicationService;

function parseCsvSaveurs(string $input): array
{
    $elements = array_filter(array_map('trim', explode(',', $input)));
    return array_values($elements);
}

try {
    $args = $_SERVER['argv'] ?? [];

    if (count($args) < 4) {
        throw new InvalidArgumentException('Usage: php bin/app.php <order|batch> <client> <payload>');
    }

    $mode = $args[1];
    $client = $args[2];
    $payload = $args[3];

    $application = new ApplicationService($client);

    if ($mode === 'order') {
        $resultat = $application->passerCommande(parseCsvSaveurs($payload));
        echo json_encode($resultat, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit(0);
    }

    if ($mode === 'batch') {
        $commandesBrutes = array_filter(array_map('trim', explode('|', $payload)));
        $commandes = [];
        foreach ($commandesBrutes as $commandeBrute) {
            $commandes[] = parseCsvSaveurs($commandeBrute);
        }

        $resultat = $application->passerPlusieursCommandes($commandes);
        echo json_encode($resultat, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit(0);
    }

    throw new InvalidArgumentException('Mode inconnu: ' . $mode);
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit(1);
}