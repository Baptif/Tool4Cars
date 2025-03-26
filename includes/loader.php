<?php

$client = $_COOKIE['client'] ?? null;
$module = filter_input(INPUT_GET, 'module', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$script = filter_input(INPUT_GET, 'script', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$module || !$script) {
    exit('<div class="alert alert-danger">Erreur de sécurité.</div>');
}

// Client défini -> sinon erreur
if (!$client) {
    http_response_code(403);
    exit('<div class="alert alert-danger">Accès interdit.</div>');
}

// Liste blanche des modules et scripts autorisés
$allowedModules = ['cars', 'garages'];
$allowedScripts = ['ajax', 'edit'];
// Module demandé existant ? -> sinon erreur
if (!in_array($module, $allowedModules) || !in_array($script, $allowedScripts)) {
    http_response_code(404);
    exit('<div class="alert alert-warning">Module ou script introuvable.</div>');
}

// Fichiers JSON associés aux modules
$modulesData = [
    'cars' => __DIR__.'/../data/cars.json',
    'garages' => __DIR__.'/../data/garages.json'
];

// Chargement des données JSON du module
$dataArray = json_decode(file_get_contents($modulesData[$module]), true);

if (!$dataArray) {
    exit('<div class="alert alert-warning">Aucune donnée disponible.</div>');
}

// Filtrage des données en fonction du client et du module
function filterData($data, $client, $module) {
    if ($module === 'cars') {
        return array_filter($data, fn($car) => $car['customer'] === $client);
    } elseif ($module === 'garages' && $client === 'clientb') {
        return array_filter($data, fn($garage) => $garage['customer'] === $client);
    }
    return [];
}

$filteredData = filterData($dataArray, $client, $module);

// Chargement des garages si nécessaire
$garagesMap = [];
$garageName = '';
if ($module === 'cars' && $client === 'clientb') {
    $garages = json_decode(file_get_contents($modulesData['garages']), true);
    $garagesMap = array_column($garages, 'title', 'id');
}

// Inclusion du fichier correspondant au client et au module
$clientFilePath = __DIR__."/../customs/$client/modules/$module/$script.php";
if (file_exists($clientFilePath) && is_file($clientFilePath)) {
    include $clientFilePath;
} else {
    exit('<div class="alert alert-danger">Fichier introuvable.</div>');
}

?>