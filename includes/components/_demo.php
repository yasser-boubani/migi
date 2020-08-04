<?php if (!empty($data)): ?>
<table border>
    <thead>
        <th>Item</th>
        <th>Price</th>
    </thead>
    <tbody>
        <?php foreach ($data as $item => $price): ?>
        <tr>
            <td><?= $item ?></td>
            <td><?= $price ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No data included!</p>
<?php endif; ?>