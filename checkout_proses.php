
<?php
    include('header.php');
    if(isset($_POST['checkout'])){
        date_default_timezone_set("Asia/Jakarta");
        $kode=substr(date_format(date_create("Now"), "ymdHisU"),0,13);
        $tanggal=date_format(date_create("Now"),"Y/m/d"); 
        
        $tglhapus=date_create("Now");

        date_add($tglhapus,date_interval_create_from_date_string("1 days"));
        
        $tglhapus=date_format($tglhapus,"Y/m/d H:i:s");

        $jasa=strtoupper($_POST['kurir']);
        $nohp=$_POST['nohp'];
        $alamat=$_POST['alamat']."<br>".$_POST['kota'].", ".$_POST['provinsi'];
        $ongkir=$_POST['ongkir'];
        $paket=$_POST['paket'];
        $total=$_POST['totalharga'];

        $query = mysqli_query($conn, "INSERT INTO penjualan(kode_penjualan, username, nohp_terima, alamat_terima, nama_jasa_antar, paket_pengantaran, total_harga_barang, harga_ongkir, tgl_pesan, tgl_hapus, status) VALUES('$kode','".$_SESSION['user']."','$nohp', '$alamat', '$jasa', '$paket', '$total', '$ongkir', '$tanggal', '$tglhapus', 'Belum bayar')");

        if($query){
            $query1 = mysqli_query($conn, "SELECT * FROM keranjang JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE username = '".$_SESSION['user']."' AND status = 1");
            while($data = mysqli_fetch_array($query1)){
                $query2 = mysqli_query($conn, "INSERT INTO penjualan_detail(kode_penjualan, kode_barang, jumlah) VALUES('$kode','".$data['kode_barang']."','".$data['jumlah']."')");
                $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='".$data['kode_barang']."'"));
                $stok=$data2['stok']-$data['jumlah'];
                $jual=$data2['terjual']+$data['jumlah'];
                $query3 = mysqli_query($conn, "UPDATE barang SET stok = $stok, terjual = $jual WHERE kode_barang = '".$data['kode_barang']."'");
                $query3 = mysqli_query($conn, "DELETE FROM keranjang WHERE username = '".$_SESSION['user']."' AND status = 1");
            }
        
            

            echo "<script>alert('Barang berhasil dipesan'); location.href='rincian.php?order_id=$kode'; </script>";
        }else{
            echo "<script>alert('Barang gagal dipesan')</script>";
        }
    }
?>