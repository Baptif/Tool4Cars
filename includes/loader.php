<?php

$client = $_COOKIE['client'] ?? null;
$module = $_GET['module'] ?? null;
$script = $_GET['script'] ?? null;

// Client défini -> sinon erreur
if (!$client) {
    http_response_code(403);
    exit('<div class="alert alert-danger">Accès interdit.</div>');
}

// Fichiers JSON associés aux modules
$modulesData = [
    'cars' => __DIR__.'/../data/cars.json',
    'garages' => __DIR__.'/../data/garages.json'
];

// Module demandé existant ? -> sinon erreur
if (!array_key_exists($module, $modulesData)) {
    http_response_code(404);
    exit('<div class="alert alert-warning">Module introuvable.</div>');
}

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
if (file_exists($clientFilePath)) {
    include $clientFilePath;
} else {
    exit('<div class="alert alert-danger">Fichier introuvable.</div>');
}

?>