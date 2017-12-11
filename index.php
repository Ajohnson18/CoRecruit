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
	<title>CoRecruit</title>	
</head> 
	<body>
		<?php include('php/setNav.php'); ?>
		<main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="img/baseballhome.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
              <?php

              if(isset($_COOKIE['userid'])) {
                if(isset($_COOKIE['SNIDCo'])) {
                  $uid = $_COOKIE['userid'];
                  $sql = "SELECT * FROM users WHERE id = $uid";
                  $res = mysql_query($sql, $dbh);
                  $user = mysql_fetch_array($res);
                    
                  if($user['coach'] == 0 && $user['admin'] == 0) {
                     echo '<h1>Connect With Coaches.</h1>
                     <p>CoRecruit allows coaches to look at your sports profile so they can quickly recruit you the minute you step foot on campus. CoRecruit will keep you notified on any changes in your sport profiles and coaches in contact with you.</p>
                     <p><a class="btn btn-lg btn-primary" href="colleges.php" role="button">Go to Colleges</a></p>'; 
                  } else if($user['coach'] == 1) {
                    echo '<h1>Connect With Students.</h1>
                    <p>Take a look at all the potential athletes that you can have at your school. Make sure you reach out to the students and communicate with them by liking their profile!</p>
                    <p><a class="btn btn-lg btn-primary" href="students.php" role="button">Go to Students</a></p>';
                  }
                } else {
                  echo '<h1>Login To Your Account.</h1>
                  <p>Go and login to your account so you can continue your athletic career and communicate with coaches. Build up your profile so you can get noticed by your coaches!</p>
                  <p><a class="btn btn-lg btn-primary" href="login.php" role="button">Go to Login</a></p>';
                }
              } else {
                echo '<h1>Login To Your Account.</h1>
                <p>Go and login to your account so you can continue your athletic career and communicate with coaches. Build up your profile so you can get noticed by your coaches!</p>
                <p><a class="btn btn-lg btn-primary" href="login.php" role="button">Go to Login</a></p>';
              }

              ?>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="img/footballhome.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
              <?php

              if(isset($_COOKIE['userid'])) {
                if(isset($_COOKIE['SNIDCo'])) {
                  $uid = $_COOKIE['userid'];
                  $sql = "SELECT * FROM users WHERE id = $uid";
                  $res = mysql_query($sql, $dbh);
                  $user = mysql_fetch_array($res);
                    
                  if($user['coach'] == 0 && $user['admin'] == 0) {
                     echo '<h1>Build Your Profile.</h1>
                     <p>Show off your skills by building your sports profile. Add a new profile for each of your sports so coaches can see your talent. Don\'t forget to upload photos and videos of yourself playing!</p>
                     <p><a class="btn btn-lg btn-primary" href="profile.php" role="button">Go to Profile</a></p>'; 
                  } else if($user['coach'] == 1) {
                    echo '<h1>Build Your Profile.</h1>
                    <p>As a coach you can edit your profile by favoriting students and creating your messages to send to students.</p>
                    <p><a class="btn btn-lg btn-primary" href="cprofile.php" role="button">Go to Profile</a></p>';
                  }
                } else {
                  echo '<h1>Create an Account.</h1>
                  <p>Don\'t have an account!? Go and create one today so you can begin building your profile and show coaches what you get. Just enter in some information and you can get started in less then five minutes.</p>
                  <p><a class="btn btn-lg btn-primary" href="signup.php" role="button">Create an Account</a></p>';
                }
              } else {
                echo '<h1>Create an Account.</h1>
                <p>Don\'t have an account!? Go and create one today so you can begin building your profile and show coaches what you get. Just enter in some information and you can get started in less then five minutes.</p>
                <p><a class="btn btn-lg btn-primary" href="signup.php" role="button">Create an Account</a></p>';
              }

              ?>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="img/home3.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <?php

                  if(isset($_COOKIE['userid'])) {
                    if(isset($_COOKIE['SNIDCo'])) {
                      $uid = $_COOKIE['userid'];
                      $sql = "SELECT * FROM users WHERE id = $uid";
                      $res = mysql_query($sql, $dbh);
                      $user = mysql_fetch_array($res);
                        
                      if($user['coach'] == 0 && $user['admin'] == 0) {
                        echo '<h1>Check your Notifications.</h1>
                        <p>Notifications allows you to see when coaches want to contact you. This is very different then other recruiting sites because it adds a more intimate connection between the student and the coach before the season even starts.</p>
                        <p><a class="btn btn-lg btn-primary" href="notifications.php" role="button">Go to Notifications</a></p>'; 
                      } else if($user['coach'] == 1) {
                        echo '<h1>Contact Us.</h1>
                        <p>Are you a coach looking to add your college to our list? Do you have any questions, comments, or concerned with our app? Just let us know through the contact page.</p>
                        <p><a class="btn btn-lg btn-primary" href="contact.php" role="button">Contact Us</a></p>';
                      }
                    } else {
                      echo '<h1>Contact Us.</h1>
                      <p>Are you a coach looking to add your college to our list? Do you have any questions, comments, or concerned with our app? Just let us know through the contact page.</p>
                      <p><a class="btn btn-lg btn-primary" href="contact.php" role="button">Contact Us</a></p>';
                    }
                  } else {
                    echo '<h1>Contact Us.</h1>
                    <p>Are you a coach looking to add your college to our list? Do you have any questions, comments, or concerned with our app? Just let us know through the contact page.</p>
                    <p><a class="btn btn-lg btn-primary" href="contact.php" role="button">Contact Us</a></p>';
                  }

                  ?>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      <div class="container marketing" style="margin-top:15px"> 

      <hr class="featurette-divider">

      <div class="row featurette" style="margin-top: -80px;">
        <div class="col-md-7">
          <h2 class="featurette-heading">Helping Coaches<span class="text-muted"></span></h2>
          
          <p class="lead"> Coaches can view a variety of different athletes that they can recruit for their teams. Coaches can find out what athletes are interested in playing sports and which community college they plan on attending. It will now be easier for coaches to recruit.</p>
        </div>
        <div class="col-md-5">
		<center>
          <img src="img/baseball.jpg" style="width: 20vw; height: 20vw; margin: 30px auto -20px auto; border-radius: 100%;">
		</center>  
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 push-md-5">
          <h2 class="featurette-heading">Helping Athletes <span class="text-muted"> </span></h2>
          <p class="lead"> Athletes can easily sign up and fill out information about what sport they want to play and where. If your going to community college it can be easier for athletes to join sports teams.</p>
        </div>
        <div class="col-md-5 pull-md-7">
           <img src="img/soccer.jpg" style="width: 20vw; height: 20vw; margin: 30px auto -20px auto; border-radius: 100%;">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Helping Everybody <span class="text-muted"></span></h2>
          <p class="lead"> CoRecruit is easy to use and makes recruiting better. Coaches can find athletes for their teams. Athletes can find the teams they want to join. CoRecruit makes recruiting for community college faster and more efficient.</p>
        </div>
        <div class="col-md-5">
          <img src="img/hockey2.jpg" style="width: 20vw; height: 20vw; margin: 30px auto -20px auto; border-radius: 100%;">
        </div>
      </div>
      <hr class="featurette-divider">
    </div>

    <center><h1 class="display-3">Developers</h1></center>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->
		<div class="row" style="width: 90vw; margin: 0 auto;">
        <div class="col-lg-4">
          <img class="rounded-circle" src="img/alex.jpg" alt="Generic placeholder image" width="140" height="140">
          <br>
		  <h2>Master</h2>
		  <h3>Alex Johnson</h3>
          <p>Holds the rank of master in the computer science department. Can use his level 5 fireballs to write 15 words per minute... a world record. Is a big fan of cats and the annexation of Texas.</p>
		</div><!-- /.col-lg-4 -->
		<br>
        <div class="col-lg-4">
          <img class="rounded-circle" src="img/jake.PNG" alt="Generic placeholder image" width="140" height="140">
          <br>
		  <h2>HTML Wizard</h2>
		   <h3>Jake Toner</h3>
          <p>A hired professional at creating about pages for websites. Sadly there is no about page for this website so he is being paid for doing nothing.</p>
		</div><!-- /.col-lg-4 -->
		<br>
		<div class="col-lg-4">
          <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <br>
		  <h2>Clown</h2>
		   <h3>Scrappy Doo</h3>
          <p>Was assigned fifteen different tasks throughout this project, yet has failed to complete a single one. A true inspiration for all trying to accomplish their dreams and live a fuller life.</p>
		</div><!-- /.col-lg-4 -->
		<br>
		<div class="col-lg-4">
          <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <br>
		  <h2>True Creative Genius</h2>
		   <h3>Erin Cox</h3>
          <p>The most female member of the team. Was crucial in the creation of our outstanding logo and is an artist at mind and heart... we have no logo.</p>
		</div><!-- /.col-lg-4 -->
		<br>
      </div>
	  

      </div><!-- /.container -->
	 
 <hr class="featurette-divider">

      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
      </footer>

    </main>
    <script>
  $(document).ready(function() {
    $("#indexli").addClass("active");
  });
</script> 
	</body>
	
	
</html>