<?php include('header.php'); ?>

<?php
    if(!isset($_SESSION['user'])){
        echo "<script>location.href='login.php'; </script>";
    }
    $query = mysqli_query($conn, "UPDATE keranjang SET status = 0 WHERE username = '".$_SESSION['user']."'");
?>
<main class="container">
    <div class="row justify-content-center">
        <div class="card m-3 align-self-md-center p-3">
            <h3><b>Keranjang Belanja</b></h3><hr>
            <script>
               
                window.addEventListener('beforeunload', () => {
                    var get= document.getElementsByName('checkbox');

                    for(var i= 0; i<get.length; i++){
                        get[i].checked= false;
                    }
                });
                
                let total=0;
                const rupiah = (number)=>{
                    return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                    }).format(number);
                }

            </script>

                <?php 
                    $n=0;
                    $query = mysqli_query($conn, "SELECT * FROM keranjang JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE username = '".$_SESSION['user']."'");
                    while($data = mysqli_fetch_array($query)){
                ?>
                    <input type="text" id="no<?php echo $data['kode_keranjang']; ?>" value="<?php echo $n;?>" hidden>
                    <div class="row border p-1 m-1">
                        <div class="col"><input type="checkbox" class="form-check-input" id="id<?php echo $data['kode_keranjang']; ?>" name="checkbox" onclick="pilih(<?php echo $data['kode_keranjang']; ?>,<?php echo $n;?>)"></div>
                        <script>
                            if (document.getElementById("id<?php echo $data['kode_keranjang']; ?>").checked == true){
                                total+=1;
                            }

                            function tambah<?php echo $data['kode_keranjang']; ?>(){
                                let limit =<?php echo $data['stok']; ?>;
                                if(document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value<limit){
                                    let t= document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value;
                                    t=Number(t)+1;
                                    let n=document.getElementById("no<?php echo $data['kode_keranjang']; ?>").value;
                                    document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value=t;
                                    if(document.getElementById("id<?php echo $data['kode_keranjang']; ?>").checked==true){
                                        total+=<?php echo $data['harga']; ?>;
                                        document.getElementById("total").innerHTML=rupiah(total);
                                        document.getElementById("kode"+n).value=<?php echo $data['kode_keranjang']; ?>;
                                        document.getElementById("jumlah"+n).value=t;
                                    }else{
                                        document.getElementById("kode"+n).value="";
                                        document.getElementById("jumlah"+n).value="";
                                    }
                                    document.getElementById("subtotal<?php echo $data['kode_keranjang']; ?>").value=t*<?php echo $data['harga']; ?>;
                                    if(total==0){
                                        document.getElementById("btn").style.display = "none";
                                    }else{
                                        document.getElementById("btn").style.display = "block";
                                    }
                                }
                            }
                            function kurang<?php echo $data['kode_keranjang']; ?>(){
                                if(document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value>0){
                                    let k= document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value;
                                    k=Number(k)-1;
                                    let n=document.getElementById("no<?php echo $data['kode_keranjang']; ?>").value;
                                    document.getElementById("jumlah<?php echo $data['kode_keranjang']; ?>").value=k;
                                    if(document.getElementById("id<?php echo $data['kode_keranjang']; ?>").checked==true){
                                        total-=<?php echo $data['harga']; ?>;
                                        document.getElementById("total").innerHTML=rupiah(total);
                                        document.getElementById("kode"+n).value=<?php echo $data['kode_keranjang']; ?>;
                                        document.getElementById("jumlah"+n).value=k;
                                        
                                    }else{
                                        document.getElementById("kode"+n).value="";
                                        document.getElementById("jumlah"+n).value="";
                                    }
                                    document.getElementById("subtotal<?php echo $data['kode_keranjang']; ?>").value=k*<?php echo $data['harga']; ?>;
                                    if(total==0){
                                        document.getElementById("btn").style.display = "none";
                                    }else{
                                        document.getElementById("btn").style.display = "block";
                                    }
                                }
                            }
                        </script>
                        <div class="col"><center><img width="200px" class="mb-2" src="admin/gambar/<?php echo $data['gambar']; ?>"></center></div>
                        <div class="col-9">
                            <div class="row-12"><h5><?php echo $data['nama_barang']; ?></h5></div>
                            <div class="row-12"><div class="col"><b>Berat barang</b></div><div class="col"><?php echo $data['berat_barang']." ".$data['satuan_berat']; ?></div></div>
                            <div class="row-12"><div class="col"><b>Harga satuan</b></div><div class="col"><?php echo "Rp ".number_format($data['harga'],2,',','.'); ?></div></div>
                            <div class="row-12"><div class="col"><b>Jumlah beli</b></div>
                                <div class="col">
                                    <div class="input-group w-25">
                                    <button type="button" class="btn btn-outline-secondary" onclick="kurang<?php echo $data['kode_keranjang']; ?>()">-</button>
                                    <input type="number" class="form-control text-center" min=1 max=10 id="jumlah<?php echo $data['kode_keranjang']; ?>" value="<?php echo $data['jumlah']; ?>">
                                    <button type="button" class="btn btn-outline-secondary" onclick="tambah<?php echo $data['kode_keranjang']; ?>()">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row-12"><div class="col"><b>Subtotal</b></div><input type="number" class="form-control w-25" id="subtotal<?php echo $data['kode_keranjang']; ?>" value="<?php $subtotal = $data['jumlah']*$data['harga']; echo $subtotal?>" readonly></input></div><br>
                            <div class="row-12">
                                <button type="button" class="btn btn-danger btn-sm w-25" value="<?php echo $data['kode_keranjang']; ?>" onclick="konfirmasiHapus(<?php echo $data['kode_keranjang']; ?>)">Hapus</button>

                                <!-- modal konfirmasi hapus -->
                                <div class="modal fade" id="konfirmasiHapus<?php echo $data['kode_keranjang']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus dari Keranjang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" method="POST" autocomplete="off">
                                        <div class="modal-body">
                                            <input type="hidden" name="kode_keranjang" value="<?php echo $data['kode_keranjang']; ?>">
                                            <input type="hidden" name="kode_barang" value="<?php echo $data['kode_barang']; ?>">
                                            <input type="hidden" name="jumlah" value="<?php echo $data['jumlah']; ?>">
                                            
                                            <label>Yakin ingin menghapus <b><?php echo $data['nama_barang']; ?></b> dari keranjang?</label><br><br><br>
                                            <p align="right">
                                                <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger w-25" name="btnhapus">Hapus</button>
                                            </p>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        $n+=1; 
                    }

                ?>

                <center>
                    <div class="border mt-3 mb-1 p-3">
                        <b>Total Belanja </b><span id="total"></span>
                    </div>
                    <script>
                        document.getElementById("total").innerHTML=rupiah(total);
                    </script>
                     <form action="keranjang_proses.php" method="POST" autocomplete="off">
                        <input type="text" value="<?php echo $keranjang;?>" name="barang" hidden>
                        <?php
                            for($i=0;$i<$keranjang;$i++){
                                echo "<input type='text' id='kode$i' name='kode$i' hidden>";
                                echo "<input type='text' id='jumlah$i' name='jumlah$i' hidden>";
                            }
                        ?>
                        <button class="btn btn-success w-50" name="checkout" id="btn" style="display:none">Check Out</button>
                    </form>
                </center>
        </div>
    </div>

