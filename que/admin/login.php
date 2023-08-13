<?php
include('./header.php');
include 'include-admin/header.php';
include('db_connect.php');
?>

<?php
// session_start();
if (isset($_SESSION['login_id']))
	header("location:index.php?page=dashboard");
?>

</head>


<link rel="stylesheet" href="../admin/assets/css/css-splash/main.css">
<link rel="stylesheet" href="../admin/assets/css/css-splash/normalize.css">
<script src="../admin/assets/css/js-splash/vendor/modernizr-2.6.2.min.js"></script>

<style>
	/* .material-icons.md-18 { 
		font-size: 18px; 
		align-items: right;
		}

		.mdl-cell { 
          position: relative;
          text-align:center;
          background-color:#ddd;
          padding:2em 0;
        }

        input[type="password"] { 
          text-indent: 2em;
          font-size:1.9em;
          padding:0.2em 0;
          width:100%;
        }  
        			 */

	.bi {
		position: absolute;
		left: 375px;
		top: 73.5%;
		transform: translateY(-50%);
		font-size: 2em;
		color: red;
	}

	/* splash screen */

	.back-link a {
		color: #4ca340;
		text-decoration: none; 
		border-bottom: 1px #4ca340 solid;
	}
	.back-link a:hover,
	.back-link a:focus {
		color: #408536; 
		text-decoration: none;
		border-bottom: 1px #408536 solid;
	}
	.entry-header {
		text-align: left;
		/* margin: 0 auto 50px auto; */
		width: 80%;
        max-width: 978px;
		position: relative;
		z-index: 10001;
	}
	/* #demo-content {
		padding-top: 100px;
	} */
</style>

<body>

	<body class="demo">

		<div id="demo-content">

			<header class="entry-header">


			</header>

			<div id="loader-wrapper">
				<div id="loader"></div>
				<div class="loader-section section-left"></div>
				<div class="loader-section section-right"></div>
			</div>

			<div class="mdl-layout mdl-js-layout color--gray is-small-screen login">
				<main class="mdl-layout__content">
					<div class="mdl-card mdl-card__login mdl-shadow--2dp">
						<div class="mdl-card__supporting-text color--dark-gray">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--11-col mdl-cell--9-col-phone">
									<!-- <span class="mdl-card__title-text text-color--smooth-gray">SIGNIN</span> -->
									<center>
										<img src="../dist/images/cct-logos.png" height="150" width="150" alt="50">
									</center>
								</div>
								<div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
									<!-- <span class="login-name text-color--white">Sign in</span>
							<span class="login-secondary-text text-color--smoke">Enter fields to sign in to DARKBOARD</span> -->
								</div>
								<div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
									<form autocomplete="off" id="login-form">
										<div class="form-group">
											<label for="username" class="control-label">Username</label>
											<input type="text" role="presentation" class="required-valid mdl-textfield__input" autocomplete="off" id="username" name="username" class="form-control">
										</div>
										<div class="form-group">
											<label for="password" class="control-label">Password</label>
											<input type="password" class="required-valid mdl-textfield__input" autocomplete="off" id="password" name="password" class="form-control">
											<!-- <a href="" class="material-icons md-18" onclick="myFunction()">visibility</a> -->
											<i class="bi bi-eye-slash" id="togglePassword"></i>
										</div>
										<br>
										<button class="btn btn-primary btn-block" id="submit_btn" disabled style="float: right;">Login</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
			window.jQuery || document.write('<script src="../admin/assets/css/js-splash/vendor/jquery-1.9.1.min.js"><\/script>')
		</script>
		<script src="../admin/assets/css/js-splash/main.js"></script>

	</body>

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<script>
	const togglePassword = document.querySelector("#togglePassword");
	const password = document.querySelector("#password");

	togglePassword.addEventListener("click", function() {
		// toggle the type attribute
		const type = password.getAttribute("type") === "password" ? "text" : "password";
		password.setAttribute("type", type);

		// toggle the icon
		this.classList.toggle("bi-eye");
	});

	// prevent form submit
	const form = document.querySelector("form");
	form.addEventListener('submit', function(e) {
		e.preventDefault();
	});
</script>

<script>
	$('form .required-valid').on('input paste change', function() {
		var $required = $('form .required-valid');

		//filter required inputs to only ones that have a value.
		var $valid = $required.filter(function() {
			return this.value != '';
		});

		//set disabled prop to false if valid input count is != required input count
		$('#submit_btn').prop('disabled', $valid.length != $required.length);

	})
</script>

<script>
	$('#login-form').submit(function(e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=dashboard';
				} else if (resp == 0) {
					$('#login-form').prepend('<div class="alert alert-danger">Your account has been archived</div>')
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username/password is incorrect or <br>Your account has been archived!</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>

</html>


<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="assets/font-awesome/css/all.min.css">

<!-- Vendor CSS Files -->
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="assets/vendor/owl.carousel/admin/assets/owl.carousel.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="assets/DataTables/datatables.min.css" rel="stylesheet">
<link href="assets/css/jquery.datetimepicker.min.css" rel="stylesheet">
<link href="assets/css/select2.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="assets/css/jquery-te-1.4.0.css">

<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/DataTables/datatables.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/venobox/venobox.min.js"></script>
<script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="assets/vendor/counterup/counterup.min.js"></script>
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="assets/js/select2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="assets/font-awesome/js/all.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>

<?php
include 'include-admin/script.php';
?>