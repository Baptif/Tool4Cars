<h2>Voitures Client C</h2>
<table class="table table-striped car-table">
    <thead>
        <tr>
            <th>Nom de la voiture</th>
            <th>Marque</th>
            <th>Couleur</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredData as $car): ?>
            <tr 
                role="button" 
                data-car-id="<?= htmlspecialchars($car['id'])?>"
            >
                <td><?= htmlspecialchars($car['modelName']) ?></td>
                <td><?= htmlspecialchars($car['brand']) ?></td>
                <td style='background-color: <?= htmlspecialchars($car['colorHex']) ?>;'></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>