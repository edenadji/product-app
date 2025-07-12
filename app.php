<?php

session_start();

// jika belum ada data
if (!isset($_SESSION['product'])) {
    $_SESSION['product'] = [
        ['name' => 'Laptop', 'cost' => 8500000, 'stock' => 3],
        ['name' => 'Mouse', 'cost' => 150000, 'stock' => 10],
    ];
}

// fungsi tambah product
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $stock = $_POST['stock'];

    $_SESSION['product'][] = [
        'name' => $name,
        'cost' => $cost,
        'stock' => $stock,
    ];

    header('location: app.php');
    exit;
}


// fungsi edit product
if (isset($_POST['update'])) {

    $index = $_POST['index'];

    if (!isset($_SESSION['product'][$index])) {
        // Index tidak valid, redirect balik
        header("location: app.php");
        exit;
    }

    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $stock = $_POST['stock'];

    $_SESSION['product'][$index]['name'] = $name;
    $_SESSION['product'][$index]['cost'] = $cost;
    $_SESSION['product'][$index]['stock'] = $stock;

    header('location: app.php');
    exit;
}


// fungsi hapus product
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['product'][$index]);

    // reindex array biar rapi
    $_SESSION['product'] = array_values($_SESSION['product']);
    header("location: app.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product App</title>
</head>

<body>
    <h2><?= isset($_GET['edit']) ? "Edit Product" : "Tambah Product" ?></h2>
    <form action="" method="POST">
        <?php
        if (isset($_GET['edit'])):
            $index = $_GET['edit'];

            $data = $_SESSION['product'][$index];
        ?>
            <input type="hidden" name="index" value="<?= $index ?>">
            NAMA : <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required><br>
            HARGA : <input type="number" name="cost" value="<?= $data['cost'] ?>" required><br>
            STOCK : <input type="number" name="stock" value="<?= $data['stock'] ?>" required><br><br>
            <button type="submit" name="update">Simpan Perubahan</button> <br> <br> <br>
        <?php else: ?>
            NAMA : <input type="text" name="name" required><br>
            HARGA : <input type="number" name="cost" required><br>
            STOCK : <input type="number" name="stock" required><br><br>
            <button type="submit" name="add">TAMBAH</button> <br> <br> <br>
        <?php endif; ?>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php if (count($_SESSION['product']) > 0): ?>
            <tbody>
                <?php foreach ($_SESSION['product'] as $i => $product): ?>
                    <tr>
                        <td><?= $i + 1; ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= $product['cost']; ?></td>
                        <td><?= $product['stock']; ?></td>
                        <td>
                            <a href="?edit=<?= $i; ?>">EDIT</a> |
                            <a href="?delete=<?= $i; ?>" onclick="return confirm('yakin hapus?')">HAPUS</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
</body>

</html>