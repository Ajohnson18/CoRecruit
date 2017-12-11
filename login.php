<?php

require("php/config.php");
include("php/encrypt.php");

if(isset($_POST['submit'])) {
	//GET VARIABLES
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//CHECK IF ALL FORMS ARE COMPLETED
	if(trim($username) != "") {
		if(trim($password) != "") {
			
			$sql = "SELECT * FROM users WHERE username=\"$username\"";
			$res = mysql_query($sql,$dbh);
			
			if($res != FALSE) {
				if(mysql_num_rows($res)>0) {
					
					$usersel = mysql_fetch_array($res);
					
					if(encrypt_decrypt($usersel['password'], 'decrypt') == $password) {
							
							setcookie("userid", $usersel['id'], time() + 60 * 60 * 24 * 7, '/', NULL, NULL, FALSE);
							
							$cstrong = True;
							$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
							
							$userid = $usersel['id'];
							
							$insertsql = "INSERT INTO login_tokens VALUES ('', '$userid', '$token')";
							$insertres = mysql_query($insertsql,$dbh);
																				
							setcookie("SNIDCo", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, FALSE);
							setcookie("SNID_", '1', time() + 60 * 60 * 24 * 7, '/', NULL, NULL, FALSE);
										
							header('Location: index.php');
							exit;
													
					} else {
						echo '<script>alert("Login or Password Invalid!")</script>';
					}
					
				} else {
					echo '<script>alert("Login or Password Invalid!")</script>';
				}
				
			} else {
				echo '<script>alert("Login or Password Invalid!")</script>';
			}
			
		} else {
			echo '<script>alert("Please fill out all forms!")</script>';
		}
	} else {
		echo '<script>alert("Please fill out all forms!")</script>';
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Arvo|Nunito|Quicksand|Righteous|Sansita" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> 
	<title>| CoRecruit |</title>	
</head> 
	<body style="background: url('img/baseballbackground.jpg') no-repeat center center fixed; background-size: cover;">
		<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse" style="background-color: transparent">
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">CoRecruit</a>
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="contact.php">Contact</a>
			  </li>
			</ul>
		</nav>
		<header>
			<section id="login-body" style="margin-top: -5px;">
			<br>
			<br>
            <form class="form-inline" id="login-form" action="" method="post">
				<i class="fa fa-lock fa-5x" aria-hidden="true" style="margin:0 auto;"></i>
				<h1 class="display-3" style="width: 100%; margin-bottom: 50px;">Login</h1>
				<div class="alert alert-danger" role="alert" id="fail" style="display: none; margin-top: 10px; width: 100%;">
					<strong>Oh snap!</strong> Make sure you fill out all the forms. The username and password is case sensitive.
				</div>
                <div class="form-group" id="usernamegroup" style="width: 100%;">
					<label for="username"></label>
					<input type="text" name="username" id="username" class="form-control form-control-danger form-control-success login" placeholder="Username" style="width: 100%;">
					<div class="form-control-feedback" id="bottomlabelusername"></div>
				</div>
				<br>
				<div class="form-group" id="passwordgroup" style="width: 100%; margin-top: 15px;">
					<label for="password"></label>
					<input type="password" id="password" name="password" class="form-control form-control-danger form-control-success login" placeholder="Password" style="width: 100%;">
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
				</div>
				<br>
				<button type="submit" name="submit" class="btn btn-danger btn-lg btn-block"  style="margin: 20px auto;">Submit</button>
				<p class="lead-text" style="margin-bottom: -50px;">Don't have an account? Click <a href="signup.php">HERE</a> to create one!</p>
            </form>
        </section>
		</header>
		<script>
			$(document).ready(function() {

				<?php 
					$output = "";
					$passwordo = "";
					$sql = "SELECT * FROM users";
					$res = mysql_query($sql,$dbh);
						
					while($row = mysql_fetch_array($res)) {
						$output .= $row['username'] . ", ";
					}

					?>

				var usernames = "<?php echo $output; ?>";
					
				$("#username").keyup(function() {
						var index = usernames.indexOf(($("#username").val() + ","));
						if(index != -1) {
							$("#usernamegroup").removeClass("has-danger");
							$("#usernamegroup").addClass("has-success");
						} else {
							$("#usernamegroup").addClass("has-danger");
							$("#usernamegroup").removeClass("has-success");
						}

						if($("#username").val() == "") {
							$("#usernamegroup").removeClass("has-danger");
							$("#usernamegroup").removeClass("has-success");
						}
				});

				$("#password").keyup(function() {
					if($("#password").val().length > 5) {
						$("#passwordgroup").removeClass("has-danger");
						$("#passwordgroup").addClass("has-success");
					} else {
						$("#passwordgroup").addClass("has-danger");
						$("#passwordgroup").removeClass("has-success");
					}

					if($("#password").val() == "") {
						$("#passwordgroup").removeClass("has-danger");
						$("#passwordgroup").removeClass("has-success");
					}
				});
			});
		</script>
	</body>
</html>