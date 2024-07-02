<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for sample HTTP notifications:
// https://docs.midtrans.com/en/after-payment/http-notification?id=sample-of-different-payment-channels

namespace Midtrans;

require_once dirname(__FILE__) . '/../Midtrans.php';
Config::$isProduction = false;
Config::$serverKey = 'SB-Mid-server-K-Pd0_Y-Ij3S8a8ldFlL_Kp8';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

try {
    $notif = new Notification();
}
catch (\Exception $e) {
    exit($e->getMessage());
}

$notif = $notif->getResponse();
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

$status = '';
try {
    $status = Transaction::status($order_id);
} catch (\Exception $e) {
    echo $e->getMessage();
    die();
}

$data = json_encode($status->va_numbers);
$dataArray = json_decode($data, true);
$vaNumber = $dataArray[0]['va_number'];

$data = json_encode($status->va_numbers);
$dataArray = json_decode($data, true);
$bank = $dataArray[0]['bank'];



$conn = mysqli_connect("localhost", "riakbumi_admin", "M(]O]CCTi#Mn", "riakbumi_riakbumi");
if ($transaction == 'capture') {
    // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // TODO set payment status in merchant's database to 'Challenge by FDS'
            // TODO merchant should decide whether this transaction is authorized or not in MAP
            echo "Transaction order_id: " . $order_id ." is challenged by FDS";
        } else {
            // TODO set payment status in merchant's database to 'Success'
            echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
        }
    }
} else if ($transaction == 'settlement') {
    date_default_timezone_set("Asia/Jakarta");
    $tanggal=date_format(date_create(date("Y/m/d")),"Y/m/d");
    $query = mysqli_query($conn, "UPDATE penjualan SET tgl_bayar = '$tanggal', status = 'Dikemas' WHERE kode_penjualan = '$order_id'"); 
   
} else if ($transaction == 'pending') {
    $query = mysqli_query($conn, "UPDATE penjualan SET tgl_bayar = '$tanggal', status = 'Menunggu Pembayaran', pembayaran = '$bank-$vaNumber' WHERE kode_penjualan = '$order_id'"); 
} else if ($transaction == 'deny') {
    $query = mysqli_query($conn, "DELETE FROM penjualan WHERE kode_penjualan = '$order_id'");
} else if ($transaction == 'expire') {
    $query = mysqli_query($conn, "UPDATE penjualan SET status = 'Kadaluarsa' WHERE kode_penjualan = '$order_id'");
    $query2 = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE kode_penjualan = '$kode'");
    while($data = mysqli_fetch_array($query2)){
        $data2=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '".$data['kode_barang']."'"));
        $stok=$data2['stok']+$data['jumlah'];
        $jual=$data2['terjual']-$data['jumlah'];
        $query3 = mysqli_query($conn, "UPDATE barang SET stok = '$stok', terjual= '$jual' WHERE kode_barang = '".$data['kode_barang']."'");
    }
} else if ($transaction == 'cancel') {
    $query = mysqli_query($conn, "DELETE FROM penjualan WHERE kode_penjualan = '$order_id'");
}


function printExampleWarningMessage() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
    }
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-K-Pd0_Y-Ij3S8a8ldFlL_Kp8\';');
        die();
    }   
}
