<?php
include '../tools/connection.php';

if (isset($_POST['save'])) {
    $kriKode = $_POST['kriKode'];
    $kriNama = $_POST['kriNama'];
    $kriBobot = $_POST['kriBobot'];

    $query = $conn->query("INSERT INTO ta_kriteria(kriteria_kode,kriteria_nama,kriteria_bobot)VALUES('$kriKode','$kriNama','$kriBobot')");
    if ($query == True) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                window.location='kriteriaView.php'
                </script>";
    } else {
        die('MySQL error : ' . mysqli_errno($conn));
    }
}
