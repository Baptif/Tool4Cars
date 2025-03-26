<h2>Voitures Client B</h2>
<table class="table table-striped car-table">
    <thead>
        <tr>
            <th>Nom de la voiture</th>
            <th>Marque</th>
            <th>Nom du garage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredData as $car): ?>
            <tr 
                role="button" 
                data-car-id="<?= htmlspecialchars($car['id'])?>"
            >
                <td><?= strtolower(htmlspecialchars($car['modelName'])) ?></td>
                <td><?= htmlspecialchars($car['brand']) ?></td>
                <td><?= htmlspecialchars($garagesMap[$car['garageId']] ?? 'Inconnu') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
