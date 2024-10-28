<?php 
include 'header.php';
include 'koneksi/koneksi.php'; // Ensure the database connection is included

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM customer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $jml = $result->num_rows;
    $row = $result->fetch_assoc();

    if ($jml == 1) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['nama'];
            $_SESSION['kd_cs'] = $row['kode_customer'];
            header('Location: index.php');
            exit;
        } else {
            $error_message = 'Username atau Password salah';
        }
    } else {
        $error_message = 'Username atau Password salah';
    }

    $stmt->close();
}
?>

<div class="container" style="padding-bottom: 250px;">
    <h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Login</b></h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="username" style="width: 500px;" required>
        </div>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Password" name="pass" style="width: 500px;" required>
        </div>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Login</button>
        <a href="register.php" class="btn btn-primary">Daftar</a>
    </form>
</div>

<?php 
include 'footer.php';
?>