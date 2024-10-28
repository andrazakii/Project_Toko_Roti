<?php 
include 'header.php';
include 'koneksi/koneksi.php'; // Ensure the database connection is included

$kode = mysqli_query($conn, "SELECT kode_customer FROM customer ORDER BY kode_customer DESC");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['kode_customer'], 1, 4);
$add = (int) $num + 1;
if (strlen($add) == 1) {
    $format = "C000" . $add;
} elseif (strlen($add) == 2) {
    $format = "C00" . $add;
} elseif (strlen($add) == 3) {
    $format = "C0" . $add;
} else {
    $format = "C" . $add;
}

$registrationSuccess = false;
?>

<div class="container" style="padding-bottom: 250px;">
    <h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Register</b></h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="namaUser">Nama</label>
                    <input type="text" class="form-control" id="namaUser" placeholder="Nama User" name="nama" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="emailUser">Email</label>
                    <input type="email" class="form-control" id="emailUser" placeholder="Email" name="email" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="usernameUser">Username</label>
                    <input type="text" class="form-control" id="usernameUser" placeholder="Username" name="username" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telpUser">No Telp</label>
                    <input type="text" class="form-control" id="telpUser" placeholder="+62" name="telp" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="passUser">Password</label>
                    <input type="password" class="form-control" id="passUser" placeholder="Password" name="password" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="confUser">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confUser" placeholder="Konfirmasi Password" name="konfirmasi" required>
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $tlp = $_POST['telp'];
            $konfirmasi = $_POST['konfirmasi'];

            if ($password != $konfirmasi) {
                echo "<div class='alert alert-danger'>Password tidak sama</div>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("SELECT username FROM customer WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $jml = $stmt->num_rows;

                if ($jml == 1) {
                    echo "<div class='alert alert-danger'>Username sudah digunakan</div>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO customer (kode_customer, nama, username, password, email, telp) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $format, $nama, $username, $hash, $email, $tlp);
                    if ($stmt->execute()) {
                        $registrationSuccess = true;
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                }
                $stmt->close();
            }
        }
        ?>

        <button type="submit" class="btn btn-primary" id="submitBtn">Register</button>
    </form>

    <?php
    if ($registrationSuccess) {
        echo "<div class='alert alert-success text-center'>Registrasi Berhasil<br></div>";
        echo "<script>
        document.querySelector('form').style.display = 'none';
        var successAlert = document.querySelector('.alert-success');
        successAlert.innerHTML += '<br><div style=\"text-align: center;\"><a href=\"user_login.php\" class=\"btn btn-primary\">Next</a></div>';
        </script>";
    }
    ?>
</div>

<?php 
include 'footer.php';
?>