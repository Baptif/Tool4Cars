<?php
// Vérification qu'un ID est envoyé
$carID = filter_input(INPUT_POST, 'car-id', FILTER_VALIDATE_INT);

if (!$carID) {
    exit('<div class="alert alert-danger">Voiture non identifiée.</div>');
}

// Chargement et décodage des fichiers JSON
$cars = json_decode(file_get_contents(__DIR__ . '/../../data/cars.json'), true);
$garages = json_decode(file_get_contents(__DIR__ . '/../../data/garages.json'), true);

// Trouve la voiture correspondant à l'ID et stock les données dans un array
$carData = array_filter($cars, fn($car) => $car['id'] === (int)$carID);
$carData = reset($carData);

if (!$carData) {
    echo '<div class="alert alert-warning">Aucune voiture trouvée pour cet ID !</div>';
    exit;
}

// Création d'un tableau associatif des garages
$garagesMap = array_column($garages, 'title', 'id');
$garageName = $garagesMap[$carData['garageId']] ?? 'Inconnu';
?>

<!-- Partie HTML pour la fiche de la voiture -->
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Fiche de la voiture</h4>
    </div>
    <div class="card-body pt-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Nom de la voiture:</strong> <?= htmlspecialchars($carData['modelName']) ?></li>
            <li class="list-group-item"><strong>Marque:</strong> <?= htmlspecialchars($carData['brand']) ?></li>
            <li class="list-group-item"><strong>Année:</strong> <?= date('Y', $carData['year']) ?></li>
            <li class="list-group-item"><strong>Puissance:</strong> <?= htmlspecialchars($carData['power']) ?> CV</li>
            <li class="list-group-item"><strong>Garage:</strong> <?= htmlspecialchars($garageName) ?></li>
            <li class="list-group-item">
                <strong>Couleur:</strong>
                <div style="width: 50px; height: 50px; background-color: <?= htmlspecialchars($carData['colorHex']) ?>;"></div>
            </li>
        </ul>
    </div>
</div>

<button id="back-button" type="button" class="btn btn-link">Retour</button>