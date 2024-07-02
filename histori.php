<?php include('header.php'); ?>

<?php
    if(!isset($_SESSION['user'])){
        echo "<script>location.href='login.php'; </script>";
    }
?>
<style>
    .abu:hover{
        background: #f1f1f1;
        cursor: default;
    }
</style>
<main class="container">
    <div class="row justify-content-center">
        <div class="card m-3 align-self-md-center p-3">
            <h3><b>Histori Belanja</b></h3><hr>
            <div class="input-group mb-3">
                <?php 
                    date_default_timezone_set("Asia/Jakarta");
                    
                    $sql = "SELECT * FROM penjualan WHERE username = '".$_SESSION['user']."'";
                    if(isset($_GET['s'])){
                        $start=date($_GET['s']);
                        $sql .= " AND tgl_pesan >= DATE('$start')";
                    }else{
                        $start=date("Y-m-01");
                    }

                    if(isset($_GET['e'])){
                        $end=date($_GET['e']);
                        $sql .= " AND tgl_pesan <= DATE('$end')";
                    }else{
                        $end=date("Y-m-d");
                    }
                ?>
                    <input type="date" class="form-control w-50" id="start" value="<?php echo $start;?>" name="start" onchange="start()">
                    <input type="date" class="form-control w-50" id="end" value="<?php echo $end;?>" name="end" onchange="end()">
            </div>

            <?php 
                include('config/koneksi.php');
            ?>

            <?php
                $query = mysqli_query($conn, $sql." ORDER BY kode_penjualan DESC");
                while($data = mysqli_fetch_array($query)){
            ?>

            <div class="row border p-1 m-1 abu" onclick="pindah(<?php echo $data['kode_penjualan']; ?>)">
                <div class="row">
                    <div class="col">
                        <i><?php echo $data['kode_penjualan']; ?></i><br>
                        <b>Alamat Terima</b><br>
                        <?php echo $data['alamat_terima']; ?>
                    </div>
                    <div class="col">
                        <b>Jasa Pengantaran</b><br>
                        <?php echo $data['nama_jasa_antar']; ?><br><br>

                        <b>Status</b><br>
                            <?php 
                                $status = "<b class='text-danger'>".$data['status']."</b>"; 
                                if($data['status']=="Dikemas"){$status = "<b class='text-warning'>".$data['status']."</b>";}
                                if($data['status']=="Diantar"){$status = "<b class='text-primary'>".$data['status']."</b>";}
                                if($data['status']=="Diterima"){$status = "<b class='text-success'>".$data['status']."</b>";}
                                if($data['status']=="Kadaluarsa"){$status = "<b class='text-secondary'>".$data['status']."</b>";}
                                echo $status; 
                                
                            ?>
                    </div>
                </div>
                <div class="row">
                    <?php
                        if($data['status']=="Belum bayar"){
                            echo "<font color='gray'><sub>*Pesanan akan dibatalkan jika belum dibayar sampai ".date_format(date_create($data['tgl_hapus']), "d/m/Y H:i:s")."</sub></font><br>";
                        }
                    ?>
                    
                </div>
            </div>
                <?php 
                    }
                ?>
        </div>
    </div>
</main>

<script>
    function start(){
        var s = document.getElementById('start').value;
        location.href='?s='+s;
    }
    function end(){
        var s = document.getElementById('start').value;
        var e = document.getElementById('end').value;
        location.href='?s='+s+'&e='+e;
    }
    
    function pindah(kodepenjualan){
        
        location.href='rincian.php?order_id='+kodepenjualan;
    }

    function cari(){
        var kolom = document.getElementById('kolom').value;
        var cari = document.getElementById('cari').value;

        location.href='?p=kategori&kolom='+kolom+'&cari='+cari;
    }

  document.getElementById("cari").addEventListener("keypress",function(event){if(event.key==="Enter"){event.preventDefault(); document.getElementById("btncari").click();}});
</script>

<?php 
    

    //tambah data Kategori
    if(isset($_POST['start'])){
        $nama = $_POST['start'];
    }
?>
