<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/user.css" rel="stylesheet">
<?php include('config/koneksi.php'); ?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title>Login</title>
    </head>
    <body class="text-center">
    
        <main class="bgform">
            <h2 class="form-header">Register</h2>
            <div class="form">
                <hr>
                <font color="red" id="notif"><br></font>
                
                <form method="post" action="" autocomplete="off">
                    <input type="text" name="username" placeholder="Username"><br>
                    <input type="password" name="pass" placeholder="Password"><br>
                    <input type="password" name="pass2" placeholder="Konfirmasi Password"><br><br>
                    <button name="daftar" class="w-100 btn btn-lg oren">Daftar</button>
                </form><hr>
            </div>
            <center class="form-footer">Sudah punya akun? <u class="back"><a href="./login.php">Masuk disini!</a></u></center><br>
        
</main>
    </body>
</html>


<?php
    if(isset($_POST['daftar'])){
        if(empty($_POST['username'])||empty($_POST['pass'])){
            echo "<script>document.getElementById('notif').innerHTML='Masukkan semua data!';</script>";
        }else{
            if($_POST['pass']==$_POST['pass2']){
                $username=$_POST['username'];
                $pass=$_POST['pass'];

                $query = "INSERT INTO user (`username`, `password`, `role`, `status`) VALUES ('$username', '$pass', 'usr', 'Aktif')";
                
                if (mysqli_query($conn, $query)) {
                    header('location:./login.php');
                }else{
                    echo "<script>document.getElementById('notif').innerHTML='Username sudah terdaftar!';</script>";
                }
                mysqli_close($conn);
            }else{
                echo "<script>document.getElementById('notif').innerHTML='Password tidak sesuai!';</script>";
            }
        }
    }
?>