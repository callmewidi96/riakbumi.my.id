<?php
    namespace Midtrans;
    require_once dirname(__FILE__) . '/../../Midtrans.php';
    

    Config::$serverKey = 'SB-Mid-server-K-Pd0_Y-Ij3S8a8ldFlL_Kp8';
    Config::$clientKey = 'SB-Mid-client-QQUO_oeiB1keUEES';

    printExampleWarningMessage();

    Config::$isSanitized = Config::$is3ds = true;

    // Required
    $transaction_details = array(
        'order_id' => rand(),
        'gross_amount' => 94000, // no decimal allowed for creditcard
    );
    // Optional
    $item_details = array (
        array(
            'id' => 'a1',
            'price' => 94000,
            'quantity' => 1,
            'name' => "Apple"
        ),
    );
    // Optional
    $customer_details = array(
        'first_name'    => "Andri",
        'last_name'     => "Litani",
        'email'         => "andri@litani.com",
        'phone'         => "081122334455",
        'billing_address'  => $billing_address,
        'shipping_address' => $shipping_address
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
        echo $e->getMessage();
    }
    echo "snapToken = ".$snap_token;

    function printExampleWarningMessage() {
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

?>

<!DOCTYPE html>
<html>
    <body>
        <button id="pay-button">Pay!</button>
        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('<?php echo $snap_token?>');
            };
        </script>
    </body>
</html>
