<?php 
    namespace Midtrans;
    include('header.php');

    if(!isset($_SESSION['user'])){
        echo "<script>location.href='login.php'; </script>";
    }
  
    $kode=$_GET['order_id'];

    $_SESSION['kode']=$kode;

    $item_details = array ();

    // Required
    $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penjualan WHERE kode_penjualan = '$kode'"));

    $transaction_details = array(
        'order_id' => $kode,
        'gross_amount' => $data['total_harga_barang']+$data['harga_ongkir'], 
    );
    array_push($item_details,array(
        'id' => 0,
        'price' => $data['harga_ongkir'],
        'quantity' => 1,
        'name' => "Pengantaran ".$data['nama_jasa_antar']
    ));

    $query = mysqli_query($conn, "SELECT * FROM barang JOIN penjualan_detail ON barang.kode_barang = penjualan_detail.kode_barang WHERE kode_penjualan = '$kode'");
                    
    while($data = mysqli_fetch_array($query)){
        array_push($item_details,array(
            'id' => $data['kode_barang'],
            'price' => $data['harga'],
            'quantity' => $data['jumlah'],
            'name' => $data['nama_barang']
        ));
    }

    require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
    

    Config::$serverKey = 'SB-Mid-server-K-Pd0_Y-Ij3S8a8ldFlL_Kp8';
    Config::$clientKey = 'SB-Mid-client-QQUO_oeiB1keUEES';

    printExampleWarningMessage();

    Config::$isSanitized = Config::$is3ds = true;

    // Optional
    $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE username = '".$_SESSION['user']."'"));
    $customer_details = array(
        'first_name'    => $data['username'],
        'phone'         => $data['nohp'],
    );
    // Fill transaction details
    $transaction = array(
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
    );

    $snap_token = '';
    try {
        $snap_token = Snap::getSnapToken($transaction);
    }
    catch (\Exception $e) {
        
    }

    function printExampleWarningMessage() {
        if (strpos(Config::$serverKey, 'your ') != false ) {
            echo "<code>";
            echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-K-Pd0_Y-Ij3S8a8ldFlL_Kp8\';');
            die();
        } 
    }

