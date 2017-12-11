<?php

require("php/config.php");
include("php/encrypt.php");

if(isset($_POST['create'])) {
	//GET VARIABLES
	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$sex = $_POST['sex'];
	$zipcode = $_POST['zipcode'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];

	//CHECK IF ALL FORMS ARE COMPLETED
	if(trim($state) != "--------------") {
		if(trim($sex) != "--------------") {
			if(strlen($zipcode) == 5) {
				if(strlen($username) > 5) {
					if(strlen($username) > 5) {
						if($password == $repassword) {
							
							$passworden = encrypt_decrypt($password, 'encrypt');
							
							$sql = "INSERT INTO users VALUES (\"\", \"$username\", \"$passworden\", \"$email\", \"$first\", \"$last\", \"$sex\", \"$zipcode\", \"$city\", \"$state\", \"default.jpeg\", \"\", 0, 0)";
							$res = mysql_query($sql,$dbh);

							if($res != FALSE) {

								$sql2 = "SELECT id FROM users WHERE username = \"$username\"";
								$res2 = mysql_query($sql2,$dbh);
								
								$usersel = mysql_fetch_array($res2);
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
								echo '<script>alert("Sorry something went wrong! Please try again later.")</script>';
							}

						} else {
							echo '<script>alert("Please make sure your passwords match!")</script>';
						}
					} else {
						echo '<script>alert("Please make sure your password is atleast 6 characters!")</script>';
					}
				} else {
					echo '<script>alert("Please make sure your username is atleast 6 characters!")</script>';
				}
			} else {
				echo '<script>alert("Please fill out \"ZIPCODE\" form correctly!")</script>';
			}
		} else {
			echo '<script>alert("Please fill out \"SEX\" form!")</script>';
		}
	} else {
		echo '<script>alert("Please fill out \"STATE\" form!")</script>';
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
	<body>
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
            <form class="form-inline" id="login-form" action="" method="post" style="width: 700px; text-align: center;">
				<i class="fa fa-id-card fa-5x" aria-hidden="true" style="margin: 0 auto;"></i>
				<h1 class="display-3" style="width: 100%; margin-bottom: 50px;">Create Account</h1>
				<div class="alert alert-danger" role="alert" id="fail" style="display: none; margin-top: 10px; width: 100%;">
					<strong>Oh snap!</strong> Make sure you fill out all the forms. The username and password is case sensitive.
				</div>
				<div class="form-group"  style="width: 100%; margin-top: 15px;">
					<label for="first">First Name</label>
					<input type="text" name="first" class="form-control login" placeholder="First Name" style="width: 100%;" required>
				</div>
				<div class="form-group"  style="width: 100%; margin-top: 15px;">
					<label for="last">Last Name</label>
					<input type="text" name="last" class="form-control login" placeholder="Last Name" style="width: 100%;" required>
				</div>
				<div class="form-group"  style="width: 100%; margin-top: 15px;">
					<label for="last">Email</label>
					<input type="email" name="email" class="form-control login" placeholder="Email" style="width: 100%;" required>
				</div>
				<div class="form-group" style="width: 100%; margin-top: 15px;">
					<label for="sex" style="">Sex</label>
					<select class="form-control" id="sex" name="sex" style="width: 100%;" required>
					  <option>--------------</option>
					  <option>Male</option>
						<option>Female</option>
					</select>
				  </div>
				  <div class="form-group"  style="width: 100%; margin-top: 15px;">
					<label for="repassword">Zipcode</label>
					<input type="number" name="zipcode" class="form-control login" placeholder="Zipcode" style="width: 100%;" required>
				</div>
				<div class="form-group"  style="width: 100%; margin-top: 15px;">
					<label for="repassword">City</label>
					<input type="text" name="city" class="form-control login" placeholder="City" style="width: 100%;" required>
				</div>
				 <div class="form-group" style="width: 100%; margin-top: 15px;">
					<label for="state" style="">State</label>
					<select class="form-control" id="state" name="state" style="width: 100%;" required>
					<option>--------------</option>
					  <option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
				  </div>
				<div class="form-group" id="usernamegroup" style="width: 100%; margin-top: 15px;">
				  <label for="username">Username</label>
				  <input type="text" name="username" id="username" class="form-control form-control-danger form-control-success login" placeholder="Username" style="width: 100%;">
				  <div class="form-control-feedback" id="bottomlabelusername"></div>
			  	</div>
				<br>
				<div class="form-group" id="passwordgroup" style="width: 100%; margin-top: 15px;">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" class="form-control form-control-danger form-control-success login" placeholder="Password" style="width: 100%;">
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
				</div>
				<div class="form-group" id="repasswordgroup" style="width: 100%; margin-top: 15px;">
					<label for="repassword">Re-Type Password</label>
					<input type="password" id="repass" name="repassword" class="form-control form-control-danger form-control-success login" placeholder="Re-Type Password" style="width: 100%;" required>
					<div class="form-control-feedback" id="bottomlabelrepassword"></div>
				</div>
				<br>
				<button type="submit" name="create" class="btn btn-primary btn-lg btn-block"  style="margin: 20px auto;">Submit</button><center>
				<p class="lead-text" style="margin: 0 auto; margin-bottom: -50px; width: 100%;">Already have an account? Click <a href="login.php">HERE</a> to login in!</p></center>
            </form>
			<br>
			<br>
			<br>
			<br>
        </section>
		</header>
		<script>
			$(document).ready(function() {

				<?php 
					$output = "";
					$sql = "SELECT * FROM users";
					$res = mysql_query($sql,$dbh);
						
					while($row = mysql_fetch_array($res)) {
						$output .= $row['username'] . ", ";
					}

					?>

				var usernames = "<?php echo $output; ?>";
					
				$("#username").keyup(function() {
					console.log($("#username").val());
					if($("#username").val().length < 6) {
						$("#usernamegroup").addClass("has-danger");
						$("#bottomlabelusername").html("Sorry that username is too short!");
					} else {
						var index = usernames.indexOf(($("#username").val() + ","));
						if(index == -1) {
							$("#usernamegroup").removeClass("has-danger");
							$("#bottomlabelusername").html("");
							$("#usernamegroup").addClass("has-success");
						} else {
							$("#usernamegroup").addClass("has-danger");
							$("#usernamegroup").removeClass("has-success");
							$("#bottomlabelusername").html("Sorry that username is taken!");
						}

					}

					if($("#username").val() == "") {
						$("#usernamegroup").removeClass("has-danger");
						$("#usernamegroup").removeClass("has-success");
						$("#bottomlabelusername").html("");
					}
				});

				$("#password").keyup(function() {
					if($("#password").val().length < 6) {
						$("#passwordgroup").addClass("has-danger");
						$("#passwordgroup").removeClass("has-success");
						$("#bottomlabelpassword").html("Sorry that password is too short!");
					} else {
						$("#passwordgroup").removeClass("has-danger");
						$("#bottomlabelpassword").html("");
						$("#passwordgroup").addClass("has-success");
					}

					if($("#password").val() == "") {
						$("#passwordgroup").removeClass("has-danger");
						$("#bottomlabelpassword").html("");
						$("#passwordgroup").removeClass("has-success");
					}
				});

				$("#repass").keyup(function() {
					if($("#password").val() != $("#repass").val()) {
						$("#repasswordgroup").addClass("has-danger");
						$("#repasswordgroup").removeClass("has-success");
						$("#bottomlabelrepassword").html("Sorry that passwords do not match!");
					} else {
						$("#repasswordgroup").removeClass("has-danger");
						$("#bottomlabelrepassword").html("");
						$("#repasswordgroup").addClass("has-success");
					}

					if($("#repass").val() == "") {
						$("#repasswordgroup").removeClass("has-danger");
						$("#bottomlabelrepassword").html("");
						$("#repasswordgroup").removeClass("has-success");
					}
				});
			});
		</script>
	</body>
</html>