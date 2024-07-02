<?php include('header.php'); ?>
<?php
    if(!isset($_SESSION['user'])){
        echo "<script>location.href='login.php'; </script>";
    }
?>
<main class="container bg-white p-3">
    <h3><b>Barang Dipesan</b></h3><hr>
    <?php 
        $total = 0;
        $query = mysqli_query($conn, "SELECT * FROM keranjang JOIN barang ON keranjang.kode_barang = barang.kode_barang WHERE username = '".$_SESSION['user']."' AND status = 1");
        $berat = 0;
        while($data = mysqli_fetch_array($query)){
            if($data['satuan_berat']=='l'||$data['satuan_berat']=='kg'){
                $berat += 1000*$data['berat_barang']*$data['jumlah'];
            }else{
                $berat += $data['berat_barang']*$data['jumlah'];
            }
    ?>
        <div class="row border p-1 m-1">

            <div class="col"><center><img width="150px" class="mb-2" src="admin/gambar/<?php echo $data['gambar']; ?>"></center></div>
            <div class="col-9">
                <div class="row-12"><h5><?php echo $data['nama_barang']; ?></h5></div>
                <div class="row-12"><div class="col"><b>Berat barang</b></div><div class="col"><?php echo $data['berat_barang']." ".$data['satuan_berat']; ?></div></div>
                <div class="row-12"><div class="col"><b>Harga satuan</b></div><div class="col"><?php echo "Rp ".number_format($data['harga'],2,',','.'); ?></div></div>
                <div class="row-12"><div class="col"><b>Jumlah beli</b></div><div class="col"><?php echo $data['jumlah']; ?></div></div>
                <div class="row-12"><div class="col"><b>Subtotal</b></div><div class="col"><?php $subtotal = $data['jumlah']*$data['harga']; echo "Rp ".number_format($subtotal,2,',','.'); ?></div></div>
            </div>
        </div>
    <?php 
            $total += $subtotal;
        }
    ?>
    <form action="checkout_proses.php" method="POST" autocomplete="off">
        <center>
            <div class="border mt-3 mb-1 p-3">
                <b>Total Belanja </b>
                <input required type="text" class="form-control" name="totalharga" value="<?php echo $total; ?>" hidden>
                <b id="totalharga" hidden><?php echo $total; ?></b>
                <?php echo "Rp ".number_format($total,2,',','.'); ?>
            </div>
        </center>
                
                

    <br><h3><b>Informasi Pengiriman</b></h3><hr>

    <?php 
         $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE username = '".$_SESSION['user']."'"));
    ?>
        <div class="row">
            <div class="mb-3 col-6">
                <label class="form-label">Username</label>
                <input required type="text" class="form-control" name="username" value="<?php echo $data['username'];?>" readonly>
            </div>
            <div class="mb-3 col-6">
                <label class="form-label">Nomor HP Penerima</label>
                <input required type="number" class="form-control" name="nohp" value="<?php echo $data['nohp'];?>">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-4">
                <label class="form-label">Provinsi</label>
                <select class="form-select" id="provinsi" required>
                    <option selected>Pilih Provinsi</option>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label">Kabupaten/Kota</label>
                <select class="form-select" id="kota" required'>
                    <option selected>Pilih Kabupaten/Kota</option>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label">Pengantaran</label>
                <select name="kurir" class="form-select" id="kurir">
                    <option selected>Pilih Kurir</option>
                    <?php
                        $query2 = mysqli_query($conn, "SELECT * FROM jasa_antar");
                        while($data2 = mysqli_fetch_array($query2)){
                    ?>
                        <option value="<?php echo strtolower($data2['nama_jasa_antar']); ?>"><?php echo $data2['nama_jasa_antar']; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
        </div>
        <label class="form-label">Alamat Terima</label>
        <textarea required type="text" class="form-control" name="alamat"><?php echo $data['alamat'];?></textarea><br>
        <div class="row">
            
            <div class="mb-3 col-6">
                <label class="form-label">Paket Pengantaran</label>
                <select class="form-select" id="paket" required onchange='getdata()'>
                    <option selected>Pilih Paket</option>
                </select>
            </div>
            <div class="mb-3 col-6">
                <label class="form-label">Harga Ongkir</label>
                <input required type="text" class="form-control" name="ongkir" id="ongkir" hidden><br>
                <input required type="text" class="form-control" name="ongkir_s" id="ongkir_s" readonly><br>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input required type="text" name="totalbayar" class="form-control" id="totalbayar" readonly value="0" placeholder="Total Belanja + Ongkir" required>
            <label for="nama">Total Belanja + Ongkir</label>
        </div>

        <hr>
        <button class="btn oren w-100" name="checkout" >Konfirmasi Pesanan</button>
        <input required type="text" name="provinsi" class="form-control" id="provinsi_php" readonly hidden>
        <input required type="text" name="kota" class="form-control" id="kota_php" readonly hidden>
        <input required type="text" name="paket" class="form-control" id="paket_php" readonly hidden>
            
    </form>
    
</main>
<script src="js/jquery-3.6.0.js"></script>
<script>
    function getdata(){
        var e = document.getElementById("provinsi");
        var text = e.options[e.selectedIndex].text;
        document.getElementById("provinsi_php").value=text;

        e = document.getElementById("kota");
        text = e.options[e.selectedIndex].text;
        document.getElementById("kota_php").value=text;

        e = document.getElementById("paket");
        text = e.options[e.selectedIndex].text;
        document.getElementById("paket_php").value=text;
    }
    $(document).ready(function(){
        $.ajax({
            url: 'rajaongkir/provinsi.php',
            type: 'GET',
            start: $('#provinsi').html('<option>Memuat Provinsi...</option>'),
            success: function(result){
                var hasil = JSON.parse(result);
                var provinsi = hasil.rajaongkir.results;
                var item = "<option selected>Pilih Provinsi</option>";
                $.each(provinsi, function(index,value){
                    item += "<option value='" + this.province_id + "'>" + this.province + "</option>";
                });
                $('#provinsi').html(item);
                $('#nama').focus();
            }
        });
    });

    $('#provinsi').change(function(){
        var kode = $(this).val();
        $.ajax({
            url: 'rajaongkir/kota.php',
            type: 'GET',
            data: 'provinsi=' + kode,
            start: $('#kota').html('<option>Memuat Kota</option>'),
            success: function(result){
                var hasil = JSON.parse(result);
                var kota = hasil.rajaongkir.results;
                var item = "<option selected>Pilih Kabupaten/Kota</option>";
                $.each(kota, function(index,value){
                    item += "<option value='" + this.city_id + "'>" + this.type + " " + this.city_name + "</option>";
                });
                $('#kota').html(item);
                $('#kota').focus();
            }
        });
    });

    $('#kota').change(function(){
        $('#kurir').focus();
    });

    $('#kurir').change(function(){
        var kota = $('#kota').val();
        var kurir = $('#kurir').val();
        $.ajax({
            url: 'rajaongkir/ongkir.php?berat=<?php echo $berat; ?>',
            type: 'GET',
            data: 'kota_tujuan=' + kota + '&kurir=' + kurir,
            start: $('#paket').html('<option>Memuat Paket</option>'),
            success: function(result){
                var hasil = JSON.parse(result);
                var paket = hasil.rajaongkir.results[0].costs;
                var item = "<option selected>Pilih Paket</option>";
                $.each(paket, function(index,value){
                    item += "<option value='" + this.cost[0].value + "'>" + 
                    this.service + " (" + this.description + "), Estimasi Sampai : " + 
                    this.cost[0].etd + " hari</option>";
                });
                $('#paket').html(item);
                $('#totalbayar').focus();
            }
        });
    });
    const formatter = new Intl.NumberFormat('id-ID', {style: 'currency',currency: 'IDR',});

    $('#paket').change(function(){
        var ongkir = parseInt($(this).val());
        $('#ongkir_s').val(formatter.format(ongkir));
        $('#ongkir').val(ongkir);
    });

    $('#paket').change(function(){
        var ongkir = parseInt($(this).val());
        var total = parseInt($('#totalharga').html());
        var totalbayar = ongkir + total;

        $('#totalbayar').val(formatter.format(totalbayar));
    });
</script>
