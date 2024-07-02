<?php include('header.php'); ?>
<?php
    if(!isset($_SESSION['user'])){
        echo "<script>location.href='login.php'; </script>";
    }
    
    $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE username = '".$_SESSION['user']."'"));
    
?>
<main class="container-fluid">
    <div class="row justify-content-center">
        <div class="card m-3 align-self-md-center" style="width:30rem;">
            <div class="card-body">
            <form action="" method="POST" autocomplete="off">
                <h5><b><?php echo $data['username'];?></b></h5><hr>

                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $data['username'];?>"><br>

                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo $data['password'];?>"><br>

                <label class="form-label">Nomor HP</label>
                <input type="number" class="form-control" name="nohp" value="<?php echo $data['nohp'];?>"><br>

                <label class="form-label">Alamat</label>
                <textarea type="text" class="form-control" name="alamat"><?php echo $data['alamat'];?></textarea>
                <hr>
                <button class="btn oren w-100" name="btnedit" value="edit">Perbaharui</button>
            </form>
                <a href="login.php"><button class="btn btn-danger w-100">Logout</button></a>
            </div>
        </div>
    </div>
</main>

<?php
    if(isset($_POST['btnedit'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $nohp=$_POST['nohp'];
        $alamat=$_POST['alamat'];

        $query = mysqli_query($conn, "UPDATE user SET  username = '$username',  password = '$password', nohp = '$nohp',  alamat = '$alamat' WHERE username = '".$_SESSION['user']."'");

        if($query){
            $_SESSION['user']=$username;
            echo "<script>alert('Profil berhasil diperbaharui'); location.href=''; </script>";
        }else{
            echo "<script>alert('Username tidak tersedia!'); location.href=''; </script>";
        }
    }

?>