</main>
<script>
    function konfirmasiHapus(id) {
        var myModal = new bootstrap.Modal(document.getElementById('konfirmasiHapus' + id));
        myModal.show();
    }
    
    function pilih(kode,n){
        if(document.getElementById("id"+kode).checked==true){
            let sub = document.getElementById("subtotal"+kode).value;
            let jumlah = document.getElementById("jumlah"+kode).value;
            total=total+Number(sub);
            document.getElementById("total").innerHTML=rupiah(total);
            document.getElementById("kode"+n).value=kode;
            document.getElementById("jumlah"+n).value=jumlah;
            if(total==0){
                document.getElementById("btn").style.display = "none";
            }else{
                document.getElementById("btn").style.display = "block";
            }
        }else{
            let sub = document.getElementById("subtotal"+kode).value;
            total=total-Number(sub);
            document.getElementById("total").innerHTML=rupiah(total);
            document.getElementById("kode"+n).value="";
            document.getElementById("jumlah"+n).value="";
            if(total==0){
                document.getElementById("btn").style.display = "none";
            }else{
                document.getElementById("btn").style.display = "block";
            }
        }
    }
</script>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    input[type=number] {
    -moz-appearance: textfield;
    }
</style>

<?php

    if(isset($_POST['btnhapus'])){
        $kode_keranjang = $_POST['kode_keranjang'];
        $kode_barang = $_POST['kode_barang'];
        
        $query = mysqli_query($conn, "DELETE FROM keranjang WHERE kode_keranjang = '$kode_keranjang'");

        if($query){
            echo "<script>alert('Barang berhasil dihapus'); location.href=''; </script>";
        }else{
            echo "<script>alert('Barang gagal dihapus')</script>";
        }
    }
?>