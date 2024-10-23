<?php 
include 'koneksi/koneksi.php';
include 'header.php'; // Include the header to maintain consistent structure

$kode = mysqli_query($conn, "SELECT kode_customer from customer order by kode_customer desc");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['kode_customer'], 1, 4);
$add = (int) $num + 1;
if(strlen($add) == 1){
    $format = "C000".$add;
}else if(strlen($add) == 2){
    $format = "C00".$add;
}
else if(strlen($add) == 3){
    $format = "C0".$add;
}else{
    $format = "C".$add;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $tlp = $_POST['telp'];
    $konfirmasi = $_POST['konfirmasi'];

    if ($password == $konfirmasi) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT username FROM customer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $jml = $stmt->num_rows;

        if ($jml == 1) {
            echo "
            <script>
            alert('USERNAME SUDAH DIGUNAKAN');
            window.location = '../register.php';
            </script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO customer (kode_customer, nama, username, password, email, telp) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $format, $nama, $username, $hash, $email, $tlp);
            if ($stmt->execute()) {
                echo "
                <script>
                alert('Registration successful.');
                window.location = '../index.php';
                </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "
        <script>
        alert('Passwords do not match.');
        window.location = '../register.php';
        </script>";
    }
} else {
    echo "All fields are required.";
}

$conn->close();
include 'footer.php'; // Include the footer to maintain consistent structure
?>