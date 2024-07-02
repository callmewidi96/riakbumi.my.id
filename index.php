        <?php include('header.php'); ?>

        <style>
        .card-img-top{
            object-fit:scale-down;
            object-position: center;
            width:100%;
            height:200px;
            max-height:200px;
            padding:4px;
            margin-top:10px;
            margin-bottom:5px;
            border:1px solid #D2D2D2;
        }
        .img-thumbnail{
            object-fit:scale-down;
            object-position: center;
            width:100%;
            height:200px;
            max-height:200px;
            padding:4px;
            margin-top:10px;
            margin-bottom:5px;
            border:1px solid #D2D2D2;
        }
        .card-body:hover{
            background: #f1f1f1;
            cursor: default;
        }
        </style>

        <main class="container-fluid">
        <div class="row justify-content-center">
            <?php 
                if(isset($_POST['cari'])){
                    if(isset($_GET['kategori'])){
                        echo "<script> location.href='index.php?kategori=".$_GET['kategori']."&cari=".$_POST['keyword']."';</script>";
                    }else{
                        echo "<script> location.href='index.php?cari=".$_POST['keyword']."';</script>";
                    }
                } 
            ?>
            <?php
                $sql = "SELECT * FROM barang";
                $urutan="nama_barang ASC";
                if((isset($_GET['cari']))&&(isset($_GET['kategori']))){
                    if($_GET['kategori']=="Terlaris"){
                        $sql .=" WHERE terjual > 0 AND nama_barang LIKE '".$_GET['cari']."%'";
                        $urutan="terjual DESC";
                    }else{
                        $sql .=" WHERE kategori = '".$_GET['kategori']."' AND nama_barang LIKE '".$_GET['cari']."%'";
                    }
                }else  if(isset($_GET['kategori'])){
                    if($_GET['kategori']=="Terlaris"){
                        $sql .=" WHERE terjual > 0";
                        $urutan="terjual DESC";
                    }else{
                        $sql .=" WHERE kategori = '".$_GET['kategori']."'";
                    }
                }else if(isset($_GET['cari'])){
                    $sql .=" WHERE nama_barang LIKE '".$_GET['cari']."%'";
                }
                $query2 = mysqli_query($conn, $sql." ORDER BY $urutan");
                
                while($data2 = mysqli_fetch_array($query2)){
                    $bintang=0;
                    $query3 = mysqli_query($conn, "SELECT * FROM ulasan WHERE kode_barang = '".$data2['kode_barang']."' ORDER BY no DESC");
                    $baris=mysqli_num_rows($query3);   
                    while($data3 = mysqli_fetch_array($query3)){$bintang+=$data3['rating'];}  
                    if($baris!=0){
                        $rating=$bintang/$baris;
                    }else{
                        $rating=0;
                    }             
            ?>
                <div class="card m-3 p-0 align-self-md-center" style="width:14rem;">
                    <div class="card-body mb-0" onclick="modalTambah(<?php echo $data2['kode_barang']; ?>)">
                        <img class="card-img-top" src="admin/gambar/<?php echo $data2['gambar'];?>">
                        <b><?php echo $data2['nama_barang'];?></b>
                        <p class="card-text mb-0"><font size="2"><?php echo "Rp ".number_format($data2['harga'],2,',','.'); ?> | <font color="#888888">Terjual: <?php echo $data2['terjual']; ?>
                        <?php
                            if($rating<0.5){echo "<p><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<1){echo "<p><img src='icon/star-half.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<1.5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<2){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-half.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<2.5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<3){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-half.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<3.5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<4){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-half.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<4.5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";}
                            else if($rating<5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-half.svg' width='10px' height='10px'>";}
                            else if($rating==5){echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'>";}                                        
                        ?>
                            <?php echo round($rating, 1);?></p>
                        </font></font></p>
                    </div>
                    <div class="card-footer">
                        <?php if($data2['stok']<1){?>
                        <button type="button" class="btn btn-secondary w-100">
                            Stok Habis
                        </button>
                        <?php }else{?>
                        <button type="button" class="oren text-white btn-block w-100" style="border:1px solid #FB8B24; border-radius:10px;" onclick="modalTambah(<?php echo $data2['kode_barang']; ?>)">
                            Tambah
                        </button>
                        <?php }?>
                        <button type="button" class="btn btn-danger mt-1 text-white btn-block w-100" style="border-radius:10px;" onclick="modalUlasan(<?php echo $data2['kode_barang']; ?>)">
                            Ulasan
                        </button>

                        <div class="modal fade" id="modalTambah<?php echo $data2['kode_barang']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><b><?php echo $data2['nama_barang']; ?></b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST" autocomplete="off">
                                        <div class="modal-body">
                                            <img class="img-thumbnail" src="admin\gambar\<?php echo $data2['gambar']; ?>"><br><hr>
                                            <input type="hidden" name="kode" value="<?php echo $data2['kode_barang']; ?>">
                                            <p class="card-text">
                                                <font size="2"><?php echo "Rp ".number_format($data2['harga'],2,',','.'); ?> <br>
                                                    <font color="#888888">Terjual: <?php echo $data2['terjual']; ?> | Tersisa: <?php echo $data2['stok']; ?></font>
                                                    <br><br>
                                                    Berat barang:
                                                    <?php echo $data2['berat_barang']; ?> <?php echo $data2['satuan_berat']; ?>
                                                    <br><br>
                                                    Deskripsi barang:
                                                    <p class="row border p-1" style="margin-top:0;margin-left:4px;margin-right:4px;"> <?php echo $data2['deskripsi']; ?></p><br>
                                                    Jumlah beli:
                                                    <input type="number" class="form-control" name="jumlahbarang" value="1" min="1" max="<?php echo $data2['stok']; ?>" >
                                                    
                                                    
                                                </font>
                                            
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn oren" style="width:50%;" name="tambah">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalUlasan<?php echo $data2['kode_barang']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><b><?php echo $data2['nama_barang']; ?></b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            if($baris<1){
                                                echo "Belum ada ulasan untuk produk ini!";
                                            }
                                            $query3 = mysqli_query($conn, "SELECT * FROM ulasan WHERE kode_barang = '".$data2['kode_barang']."' ORDER BY no DESC");
                                            $baris=mysqli_num_rows($query3);   
                                            while($data3 = mysqli_fetch_array($query3)){ 
                                        ?>
                                        <div class="row border p-1 m-1">
                                            <?php 
                                                if($data3['rating']==1){
                                                    echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";
                                                } 
                                                if($data3['rating']==2){
                                                    echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";
                                                } 
                                                if($data3['rating']==3){
                                                    echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";
                                                } 
                                                if($data3['rating']==4){
                                                    echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-border.svg' width='10px' height='10px'>";
                                                } 
                                                if($data3['rating']==5){
                                                    echo "<p><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'><img src='icon/star-fill.svg' width='10px' height='10px'>";
                                                } 
                                            ?>
                                             | <b><?php echo $data3['username']; ?></p></b><p><?php echo $data3['ulasan']; ?></p>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <?php
                }
            ?>
        </div>
        </main>

        <?php if(isset($_SESSION['user'])){ ?>
            <script>
                function modalTambah(id) {
                    var myModal = new bootstrap.Modal(document.getElementById('modalTambah' + id));
                    myModal.show();
                }
                function modalUlasan(id) {
                    var myModal = new bootstrap.Modal(document.getElementById('modalUlasan' + id));
                    myModal.show();
                }
            </script>
        <?php }else{ ?>
            <script>
                function modalTambah(id) {
                    location.href='login.php';
                }
                function modalUlasan(id) {
                    var myModal = new bootstrap.Modal(document.getElementById('modalUlasan' + id));
                    myModal.show();
                }
            </script>
        <?php }?>
    </body>
</html>

<?php 
    if(isset($_POST['kode'])){
        
        $kode = $_POST['kode'];
        $jumlah = $_POST['jumlahbarang'];


        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM keranjang WHERE username ='".$_SESSION['user']."' AND kode_barang = '$kode'"))>0){
            $query=mysqli_query($conn, "SELECT * FROM keranjang WHERE username ='".$_SESSION['user']."' AND kode_barang = '$kode'");
            $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM  keranjang WHERE username ='".$_SESSION['user']."' AND kode_barang = '$kode'"));
            $jumlah+=$data['jumlah'];
            mysqli_query($conn, "UPDATE keranjang SET jumlah = '$jumlah' WHERE kode_keranjang = '".$data['kode_keranjang']."'");
        }else{
            $query = mysqli_query($conn, "INSERT INTO keranjang(username, kode_barang, jumlah) VALUES('$username','$kode','$jumlah')");

            if($query){
                echo "<script>alert('Barang berhasil ditambahkan'); location.href=''; </script>";
            }else{
                echo "<script>alert('Barang gagal ditambahkan'); location.href='';</script>";
            }
        }
      }
?>