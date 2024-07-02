<?php 
    session_start();
    $kode = $_SESSION['user'];
    include('config/koneksi.php');

    if(isset($_GET['id'])){
        $produk = $_GET['id'];

        if(! isset($_GET['tipe'])){
            $querya = mysqli_query($conn, "SELECT * FROM keranjang JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE username = '".$_SESSION['user']."'");
            $dataa = mysqli_fetch_array($querya);
            $harga = $dataa['harga'];

            $queryb = mysqli_query($conn, "SELECT * FROM keranjang WHERE username = '$kode' AND kode_barang = '$produk'");
            $datab = mysqli_fetch_array($queryb);
            if(isset($datab['jumlah'])){
                $subtotal = $harga * ($datab['jumlah'] + 1);
                $query3 = mysqli_query($conn, "UPDATE keranjang SET jumlah=jumlah+1, subtotal='$subtotal' WHERE username = '$kode' AND kode_barang = '$produk'");
            }else{
                $query3 = mysqli_query($conn, "INSERT INTO keranjang(kode_sesi,kode_produk,jumlah,harga,subtotal) ".
                        "VALUES('$kode','$produk','1','$harga','$harga')");
            }

            if($query3){
                echo "1";
            }else{
                echo "0";
            }
        } else {
            switch($_GET['tipe']){
                case 'hapus':
                    $query = mysqli_query($conn, "DELETE FROM keranjang WHERE kode_keranjang = '$produk'");
                    if($query){
                        echo "1";
                    }else{
                        echo "0";
                    }
                    break;
                case 'kurang':
                    $querya = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_keranjang = '$produk'");
                    $dataa = mysqli_fetch_array($querya);

                    $harga = $dataa['harga'];
                    $jumlah = $dataa['jumlah'];

                    if($jumlah > 1){
                        $jumlah--;
                        $subtotal = $harga * $jumlah;
                        $queryb = mysqli_query($conn, "UPDATE keranjang SET jumlah='$jumlah' WHERE kode_keranjang = '$produk'");

                        if($queryb){
                            echo "1";
                        }else{
                            echo "0";
                        }
                    }
                    break;
                case 'tambah':
                    $querya = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_keranjang = '$produk'");
                    $dataa = mysqli_fetch_array($querya);

                    $harga = $dataa['harga'];
                    $jumlah = $dataa['jumlah'];

                    $jumlah++;
                    $subtotal = $harga * $jumlah;
                    $queryb = mysqli_query($conn, "UPDATE keranjang SET jumlah='$jumlah', subtotal='$subtotal' WHERE kode_keranjang = '$produk'");

                    if($queryb){
                        echo "1";
                    }else{
                        echo "0";
                    }
                    break;
            }
        }
    }else{
        $query = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM keranjang WHERE username = '$kode'");
        $data = mysqli_fetch_array($query);

        echo $data['jumlah'];
    }
?>