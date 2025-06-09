<?php
include 'db.php';

// Cek mode edit
$edit_mode = false;
if (isset($_GET['edit'])) {
    $id_edit = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM supplies WHERE id = $id_edit");
    if ($result->num_rows > 0) {
        $row_edit = $result->fetch_assoc();
        $edit_mode = true;
    }
}

// Ambil data semua supplies
$data = $conn->query("SELECT * FROM supplies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Art Supply Inventory</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <h1>Art Supply Inventory</h1>

        <!-- Form tambah / edit -->
        <div class="form-container">
            <h2><?= $edit_mode ? "Edit Data" : "Tambah Data Baru" ?></h2>
            <form action="process.php" method="post" id="supplyForm">
                <input type="hidden" name="id" value="<?= $edit_mode ? $row_edit['id'] : '' ?>" />
                
                <label for="name">Nama Barang</label>
                <input type="text" id="name" name="name" required value="<?= $edit_mode ? htmlspecialchars($row_edit['name']) : '' ?>" />

                <label for="category">Kategori</label>
                <input type="text" id="category" name="category" required value="<?= $edit_mode ? htmlspecialchars($row_edit['category']) : '' ?>" />

                <label for="quantity">Jumlah</label>
                <input type="number" id="quantity" name="quantity" min="0" required value="<?= $edit_mode ? $row_edit['quantity'] : '' ?>" />

                <label for="price">Harga (Rp)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required value="<?= $edit_mode ? $row_edit['price'] : '' ?>" />

                <button type="submit" name="<?= $edit_mode ? 'update' : 'add' ?>">
                    <?= $edit_mode ? 'Update Data' : 'Tambah Data' ?>
                </button>
                <?php if ($edit_mode): ?>
                    <a href="index.php" class="cancel-btn">Batal</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tabel daftar supplies -->
        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Harga (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data->num_rows > 0): ?>
                    <?php while($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= number_format($row['price'], 2, ',', '.') ?></td>
                            <td>
                                <a href="index.php?edit=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                <a href="process.php?delete=<?= $row['id'] ?>" class="delete-btn">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">Data kosong.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript untuk validasi form dan konfirmasi hapus -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi hapus data
        const deleteLinks = document.querySelectorAll('.delete-btn');
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });

        // Validasi form tambah/edit
        const form = document.getElementById('supplyForm');
        form.addEventListener('submit', function(e) {
            const name = form.name.value.trim();
            const category = form.category.value.trim();
            const quantity = form.quantity.value.trim();
            const price = form.price.value.trim();

            if (!name || !category || !quantity || !price) {
                alert('Semua field harus diisi!');
                e.preventDefault();
                return;
            }
            if (quantity < 0) {
                alert('Jumlah tidak boleh kurang dari 0!');
                e.preventDefault();
                return;
            }
            if (price < 0) {
                alert('Harga tidak boleh kurang dari 0!');
                e.preventDefault();
            }
        });
    });
    </script>
</body>
</html>
