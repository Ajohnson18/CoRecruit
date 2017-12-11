<?php
require("php/config.php");
?>
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
		<title> About Page </title>
</head>
<body>
	<?php include('php/setNav.php'); ?>
	<section class="jumbotron text-center" style="background-color: #10d7e5; color: #161616;">
		<div class="container">
			<h1 class="jumbotron-heading" style="margin-top:75px;" >About Us...</h1>
			<p class="lead text-muted"> We are Alex Johnson, Erin Cox, Jake Toner and Jacob Rappaport. We made CoRecruit to help community colleges recruit athletes. Athletes that plan on going to community college can sign up and pick their school and coaches can easily recruit people for sports teams.</p>
		</div>
	</section>
    <div class="container marketing" style="margin-top:15px"> 

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Helping Coaches<span class="text-muted"></span></h2>
          
          <p class="lead"> Coaches can view a variety of different athletes that they can recruit for their teams. Coaches can find out what athletes are interested in playing sports and which community college they plan on attending. It will now be easier for coaches to recruit.</p>
        </div>
        <div class="col-md-5">
          
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 push-md-5">
          <h2 class="featurette-heading">Helping Athletes <span class="text-muted"> </span></h2>
          <p class="lead"> Athletes can easily sign up and fill out information about what sport they want to play and where. If your going to community college it can be easier for athletes to join sports teams.</p>
        </div>
        <div class="col-md-5 pull-md-7">
          
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Helping Everybody <span class="text-muted"></span></h2>
          <p class="lead"> CoRecruit is easy to use and makes recruiting better. Coaches can find athletes for their teams. Athletes can find the teams they want to join. CoRecruit makes recruiting for community college faster and more efficient.</p>
        </div>
        <div class="col-md-5">
          
        </div>
      </div>
      <hr class="featurette-divider">
    </div>
    <hr class="featurette-divider">
    <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
  </footer>
		<script>
			$('#aboutli').addClass('active');
		</script>
</body>
</html>