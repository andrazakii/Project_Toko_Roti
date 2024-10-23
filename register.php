<?php 
include 'header.php';
?>

<div class="container" style="padding-bottom: 250px;">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Register</b></h2>
	<form action="proses/register.php" method="POST">
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
					<input type="text" class="form-control" id="usernameUser" placeholder="Username" name="username" required >
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="telpUser">No Telp</label>
					<input type="text" class="form-control" id="telpUser" placeholder="+62" name="telp" required >
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
		<!-- <div id="error-message" style="color: red;"></div> -->
		<button type="submit" class="btn btn-primary" id="submitBtn">Register</button>

		<!-- <script>
		document.getElementById('submitBtn').addEventListener('click', function(event) {
			var password = document.getElementById('passUser').value;
			var confirmPassword = document.getElementById('confUser').value;
			var errorMessage = document.getElementById('error-message');

			if (password !== confirmPassword) {
				event.preventDefault();
				errorMessage.textContent = 'Passwords do not match!';
			} else {
				errorMessage.textContent = '';
			}
		});
		</script> -->
	</form>
</div>

<?php 
include 'footer.php';
?>