
<?php
    include('header.php');
    if(isset($_POST['kirim'])){
        $rating=$_POST['rating'];
        $ulasan=$_POST['ulasan'];
        $kodebarang=$_POST['kodebarang'];

        $query = mysqli_query($conn, "INSERT INTO ulasan(kode_barang, username, ulasan, rating) VALUES('$kodebarang','".$_SESSION['user']."','$ulasan', '$rating')");

        if($query){
            echo "<script>alert('Terima kasih atas ulasannya!'); history.back(); </script>";
        }else{
            echo "<script>alert('Ulasan gagal dikirim')</script>";
        }
    }
?>