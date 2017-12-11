<?php
require("php/config.php");

if(isset($_POST['delete'])) {
	setcookie("SNIDCo", "1", time() - 3600, "/");
	setcookie("SNID_", "1", time() - 3600, "/");
	setcookie("userid", "1", time() - 3600, "/");
	
	$userid = $_COOKIE['userid'];
	
	$sql = "DELETE FROM login_tokens WHERE userid = $userid";
	$res = mysql_query($sql,$dbh);
	
	header("Location: index.php");
}

if(isset($_POST['sendmessage'])) {
  $text = $_POST['message'];
  $name = $_POST['name'];
  $email = $_POST['email'];

  $text = str_replace("\n.", "\n..", $text);

  $message = "'
              <html>
                <body>
                  <center>
                  <h1>$name</h1>
                  <br>
                  <h4>$email</h4>
                  <br>
                  <p>$text</p>
                </body>
              </html>
              ";

  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';            

  $mail = mail("ajohnso18@gmail.com", "CoRecruit Contact", $message, implode("\r\n", $headers));

  if($mail) {
    echo '<script>alert("Message Sent!")</script>';
  } else {
    echo '<script>alert("Message Failed!")</script>';
  }
}

if(isset($_POST['sendbuy'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];

  $message = "'
              <html>
                <body>
                  <center>
                  <h1>$name</h1>
                  <br>
                  <h4>$email</h4>
                  <br>
                  <p>This is a message saying that $name wants to purchase your app. Go Alex!</p>
                </body>
              </html>
              ";

  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';            

  $mail = mail("ajohnso18@gmail.com", "CORECRUIT PURCHASE", $message, implode("\r\n", $headers));

  if($mail) {
    echo '<script>alert("Message Sent!")</script>';
  } else {
    echo '<script>alert("Message Failed!")</script>';
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
		<link rel="stylesheet" href="css/carousal.css">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Arvo|Nunito|Quicksand|Righteous|Sansita" rel="stylesheet">
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> 
		
	<title>Contact</title>
</head>
<body>
<?php include('php/setNav.php'); ?>
 
<main role="main">

        <div class="jumbotron">
          <h1 class="display-3">Contact Us</h1>
          <p class="lead">Please feel free to contact us with any questions, comments, or concerns. We love to hear your feedback whether it is positive or negative. Any emails will be responded to asap.<br>If you are a coach or school looking to use this application please look below.</p>
        </div>

        <div class="row marketing">
          <div class="col-lg-6" style="padding: 0px 50px;">
          <center>
            <h4><strong>Email:</strong> </h4>
            <p>info@corecruit.com</p>
          <hr>
            <h1 class="display-4">Quick Message</h1>
            <form action="" method="post">
            <div class="form-group" id="usernamegroup" style="width: 100%; margin-bottom: -15px;">
              <label for="name"></label>
              <input type="text" name="name" id="name" class="form-control form-control-danger form-control-success" placeholder="Full Name" style="width: 100%;" required>
              <div class="form-control-feedback" id="bottomlabelusername"></div>
            </div>
            <div class="form-group" id="email" style="width: 100%;">
              <label for="email"></label>
              <input type="email" name="email" id="email" class="form-control form-control-danger form-control-success" placeholder="Email" style="width: 100%;">
              <div class="form-control-feedback" id="bottomlabelusername"></div>
            </div>
            <div class="form-group" style="width: 100%;">
							<textarea class="form-control" name="message" id="message" rows="3" placeholder="Message" style="width: 100%;" required></textarea>
						</div>
            <button type="submit" name="sendmessage" class="btn btn-danger btn-lg"  style="margin: 20px auto;">Send</button>
            </form>  
          </center>  
          </div>

          <div class="col-lg-6" style="padding: 0 50px;"><center>
          <hr>
            <h1 class="display-4">Purchase This App</h1>
            <p class="lead">If you want to purchase this application and use it for your school please fill out the form down below. We will be in contact with you very shortly.</p>
            <form action="" method="post">
            <div class="form-group" id="usernamegroup" style="width: 100%; margin-bottom: -15px;">
              <label for="name"></label>
              <input type="text" name="name" id="name" class="form-control form-control-danger form-control-success" placeholder="Full Name" style="width: 100%;" required>
              <div class="form-control-feedback" id="bottomlabelusername"></div>
            </div>
            <div class="form-group" id="email" style="width: 100%;">
              <label for="email"></label>
              <input type="email" name="email" id="email" class="form-control form-control-danger form-control-success" placeholder="Email" style="width: 100%;">
              <div class="form-control-feedback" id="bottomlabelusername"></div>
            </div>
            <button type="submit" name="sendbuy" class="btn btn-danger btn-lg"  style="margin: 20px auto;">Send</button>
            </form>
            </center>
          </div>  
        </div>
        <hr>
        <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
      </footer>
      </main>
<script>
  $(document).ready(function() {
    $("#contactli").addClass("active");
  });
</script>      
</body>

</html>