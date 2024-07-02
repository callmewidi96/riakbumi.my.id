
<?php
    include('header.php');
    if(isset($_POST['checkout'])){
        $n=$_POST['barang'];
        for($i=0;$i<$n;$i++){
            $keranjang=$_POST['kode'.$i];
            if($keranjang!=""){
                $query = mysqli_query($conn, "UPDATE keranjang SET jumlah = '".$_POST['jumlah'.$i]."', status = 1 WHERE kode_keranjang = '$keranjang'");
                $data1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_keranjang = '$keranjang'"));
                $data2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '".$data1['kode_barang']."'"));

                if($data2['stok']<$data1['jumlah']){
                    echo "<script>alert('Stok ".$data2['nama_barang']." hanya tersisa ".$data2['stok']."'); </script>";
                    $query = mysqli_query($conn, "UPDATE keranjang SET jumlah = '".$data2['stok']."', status = 0 WHERE kode_keranjang = '$keranjang'");
                    echo "<script>location.href='keranjang.php'; </script>";
                }else{
                    echo "<script>location.href='checkout.php'; </script>";
                }
            }
        }
    }
?>