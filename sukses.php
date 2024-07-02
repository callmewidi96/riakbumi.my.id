<?php 
    include('config/koneksi.php');

    session_start();
    $kode=$_SESSION['kode'];
    unset($_SESSION['kode']);
    session_destroy();

    $query = mysqli_query($conn, "UPDATE penjualan SET status = 'Dikemas' WHERE kode_penjualan = '$kode'");
    header('location:histori.php');

?>
