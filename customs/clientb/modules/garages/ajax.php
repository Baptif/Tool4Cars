<h2>Garages Client B</h2>
<table class="table table-striped garage-table">
    <thead>
        <tr>
            <th>Nom du garage</th>
            <th>Adresse</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filteredData as $garage): ?>
            <tr 
                role="button" 
                data-garage-id="<?= htmlspecialchars($garage['id'])?>"
            >
                <td><?= htmlspecialchars($garage['title']) ?></td>
                <td><?= htmlspecialchars($garage['address']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>