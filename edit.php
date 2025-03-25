<?php

$carID = $_POST['carID'] ?? null;

if ($carID) {
    $carsJson = file_get_contents('data/cars.json');
    $cars = json_decode($carsJson, true);

    $garagesJson = file_get_contents('data/garages.json');
    $garages = json_decode($garagesJson, true);

    $carData = array_filter($cars, function($car) use ($carID) {
        return $car['id'] === (int)$carID;
    });
     // Récupère le premier élément du tableau
    $carData = reset($carData);

    // Créer un tableau associatif des garages
    $garagesMap = [];
    foreach ($garages as $garage) {
        $garagesMap[$garage['id']] = $garage['title'];
    }

    echo '<div class="card">';
    echo '<div class="card-header"><h4>Fiche de la voiture</h4></div>';
    echo '<div class="card-body pt-2">';
    echo '<ul class="list-group list-group-flush">';
    echo '<li class="list-group-item"><strong>Nom de la voiture:</strong> ' . $carData['modelName'] . '</li>';
    echo '<li class="list-group-item"><strong>Marque:</strong> ' . $carData['brand'] . '</li>';
    echo '<li class="list-group-item"><strong>Année:</strong> ' . date('Y', $carData['year']) . '</li>';
    echo '<li class="list-group-item"><strong>Puissance:</strong> ' . $carData['power'] . 'CV</li>';
    echo '<li class="list-group-item"><strong>Garage:</strong> ' . $garagesMap[$carData['garageId']] . '</li>';
    echo '<li class="list-group-item"><strong>Couleur:</strong> <div style="width: 50px; height: 50px; background-color: ' . $carData['colorHex'] . ';"></div></li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    echo '<button id="back-button" type="button" class="btn btn-link">Retour</button>';

} else {
    echo '<div class="alert alert-danger">Voiture non définie !</div>';
}

?>