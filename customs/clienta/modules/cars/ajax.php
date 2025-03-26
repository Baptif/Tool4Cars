<h2>Voitures Client A</h2>
<table class="table table-striped car-table">
    <thead>
        <tr>
            <th>Nom de la voiture</th>
            <th>Marque</th>
            <th>Année</th>
            <th>Puissance</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredData as $car): 
            // Changement couleur de fond en fonction de l'année
            $rowColor = match (true) {
                (int)date('Y', $car['year']) >= date('Y') - 2 => "#00C247", // vert
                (int)date('Y', $car['year']) <= date('Y') - 10 => "#E60026", // rouge
                default => "",
            };
        ?>
            <tr 
                role="button" 
                data-car-id="<?= htmlspecialchars($car['id'])?>"
                style="background-color: <?= $rowColor ?>;"
            >
                <td><?= htmlspecialchars($car['modelName']) ?></td>
                <td><?= htmlspecialchars($car['brand']) ?></td>
                <td><?= date('Y', $car['year']) ?></td>
                <td><?= htmlspecialchars($car['power']) ?> CV</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>