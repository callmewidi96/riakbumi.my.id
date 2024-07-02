<?php 
    session_start();
    if((isset($_SESSION['role']))&&($_SESSION['role']=="adm")){
        header('location:admin/index.php?p=barang');
    }
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>CV Riak Bumi</title>
    <link rel="icon" type="image/x-icon" href="/icon/icon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 4.5rem;
            font-family: arial;
            background-color: #eeeeee;
        }

        .dropdown-menu > li > a:hover{
          background-image: none;
          background-color: #FB8B24;
          color: white;
        }
        .dropdown-menu > li > a{
            color: #9b9d9e;
            
        }
        .d-flex{
            margin:0px;
        }
        .bg{
            background:#36454F;
            color:white;
        }
        input{
            height:2.5em;
        }
        button{
            padding:0px;
            height:2.5em;
        }
        
        .oren{
          background:#FB8B24;
          color:white;
        }
        .oren:hover{
          background:#dd8028;
          color:white;
        }
    </style>

    <script src="js/bootstrap.bundle.min.js"></script>   
  </head>
  <body style="padding-bottom:0px;padding-top:4.5rem;">
    

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg">
   
   <div class="container-fluid">
      
       <a class="navbar-brand" href="./">CV Riak Bumi</a>
       
       <!--icon versi mobile-->
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
       
       <div class="collapse navbar-collapse" id="navbarCollapse">
           <ul class="navbar-nav me-auto mb-2 mb-md-0">
               <li class="nav-item">
                   <a class="nav-link" href="./">Home</a>
               </li>

               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori Produk</a>
               
                   <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                       <?php 
                            include('config/koneksi.php');

                            $sql = mysqli_query($conn, "SELECT * FROM penjualan");

                            date_default_timezone_set("Asia/Jakarta");
                            $tglsekarang=date_create("Now");
                            $tglsekarang=date_format($tglsekarang,"Y-m-d H:i:s");
                            
                            
                            while($isi = mysqli_fetch_array($sql)){
                                
                                if(($isi['tgl_hapus']<$tglsekarang)&&($isi['status']=="Belum bayar")){
                                    mysqli_query($conn, "UPDATE penjualan SET status = 'Kadaluarsa' WHERE kode_penjualan = '".$isi['kode_penjualan']."'"); 

                                    $sql2 = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE kode_penjualan = '$kode'");
                                    while($data = mysqli_fetch_array($sql2)){
                                        $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '".$data['kode_barang']."'"));
                                        $stok=$data2['stok']+$data['jumlah'];
                                        $jual=$data2['terjual']-$data['jumlah'];
                                        $sql3 = mysqli_query($conn, "UPDATE barang SET stok = '$stok', terjual= '$jual' WHERE kode_barang = '".$data['kode_barang']."'");
                                    }
                                }
                            }

                           $query1 = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                           while($data1 = mysqli_fetch_array($query1)){
                               echo "<li><a class='dropdown-item' href='index.php?kategori=".$data1['nama_kategori']."'>".$data1['nama_kategori']."</a></li>";
                           }
                       ?>
                       <li><a class="dropdown-item" href="index.php?kategori=Terlaris">Terlaris</a></li>
                       <li><hr class="dropdown-divider"></li>
                       <li><a class="dropdown-item" href="./">Semua Kategori</a></li>
                   </ul>
               </li>


               <?php if(isset($_SESSION['user'])){?>
                <li class="nav-item">
                    <a class="nav-link" href="keranjang.php">Keranjang Belanja 
                        <span class="badge rounded-pill oren" id="item-cart">
                            <?php
                                $username = $_SESSION['user'];
                                $keranjang=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM keranjang WHERE username='$username'"));
                                echo $keranjang;
                            ?>
                        </span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="histori.php">Histori</a>
                </li>
                <?php }?>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Tentang Toko</a>
                </li>
                
           </ul>
            <form class="d-flex" method="post" action="" autocomplete="off">
                <input class="form-control me-2" type="text" placeholder="Nama Barang" aria-label="Search" name="keyword">
                <button class="btn oren" style="margin:auto; margin-right:40px;" type="submit" name="cari">Search</button>
            </form>
            <ul class="navbar-nav">
            <?php if(isset($_SESSION['user'])){?>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
            <?php }else{?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php }?>
            </ul>
           

       </div>
       

   </div>
</nav>


