<?php if (!empty($data)): ?>
<table class="demo">
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
<style>
table.demo {
    background: #444;
    color: #fff;
    text-align: center;
}
table.demo thead {
    background: #333;
    font-weight: bold;
}
table.demo th,
table.demo td {
    border: 1px solid #fff;
    margin: 0;
    padding: 10px;
}
</style>
<?php else: ?>
<p>No data included!</p>
<?php endif; ?>