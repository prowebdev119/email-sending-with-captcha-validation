<?php
session_start();
if($_GET['la']){
	$_SESSION['la'] = $_GET['la'];
	header('Location:'.$_SERVER['PHP_SELF']);
	exit();
}

switch($_SESSION['la']){
	 case "en":
		require('./lang/en.php');
	break;
	case "fr":
		require('./lang/fr.php');
	break;
	case "de":
		require('./lang/de.php');
	break;
	default:
		require('./lang/de.php');
}


?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ONEMAK</title>
	<link rel="icon" type="image/x-icon" href="./favicon.ico">
	<link rel="stylesheet" type="text/css" href="./style/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script>
var recaptcha_response = '';
function submitUserForm()
	 {
    if(recaptcha_response.length == 0) {
        document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">This field is required.</span>';
        return false;
    }
    return true;
}
function verifyCaptcha(token) {
    recaptcha_response = token;
    document.getElementById('g-recaptcha-error').innerHTML = '';
}
</script>
</head>

<body>
	<div class="header">
		<div class="logo_1">
			<img class="logo" src="./logo.png" alt="logo">
		</div>
	</div>
	<div class="main">
		<div class="main_text"><?= $lang['main_text']; ?></div>
		<div class="main_input" id="openPopup">
			<div class="plus">+</div>
			<div class="main_txt"><?= $lang['main_txt']; ?></div>
		</div>
	</div>
	<div class="footer">
		<div class="footer_1">
			<div>language</div>
			<div>
				<a href="index.php?la=de">DE</a> /
				<a href="index.php?la=en">EN</a> /
				<a href="index.php?la=fr">FR</a>
			</div>
		</div>
		<div class="footer_2"><a href="https://www.onemak.com">Copyright @ ONEMAK Auer Markus</a></div>
		<div class="footer_3"><a href="https://ctp.onemak.com"><?= $lang['footer_3']; ?></a></div>
	</div>
	<form action="./emailsend.php" id="popup" class="popup" method="POST" enctype="multipart/form-data" onsubmit="return submitUserForm()">

		<div class="popup_content">
			<div class="popup_header">
				<?= $lang['popup_header']; ?>
			</div>
			<div class="popup_main">
				<div class="row">
					<div class="col-md-6">
						<div class="email_add"><?= $lang['email_add']; ?></div>
						<input type="email" name="from_email" class="form-control" placeholder="Your Email" required>
					</div>
					<div class="col-md-6">
						<div class="row_2"><?= $lang['row_2']; ?></div>
						<select name="priority" class="custom-select">
							<option selected>Normal</option>
							<option value="lower">Lower</option>
							<option value="medium">Medium</option>
							<option value="high">High</option>
						</select>
					</div>
				</div>
				<div>
					<div class="pt-4 pop_title">Betreff</div>
					<input type="text" name="regarding" class="form-control" placeholder="IT-Support" required>
				</div>
				<div>
					<div class="pt-4 pop_text"><?= $lang['pop_text']; ?></div>
					<textarea class="form-control" name="description" rows="3" id="message" placeholder="<?= $lang['pop_text']; ?>" required></textarea>
				</div>
				<div>
					<div class="pt-4 file_upload"><?= $lang['file_upload']; ?></div>
					<input name="filetosend" type="file">(Only files 8Mbytes)
				</div>
				<div class="g-recaptcha" data-sitekey="6LdhMCAhAAAAANaDdPXtB2xl7evZJDvoIF7Wqka5" data-callback="verifyCaptcha"></div>
  			  	<div id="g-recaptcha-error"></div>
			</div>
			<div class="popup_footer d-flex justify-content-end">
				<button type="submit" class="send"><?= $lang['send']; ?></button>
				<div class="close d-flex align-items-center"><?= $lang['close']; ?></div>
			</div>
		</div>

	</form>
</body>
<script>
	var ebModal = document.getElementById('popup');

	// Get the button that opens the modal
	var ebBtn = document.getElementById("openPopup");

	// Get the <span> element that closes the modal
	var ebSpan = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	ebBtn.onclick = function() {
		ebModal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	ebSpan.onclick = function() {
		ebModal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == ebModal) {
			ebModal.style.display = "none";
		}
	}
</script>

</html>