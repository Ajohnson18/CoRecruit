<?php

require("php/config.php");
include("php/encrypt.php");
require("php/safe.php");


if(isset($_POST['submit'])) {
	//GET VARIABLES
	$username = $_POST['username'];
    $email = $_POST['email'];
    $zipcode = $_POST['zipcode'];

	$username = safe($username);
    $email = safe($email);
    
    $sql = "SELECT * FROM users WHERE username = \"$username\" AND email = \"$email\" AND zipcode = \"$zipcode\"";
    $res = mysql_query($sql, $dbh);

    if($res != FALSE) {
        if(mysql_num_rows($res) > 0) {
            
            $user = mysql_fetch_array($res);
            
            $length = 10;

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, $charactersLength - 1)];
            }

            $passwordhex = encrypt_decrypt($password, 'encrypt');

            $sql = "UPDATE users SET password = \"$passwordhex\" WHERE email = \"$email\" AND username = \"$username\" AND zipcode = \"$zipcode\"";
            $res = mysql_query($sql, $dbh);

            if($res != FALSE) {
                $message = "
                <html>
                    <body>
                      <center>
                      <h1>$name</h1>
                      </center>
                      <p>Hello ".$user['first_name']."!<br>Here is your new password!<br><strong>Password:</strong> $password<br>Remember... it's always helpful to write down your passwords somewhere. Make sure you change your password when you log in!</p>
                    </body>
                  </html>
                  ";
    
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';            
                    
                    $mail = mail($user['email'], "CoRecruit - New Password", $message, implode("\r\n", $headers));
                    
                    if($mail) {
                        echo '<script>alert("Message Sent!")</script>';
                        header("Location: index.php");
                        exit;
                    } else {
                        echo '<script>alert("Message Failed!")</script>';
                    }
            } else {
                echo "<script>alert('There was an error. Please try again later!')</script>";
            }
        } else {
            echo "<script>alert('Sorry... we couldn\'t find an account with those credentials.')</script>";
        }
    } else {
        echo "<script>alert('Sorry... we couldn\'t find an account with those credentials.')</script>";
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
				<h1 class="display-3" style="width: 100%; margin-bottom: 50px;">Forgot Password</h1>
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
					<label for="email"></label>
					<input type="email" id="email" name="email" class="form-control form-control-danger form-control-success login" placeholder="Email" style="width: 100%;">
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
				</div>
                <br>
                <div class="form-group" id="passwordgroup" style="width: 100%; margin-top: 15px;">
					<label for="zipcode"></label>
					<input type="text" id="zipcode" name="zipcode" class="form-control form-control-danger form-control-success login" placeholder="Zipcode" style="width: 100%;">
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
                </div>
                <br>
                <button type="submit" name="submit" class="btn btn-danger btn-lg btn-block"  style="margin: 20px auto;">Submit</button>
                <p class="lead-text">After you click submit, an email will be sent to you with your new password!</p>
            </form>
        </section>
		</header>
	</body>
</html>