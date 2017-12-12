<?php
require("php/config.php");  

if(isset($_POST['deletefav'])) {
    $uid = $_GET['userid'];
    $cid = $_COOKIE['userid'];

    $sql = "DELETE FROM favorites WHERE userid = $uid AND coachid = $cid";
    $res = mysql_query($sql, $dbh);
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
		
	<title>Favorites</title>
</head>
<body>
<?php include('php/setNav.php'); ?>
 
    <main role="main">

        <div style="margin: 50px auto; width: 700px;">
        <hr>
        <center>
        <h1 class="display-3">Favorites</h1>
        </center>
        <hr>
        <?php

            $uid = $_COOKIE['userid'];    

            $sql = "SELECT * FROM favorites WHERE coachid = $uid";
            $res = mysql_query($sql, $dbh);

            if($res != FALSE) {
                while($row = mysql_fetch_array($res)) {

                    $sql2 = "SELECT * FROM users WHERE id = ".$row['userid']."";
                    $res2 = mysql_query($sql2, $dbh);
                    $user = mysql_fetch_array($res2);

                    echo "<div class=\"card\">
                    <div class=\"card-header\">
                        ".$user['first_name']." ".$user['last_name']."
                    </div>
                    <div class=\"card-block\">
                    <div class=\"row\">
                        <div class=\"col\">
                            <img src=\"upload/".$user['profileimg']."\" style=\"width: 100px; height: 100px; border-radius: 100%; margin: 10% auto;\">
                        </div>
                        <div class=\"col-9\">
                        <h4 class=\"card-title\">".$user['first_name']." ".$user['last_name']."</h4>
                        <p class=\"card-text\"><b>Email:</b> ".$user['email']."  |  <b>Gender:</b> ".$user['gender']."  |  <b>Location:</b> ".$user['city']." ".$user['state']."</p>
                        <a style=\"float: left; width: 150px; margin-right: 30px; margin-bottom: 10px;\" href=\"students.php?value=".$user['first_name']." ".$user['last_name']." (".$user['state'].")\" class=\"btn btn-primary\">Go To Profile</a>
                        <form action=\"favorites.php?userid=".$user['id']."\" method=\"post\"><button style=\"width: 150px;\" type=\"submit\" class=\"btn btn-danger\" name=\"deletefav\">Un-Favorite</button></form>
                        </div>
                    </div>
                    </div>
                    </div><br>";
                }
            }
        ?>

        </div>

        <hr>
        <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
      </footer>
    </main>
<script>
  $(document).ready(function() {
    $("#favoritesli").addClass("active");
  });
</script>      
</body>

</html>