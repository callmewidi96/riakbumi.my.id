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
            <h2 class="form-header">Login</h2>
            <div class="form">
                <hr>
                <font color="red" id="notif"><br></font>
                
                <form method="post" action="" autocomplete="off">
                    <input type="text" name="username" placeholder="Username"><br>
                    <input type="password" name="pass" placeholder="Password"><br><br>
                    <button name="login" class="w-100 btn btn-lg oren">Masuk</button>
                </form><hr>
            </div>
            <center class="form-footer">Belum punya akun? <u class="back"><a href="./register.php">Daftar disini!</a></u></center><br>
        
</main>
    </body>
</html>


<?php 
    //ini untuk logout
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['role']);
    session_destroy();
    
    //login
    session_start();
    if(isset($_POST['login'])){
        if(empty($_POST['username'])||empty($_POST['pass'])){
            echo "<script>document.getElementById('notif').innerHTML='Masukkan semua data!';</script>";
        }else{
            $username=$_POST['username'];
            $pass=$_POST['pass'];
            
            $query = "SELECT * FROM user WHERE username='$username'";
            $query = mysqli_query($conn,$query);
            
            if (mysqli_num_rows($query)> 0) {
                $isi = mysqli_fetch_assoc($query);

                if($isi["password"]==$pass){
                    if($isi["status"]=="Aktif"){
                        $_SESSION['user']=$isi['username'];
                        $_SESSION['role']=$isi['role'];
    
                        if($isi["role"]=="adm"){
                            header('location:./admin/index.php?p=barang');
                        }else{
                            header('location:./index.php');
                        }
                    }else{
                        echo "<script>document.getElementById('notif').innerHTML='Akun Anda terblock!';</script>";
                    }
                }else{
                    echo "<script>document.getElementById('notif').innerHTML='Password salah!';</script>";
                }
            }else{
                echo "<script>document.getElementById('notif').innerHTML='Akun tidak terdaftar!';</script>";
            }
            mysqli_close($conn);
        }
    }
    
?>