?>
<main class="container">
    <div class="row justify-content-center">
        <div class="card m-3 align-self-md-center p-3">
            <h3><b>Rincian Pesanan</b></h3><hr><font color="gray"><b id="info"></b></font>

                <?php 
                    $nomor = 1;
                    $total = 0;
                    $query = mysqli_query($conn, "SELECT * FROM barang JOIN penjualan_detail ON barang.kode_barang = penjualan_detail.kode_barang WHERE kode_penjualan = '$kode'");
                    while($data = mysqli_fetch_array($query)){
                ?>
                    <div class="row border p-1 m-1 abu" onclick="modalRating(<?php echo $data['kode_barang']; ?>)">
                        <div class="col"><center><img width="200px" class="mb-2" src="admin/gambar/<?php echo $data['gambar']; ?>"></center></div>
                            <div class="col-9">
                                <div class="row-12"><h5><?php echo $data['nama_barang']; ?></h5></div>
                                <div class="row-12"><div class="col"><b>Berat barang</b></div><div class="col"><?php echo $data['berat_barang']." ".$data['satuan_berat']; ?></div></div>
                                <div class="row-12"><div class="col"><b>Harga satuan</b></div><div class="col"><?php echo "Rp ".number_format($data['harga'],2,',','.'); ?></div></div>
                                <div class="row-12"><div class="col"><b>Jumlah beli</b></div><div class="col"><?php echo $data['jumlah']; ?></div></div>
                                <div class="row-12"><div class="col"><b>Subtotal</b></div><div class="col"><?php $subtotal = $data['jumlah']*$data['harga']; echo "Rp ".number_format($subtotal,2,',','.'); ?></div></div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalRating<?php echo $data['kode_barang']; ?>" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ulasan untuk <?php echo $data['nama_barang']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="ulasan.php" method="POST">
                                        <div class="modal-body">
                                            <center>
                                                <img src="icon/star-gray.svg" id="<?php echo $data['kode_barang']; ?>bin1" onmouseover="terang(1,<?php echo $data['kode_barang']; ?>)" onclick="terang(1,<?php echo $data['kode_barang']; ?>)" width="40px" height="40px">
                                                <img src="icon/star-gray.svg" id="<?php echo $data['kode_barang']; ?>bin2" onmouseover="terang(2,<?php echo $data['kode_barang']; ?>)" onclick="terang(2,<?php echo $data['kode_barang']; ?>)" width="40px" height="40px">
                                                <img src="icon/star-gray.svg" id="<?php echo $data['kode_barang']; ?>bin3" onmouseover="terang(3,<?php echo $data['kode_barang']; ?>)" onclick="terang(3,<?php echo $data['kode_barang']; ?>)" width="40px" height="40px">
                                                <img src="icon/star-gray.svg" id="<?php echo $data['kode_barang']; ?>bin4" onmouseover="terang(4,<?php echo $data['kode_barang']; ?>)" onclick="terang(4,<?php echo $data['kode_barang']; ?>)" width="40px" height="40px">
                                                <img src="icon/star-gray.svg" id="<?php echo $data['kode_barang']; ?>bin5" onmouseover="terang(5,<?php echo $data['kode_barang']; ?>)" onclick="terang(5,<?php echo $data['kode_barang']; ?>)" width="40px" height="40px"><br>
                                            </center>
                                                <label class="form-label">Ulasan</label>
                                                <textarea type="text" class="form-control" name="ulasan"></textarea>
                                            
                                        </div>
                                        <input type="number" name="rating" id="<?php echo $data['kode_barang']; ?>rating" hidden>
                                        <input type="number" name="kodebarang" value="<?php echo $data['kode_barang']; ?>" hidden>

                                        <div class="modal-footer">
                                            <button class="btn oren" style="width:50%;" name="kirim" value="kirim">Kirim Ulasan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                            $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penjualan WHERE kode_penjualan = '$kode'"));
                            if ($data2['status']=="Diterima"){
                        ?>
                        <script>
                            function terang(n,kode){
                                for(let i=1;i<=5;i++){
                                    document.getElementById(kode+"bin"+i).src="icon/star-gray.svg";
                                }
                                for(let i=1;i<=n;i++){
                                    document.getElementById(kode+"bin"+i).src="icon/star-fill.svg";
                                }
                                
                                document.getElementById(kode+"rating").value=n;
                            }

                            function modalRating(id) {
                                var myModal = new bootstrap.Modal(document.getElementById('modalRating' + id));
                                myModal.show();
                            }
                            document.getElementById("info").innerHTML="*Tekan produk untuk memberi ulasan";
                        </script>
                        <style>
                            .abu:hover{
                                background: #f1f1f1;
                                cursor: default;
                            }
                        </style>

                    <?php }?>
                <?php 
                        $nomor++;
                        $total += $subtotal;
                    }
                ?>
                        
                    <center>
                        <div class="border mt-3 mb-1 p-3">
                            <b>Total Belanja </b><?php echo "Rp ".number_format($total,2,',','.'); ?>
                        </div>
                    </center>

                    <?php 
                        $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penjualan WHERE kode_penjualan = '$kode'"));
                        if ($data2['status']=="Diantar"){
                    ?>
                            <div class="modal fade" id="modalAntar">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><b>Bukti Pengantaran</b></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <center class="m-2">
                                            <?php echo "<img src='./admin/gambar/buktiantar/".$data2['bukti_antar']."' width='50%'>";?>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalTerima">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><b>Bukti Terima</b></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <label for="nama" class="form-label">Bukti Terima</label>
                                                <input type="file" class="form-control" name="gambar" accept="image/*" style="border:1px solid #bebebe">
                                            </div>
                                                
                                            <div class="modal-footer">
                                                <button class="btn oren" style="width:50%;" name="terima">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <center> 
                            <button class="btn btn-primary w-50 mb-2" id="antar" onclick="modalAntar()">Bukti Pengantaran</button></a>
                            <button class="btn btn-success w-50 mb-2" id="terima" onclick="modalTerima()">Diterima</button></a>
                            <script>
                                function modalAntar() {
                                    var myModal = new bootstrap.Modal(document.getElementById('modalAntar'));
                                    myModal.show();
                                }
                                function modalTerima() {
                                    var myModal = new bootstrap.Modal(document.getElementById('modalTerima'));
                                    myModal.show();
                                }
                            </script>
                            </center>


                    <?php }?>

                    <?php 
                        $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penjualan WHERE kode_penjualan = '$kode'"));
                        if ($data2['status']=="Belum bayar" || $data2['status']=="Menunggu Pembayaran"){
                    ?>
                        <center class="mb-2"> 
                            <?php if ($data2['status']=="Belum bayar"){ ?>
                            <button class="btn btn-success w-50 mb-2" id="pay-button">Bayar</button>
                            <?php } if ($data2['status']=="Menunggu Pembayaran"){ ?>
                            <button class="btn btn-success w-50" onclick="modalBayar()">Bayar</button>
                             <!-- modal bayar -->
                        <div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bayar Pesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="#" method="POST">
                                <div class="modal-body">
                                
                                    <label for="hapuskategori" class="form-label mb-2">Silahkan bayar pesanan Anda<br> <input type="text" value="<?php echo strtoupper($data2['pembayaran']);?>" id="va"></label>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn oren" style="width:50%;"
                                    onclick="copy()">Salin VA</button>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        </center>
                        <?php }?>
                        <center> 
                        <button class="btn btn-danger w-50" onclick="modalHapus()">Batalkan Pesanan</button></a>
                        <!-- modal hapus barang -->
                        <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Batalkan Pesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="#" method="POST">
                                <div class="modal-body">
                                
                                    <label for="hapuskategori" class="form-label">Yakin akan membatalkan penjualan?</label>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn oren" style="width:50%;" name="batal" value="batal">Batalkan</button>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </center><?php }?>
        </div>
    </div>

</main>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
 
<script>
    function modalHapus() {
        var myModal = new bootstrap.Modal(document.getElementById('modalHapus'));
        myModal.show();
    }
    function modalBayar() {
        var myModal = new bootstrap.Modal(document.getElementById('modalBayar'));
        myModal.show();
    }

    document.getElementById('pay-button').onclick = function(){
        snap.pay('<?php echo $snap_token?>');
    };
    
    function copy() {
        var copyText = document.getElementById("va");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("Nomor Virtua Account tersalin!");
        }

</script>
       


<?php
    if(isset($_POST['batal'])){
        
        $query = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE kode_penjualan = '$kode'");
        while($data = mysqli_fetch_array($query)){
            $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '".$data['kode_barang']."'"));
            $stok=$data2['stok']+$data['jumlah'];
            $jual=$data2['terjual']-$data['jumlah'];
            $query2 = mysqli_query($conn, "UPDATE barang SET stok = '$stok', terjual= '$jual' WHERE kode_barang = '".$data['kode_barang']."'");
        }

        $query = mysqli_query($conn, "DELETE FROM penjualan WHERE kode_penjualan = '$kode'");
        $query = mysqli_query($conn, "DELETE FROM penjualan_detail WHERE kode_penjualan = '$kode'");

        if($query){
            echo "<script>alert('Pesanan berhasil dibatalkan'); location.href='histori.php'; </script>";
        }else{
            echo "<script>alert('Pesanan gagal dibatalkan')</script>";
        }

        

    }
    
    if(isset($_POST['terima'])){
        $tanggal=date_format(date_create(date("Y/m/d")),"Y/m/d");
        
        $gambar = $_FILES["gambar"]["name"];
        $folder = "admin/gambar/buktiterima/" . $gambar;
        $tmp = $_FILES["gambar"]["tmp_name"];
        move_uploaded_file($tmp, $folder);
  
        $query = mysqli_query($conn, "UPDATE penjualan SET tgl_terima = '$tanggal', status='Diterima', bukti_terima='$gambar' WHERE kode_penjualan = '$kode'");

        if($query){
            echo "<script>alert('Pesanan berhasil diterima'); location.href=''; </script>";
        }else{
            echo "<script>alert('Pesanan gagal diterima')</script>";
        }
    }
?>