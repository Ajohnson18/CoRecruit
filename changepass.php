<?php

require("php/config.php");
include("php/encrypt.php");
	

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
	<title>Change Password</title>	
</head> 
	<body style="background: #f9f9f9;">
        <?php include('php/setNav.php');
        include('php/checkLogin.php'); ?>
		<header>
			<section style="margin-top: -5px;">
			<br>
			<br>
            <form class="form-inline" id="login-form" action="" method="post">
				<i class="fa fa-lock fa-5x" aria-hidden="true" style="margin:0 auto;"></i>
				<h1 class="display-3" style="width: 100%; margin-bottom: 50px;">Change Password</h1>
				<div class="alert alert-danger" role="alert" id="fail" style="display: none; margin-top: 10px; width: 100%;">
					<strong>Oh snap!</strong> Your current password is incorrect!
				</div>
                <div class="alert alert-danger" role="alert" id="fail2" style="display: none; margin-top: 10px; width: 100%;">
					<strong>Oh snap!</strong> Your passwords do not match!
				</div>
                <div class="form-group" id="current" style="width: 100%;">
					<label for="current"></label>
					<input type="password" name="current" id="current" class="form-control form-control-danger form-control-success" placeholder="Current Password" style="width: 100%;" required>
					<div class="form-control-feedback" id="bottomlabelusername"></div>
				</div>
				<br>
				<div class="form-group" id="passwordgroup" style="width: 100%; margin-top: 15px;">
					<label for="password"></label>
					<input type="password" pattern=".{5,}" id="password" name="password" class="form-control form-control-danger form-control-success" placeholder="New Password" style="width: 100%;" required>
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
				</div>
				<br>
                <div class="form-group" id="passwordgroup" style="width: 100%; margin-top: 15px;">
					<label for="rpassword"></label>
					<input type="password" id="rpassword" name="rpassword" class="form-control form-control-danger form-control-success" placeholder="Repeat-Password" style="width: 100%;" required>
					<div class="form-control-feedback" id="bottomlabelpassword"></div>
				</div>
                <br>
				<button type="submit" name="submit" class="btn btn-danger btn-lg btn-block"  style="margin: 20px auto;">Save</button>
                <?php

                    if(isset($_POST['submit'])) {
                        $oldpass = $_POST['current'];
                        $newpass = $_POST['password'];
                        $repeat = $_POST['rpassword'];
                        $uid = $_COOKIE['userid'];

                        $sql = "SELECT * FROM users WHERE id = $uid";
                        $res = mysql_query($sql, $dbh);
                        $user = mysql_fetch_array($res);

                        $unhashpass = encrypt_decrypt($user['password'], 'decrypt');

                        if($unhashpass == $oldpass) {
                            if($newpass == $repeat) {

                                $newpass = encrypt_decrypt($newpass, 'encrypt');
                                
                                $sql = "UPDATE users SET password = \"$newpass\" WHERE id = $uid";
                                $res = mysql_query($sql, $dbh);

                                header("Location: index.php");
                                exit;

                            } else {
                                echo "<script>$('#fail2').css('display', 'block');</script>"; 
                            }
                        } else {
                            echo "<script>$('#fail').css('display', 'block');</script>";
                        }
                    }

                ?>
            </form>
        </section>
		</header>
	</body>
</html>