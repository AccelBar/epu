<?php
session_start();
include 'db.php';
$conn = new Db;
$conn->connect($servername, $dbname, $username, $password);
if (isset($_GET["accept"])) {
	$change = $conn->oneResult("UPDATE rezervace SET status = 0 WHERE id = ?", array($_GET["accept"]));
	$_SESSION["notif"] = "Rezervace vyřízena";
	header("Location: index.php");
	exit();
}
if (isset($_GET["deny"])) {
	$change = $conn->oneResult("UPDATE rezervace SET status = 2 WHERE id = ?", array($_GET["deny"]));
	$_SESSION["notif"] = "Rezervace zamítnuta";
	header("Location: index.php");
	exit();
}
if (isset($_POST["new"])) {
	$control = $conn->allResults("SELECT * FROM rezervace WHERE date = ? AND time = ?", array($_POST["date"], $_POST["time"]));
	if (count($control) == 20) {
		$_SESSION["notif"] = "Rezervaci nebylo možné uskutečnit - není dostatek volných míst";
		header("Location: index.php");
		exit();
	}
	else {
		$new = $conn->oneResult("INSERT INTO rezervace (name, surname, mail, customers, time, date, note) VALUES (?, ?, ?, ?, ?, ?, ?)", array(trim($_POST["firstname"]), trim($_POST["lastname"]), $_POST["email"], $_POST["customers"], $_POST["time"], $_POST["date"], $_POST["note"]));
		$_SESSION["notif"] = "Rezervace odeslána";
		header("Location: index.php");
		exit();
	}
}
if (isset($_GET["login"])) {
	if ($_GET["login"] == "admin") {
		$_SESSION["admin"] = 1;
	}
	header("Location: /");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Techcafé</title>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<meta charset="utf-8">
</head>
<body>
<?php
if (isset($_SESSION["notif"])) {
	echo "<div class='alert alert-dark text-center'>".$_SESSION["notif"]."</div>";
	unset($_SESSION["notif"]);
}
?>
<div class="container mt-5">
	<div class="fs-3">Rezervační systém kavárny Techcafé</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="lead">Vytvořit rezervaci</div>
			<form method="post">
				<div class="input-group">
					<input type="text" required name="firstname" placeholder="Jméno" class="form-control mb-3">
					<input type="text" required name="lastname" placeholder="Přijmení" class="form-control mb-3">
				</div>
				<input type="email" required name="email" placeholder="Email" value="@" class="form-control mb-3">
				<div class="input-group">
					<input type="date" required name="date" class="form-control mb-3">
					<input type="time" required name="time" class="form-control mb-3">
				</div>
				<select name="customers" class="form-control mb-3">
					<option value="0" disabled hidden selected>Počet míst</option>
					<?php
						for ($i=1; $i <=8; $i++) { 
							echo "<option value='".$i."'>".$i."</option>";
						}
					?>
				</select>
				<input maxlength="255" type="text" name="note" placeholder="Poznámka (specialní dieta, kuřák/nekuřák...)" class="form-control mb-3">
				<button class="btn btn-dark" name="new">Rezervovat</button>
			</form>
		</div>
		<?php
			if (isset($_SESSION["admin"])) {
				include 'admin.php';
			}
		?>
	</div>
</div>
</body>
</html>