<?php
// Récupérer le client à partir du cookie
$client = $_COOKIE['client'] ?? null;

if ($client) {
    $carsJson = file_get_contents('data/cars.json');
    $cars = json_decode($carsJson, true);

    $garagesJson = file_get_contents('data/garages.json');
    $garages = json_decode($garagesJson, true);

    // Filtrer les voitures en fonction du client
    $filteredCars = array_filter($cars, function($car) use ($client) {
        return $car['customer'] === $client;
    });

    // Créer un tableau associatif des garages
    $garagesMap = [];
    foreach ($garages as $garage) {
        $garagesMap[$garage['id']] = $garage['title'];
    }

    echo '<table class="table table-striped">';
    echo '<thead><tr>';

    $headers = [
        'clienta' => ['Nom de la voiture', 'Marque', 'Année', 'Puissance'],
        'clientb' => ['Nom de la voiture', 'Marque', 'Nom du garage'],
        'clientc' => ['Nom de la voiture', 'Marque', 'Couleur']
    ];

    foreach ($headers[$client] as $header) {
        echo "<th>{$header}</th>";
    }

    echo '</tr></thead><tbody>';

    foreach ($filteredCars as $car) {
        echo '<tr>';
        switch ($client) {
            case 'clienta':
                $year = date('Y', $car['year']);
                echo "<td>{$car['modelName']}</td><td>{$car['brand']}</td><td>{$year}</td><td>{$car['power']}CV</td>";
                break;
            case 'clientb':
                $garageName = $garagesMap[$car['garageId']] ?? 'Garage inconnu';
                echo "<td>" . strtolower($car['modelName']) . "</td><td>{$car['brand']}</td><td>{$garageName}</td>";
                break;
            case 'clientc':
                echo "<td>{$car['modelName']}</td><td>{$car['brand']}</td><td style='background-color: {$car['colorHex']};'></td>";
                break;
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo 'Client non défini.';
}
?>