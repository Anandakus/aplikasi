<?php
include 'db.php';

// Tambah data
if (isset($_POST['add'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    $sql = "INSERT INTO supplies (name, category, quantity, price) VALUES ('$name', '$category', $quantity, $price)";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php?msg=added');
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}

// Update data
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    $sql = "UPDATE supplies SET name='$name', category='$category', quantity=$quantity, price=$price WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php?msg=updated');
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM supplies WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php?msg=deleted');
    } else {
        echo "Error: " . $conn->error;
    }
    exit();
}
?>
