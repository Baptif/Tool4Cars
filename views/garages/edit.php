<?php
// Vérification qu'un ID est envoyé
$garageID = $_POST['garage-id'] ?? null;

if (!$garageID) {
    echo '<div class="alert alert-danger">Garage non défini !</div>';
    exit;
}

// Chargement et décodage du fichier JSON
$garages = json_decode(file_get_contents(__DIR__ . '/../../data/garages.json'), true);

// Trouve le garage correspondant à l'ID et stock les données dans un array
$garageData = array_filter($garages, fn($garage) => $garage['id'] === (int)$garageID);
$garageData = reset($garageData);

if (!$garageData) {
    echo '<div class="alert alert-warning">Aucun garage trouvé pour cet ID !</div>';
    exit;
}

?>

<!-- Partie HTML pour la fiche du garage -->
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Fiche du garage</h4>
    </div>
    <div class="card-body pt-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Identifiant du garage:</strong> <?= htmlspecialchars($garageData['id']) ?></li>
            <li class="list-group-item"><strong>Nom du garage:</strong> <?= htmlspecialchars($garageData['title']) ?></li>
            <li class="list-group-item"><strong>Adresse:</strong> <?= htmlspecialchars($garageData['address']) ?></li>
        </ul>
    </div>
</div>

<button id="back-button" type="button" class="btn btn-link">Retour</button>