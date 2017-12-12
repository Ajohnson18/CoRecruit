<?php
require("php/config.php");

$uid = $_COOKIE['userid'];

if(isset($_POST['submit'])) {
    $college = $_POST['college'];
    $sql = "UPDATE users SET college = \"$college\" WHERE id = $uid";
    $res = mysql_query($sql,$dbh);
}

if(isset($_POST['favorite'])) {
	$uid = $_GET['userid'];
	$cid = $_COOKIE['userid'];
	$sql = "INSERT INTO favorites VALUES (\"\", $cid, $uid)";
	$res = mysql_query($sql, $dbh);
}

if(isset($_POST['unfavorite'])) {
	$uid = $_GET['userid'];
	$cid = $_COOKIE['userid'];
	$sql = "DELETE FROM favorites WHERE userid = $uid AND coachid = $cid";
	$res = mysql_query($sql, $dbh);
}

if(isset($_POST['sendmessage'])) {
	$email = $_GET['email'];
	$name = $_POST['name'];
	$coachemail = $_POST['email'];
	$message = $_POST['message'];

	$message = str_replace("\n.", "\n..", $message);
	
	  $output = "'
				  <html>
					<body>
					  <p><b>Name</b>: $name</p>
					  <br>
					  <p><b>Coach's Email</b>: $coachemail</p>
					  <br>
					  <p><b>Message</b>: $message</p>
					</body>
				  </html>
				  ";
	
	  $headers[] = 'MIME-Version: 1.0';
	  $headers[] = 'Content-type: text/html; charset=iso-8859-1';            
	
	  $mail = mail($email, $name, $output, implode("\r\n", $headers));

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
        <script src="node_modules/easy-autocomplete/dist/jquery.easy-autocomplete.min.js"></script>    
		<link rel="stylesheet" href="node_modules/easy-autocomplete/dist/easy-autocomplete.min.css"> 
    <title>CoRecruit</title>	
</head> 
	<body>
        <?php include('php/setNav.php');
            include('php/checkLogin.php'); ?>
		<section id="index-body" style="text-align: center;">
            <?php

            $sql = "SELECT * FROM users WHERE id = $uid";
            $res = mysql_query($sql,$dbh);

            if($res != FALSE) {
                $user = mysql_fetch_array($res);
                if($user['college'] == "") {
                    echo 
                    '
                    <center>
                    <img src="img/college.jpg" width="30%" style="border-radius: 100%; margin-top: 100px;">
                    <h1 class="display-3" style="margin-top: 20px;">Choose your college!</h1>
                    <br>
                    <form action="" method="post">
                        <input type="text" id="search-college" name="college" class="form-control" aria-describedby="college" placeholder="Enter College" style="width: 500px;">
                        <br>
                        <button type="submit" class="btn btn-outline-warning" name="submit">Choose This College!</button>
                    </form>
                    </center>
                    ';
                } else {
					
					$college = $user['college'];
					$sql2 = "SELECT * FROM users WHERE college = \"$college\"";
					$res2 = mysql_query($sql2, $dbh);
					if($res2 != FALSE) {
					
						echo '<div class="form-group select" style="margin: 0 auto; margin-top: 50px; width: 700px;">
								<label for="exampleSelect1">Select Student...</label>
								<select class="form-control select" id="exampleSelect1">';
								
								
								if(isset($_GET['value'])) {
									echo '<option>'.$_GET['value'].'</option>';
								} else {
									echo '<option class="selection" value="'.$_GET['value'].'">----------------</option>';
								}
									
									
								while($row = mysql_fetch_array($res2)) {

									$sql3 = "SELECT * FROM sports WHERE userid = ".$row['id']."";
									$res3 = mysql_query($sql3, $dbh);
									$output = "";
									while($sport = mysql_fetch_array($res3)) {
										$output .= $sport['sport'] . " | ";
									}

									$output = substr($output, 0, strlen($output)-3);

									if($row['coach'] != 1) {							
								  echo '<option>'.$row['first_name'].' '.$row['last_name'].' ('.$row['state'].') ['.$output.']</option>';
									}
								}
								
						echo '	</select>
							  </div>
							  ';
							  
							if(isset($_GET['value'])) {
								
								$string = $_GET['value'];
								$first = substr($string, 0, strpos($string, " "));
								$string = substr($string, strpos($string, " ")+1);
								$last = substr($string, 0, strlen($string)-5);
								$string = substr($string, strpos($string, " ")+1);
								$state = substr($string, 1, strlen($string)-2);
								
								$sql = "SELECT * FROM users WHERE first_name = \"$first\" AND last_name = \"$last\" AND state = \"$state\"";
								$res = mysql_query($sql, $dbh);	
								if($res != FALSE) {
									$pageuser = mysql_fetch_array($res);

									echo '<img src="upload/'.$pageuser['profileimg'].'" style="width: 30vw; height: 30vw; border-radius: 3px; margin: 50px 0; box-shadow: 3px 3px 3px #e9e9e9;">';
									echo '<h1 class="display-3">'.$pageuser['first_name'].' '.$pageuser['last_name'].'</h1><br><font style="font-size: 120%;">';
									echo '<p class="lead-text"><strong><i class="fa fa-venus-mars" aria-hidden="true"></i>Gender</strong>:   '.$pageuser['gender'].'</p>';
									echo '<p class="lead-text"><strong><i class="fa fa-home" aria-hidden="true"></i>Location</strong>:   '.$pageuser['city'].' '.$pageuser['state'].'</p>';
									echo '<p class="lead-text"><strong><i class="fa fa-envelope" aria-hidden="true"></i></i>Email</strong>:   '.$pageuser['email'].'</p>';									
									echo '</font>';
									echo '<hr>';
									echo '<div style="width: 500px; margin: 0 auto; text-align: center;"><h1 class="display-6">Favorite</h1><hr>
									</div>';
									echo '<form action="students.php?userid='.$pageuser['id'].'&value='.$pageuser['first_name'].' '.$pageuser['last_name'].' ('.$pageuser['state'].')" method="post">';
									
									$uid = $_COOKIE['userid'];
									$sqlf = "SELECT * FROM favorites WHERE coachid = $uid AND userid = ".$pageuser['id']."";
									$resf = mysql_query($sqlf, $dbh);

									$butt = mysql_fetch_array($resf);

									if($res != FALSE) {

										if($butt['id'] == 0) {
											echo "<button type=\"submit\" name=\"favorite\" class=\"btn btn-outline-success\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Favorite</button>";
										} else {
											echo "<button type=\"submit\" name=\"unfavorite\" class=\"btn btn-outline-danger\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Un-Favorite</button>";
										}
									}

									echo '</form><br>';
									echo '<div style="width: 500px; margin: 0 auto; text-align: center;"><h1 class="display-6">Send Message</h1><hr>
									</div>';
									echo "<div id='showb'><button type=\"submit\" onclick=\"display()\" class=\"btn btn-outline-primary\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> Create Message</button></div>";									
									echo '<form action="students.php?email='.$pageuser['email'].'&value='.$pageuser['first_name'].' '.$pageuser['last_name'].' ('.$pageuser['state'].')" method="post" id="messagesender" style="display: none; width: 700px; margin: 0 auto;">
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
										  </form>';
									echo '<hr>';
									echo '<div style="width: 500px; margin: 0 auto; text-align: center; margin-top: 100px;"><h1 class="display-2">Sports</h1><hr>
									</div>';

									$uid = $pageuser['id'];
									$sql2 = "SELECT * FROM sports WHERE userid = $uid";
									$res2 = mysql_query($sql2, $dbh);

									if($res2 != FALSE) {
										while($row2 = mysql_fetch_array($res2)) {
											$sportid = $row2['id'];

												echo '
												<font style="font-size: 100%">
												<table class="table table-striped text-center" style="width: 80%; margin: 20px auto;">
												<thead>
													<tr>
													<th style="text-align: center">Type</th>
													<th style="text-align: center">Answer</th>
													</tr>
												</thead>
												<tbody>
													<tr>
													<td><i class="fa fa-futbol-o" aria-hidden="true"></i> <strong>Sport:</strong></td>
													<td id="td0s'.$sportid.'">';
													if($row2['sport'] != "") {echo $row2['sport'];}else{ echo "N/A"; } 
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-graduation-cap" aria-hidden="true"></i> <strong>Highschool:</strong></td>
													<td id="td1s'.$sportid.'">';
													if($row2['school'] != "") {echo $row2['school'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-street-view" aria-hidden="true"></i> <strong>Position:</strong></td>
													<td id="td2s'.$sportid.'">';
													if($row2['position'] != "") {echo $row2['position'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-trophy" aria-hidden="true"></i> <strong>Awards:</strong></td>
													<td id="td3s'.$sportid.'">';
													if($row2['awards'] != "") {echo $row2['awards'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-user-times" aria-hidden="true"></i> <strong>Level:</strong></td>
													<td id="td4s'.$sportid.'">';
													if($row2['level'] != "") {echo $row2['level'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-id-card" aria-hidden="true"></i> <strong>Stats:</strong></td>
													<td id="td5s'.$sportid.'">';
													if($row2['statistics'] != "") {echo $row2['statistics'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
													<tr>
													<td><i class="fa fa-bars" aria-hidden="true"></i> <strong>Extra:</strong></td>
													<td id="td6s'.$sportid.'">';
													if($row2['extra'] != "") {echo $row2['extra'];}else{ echo "N/A"; }
													echo '</td>
													</tr>
												</tbody>
												</table>
												</font>';

											
										}

									}

									echo '<div style="width: 500px; margin: 0 auto; text-align: center; margin-top: 100px;"><h1 class="display-2">Photos/Videos</h1><hr>
									</div>';

									$sql3 = "SELECT * FROM posts WHERE userid = $uid";
									$res3 = mysql_query($sql3, $dbh);
									while($row3 = mysql_fetch_array($res3)) {
										list($width, $height, $type, $attr) = getimagesize("upload/".$row3['url']."");

											$sourceWidth = $width;
											$sourceHeight = $height;
											
											$targetWidth = 300;
											$targetHeight = 300;
											
											$sourceRatio = $sourceWidth / $sourceHeight;
											$targetRatio = $targetWidth / $targetHeight;
											
											if ( $sourceRatio < $targetRatio ) {
												$scale = $sourceWidth / $targetWidth;
											} else {
												$scale = $sourceHeight / $targetHeight;
											}
											
											$resizeWidth = (int)($sourceWidth / $scale);
											$resizeHeight = (int)($sourceHeight / $scale);
											
											$cropLeft = (int)(($resizeWidth - $targetWidth) / 2);
											$cropTop = (int)(($resizeHeight - $targetHeight) / 2);
											
											$postid = $row3['id'];

											if($row3['type'] == "Image") {
												echo "
												<div style=\"border-left: 5px solid lightgrey; width: 90%; margin: 20px auto; padding: 40px 0;\">
													<img src='upload/".$row3['url']."' width='".$resizeWidth."px' height = '".$resizeHeight."px' style=\"box-shadow: 5px 5px 5px darkslategrey;\">
													<div style='border-left: 2px solid grey; border-right: 2px solid grey; width: 60%; margin: 0 auto;'>
													<h1 class='display-3' style=\"font-size: 170%; text-align: left; margin: 50px 20px 0 20px;\">".$row3['title']."</h1>
													<p class='lead-text'  style=\"font-size: 100%; text-align: left; margin: 5px 40px 0 40px; color: darkslategrey;\">- ".$row3['description']."</p>
													</div>
												</div>	
												<hr>
												";
											} else if ($row3['type'] == "Video") {
												echo "
												<div style=\"border-left: 5px solid lightgrey; width: 90%; margin: 20px auto; padding: 40px 0;\">
													<video width=\"650\" controls style=\"box-shadow: 5px 5px 5px darkslategrey;\">
													<source src=\"upload/".$row3['url']."\">
													<source src=\"upload/".$row3['url']."\">
													Your browser does not support HTML5 video.
												</video>
													<div style='border-left: 2px solid grey; border-right: 2px solid grey; width: 60%; margin: 0 auto;'>
													<h1 class='display-3' style=\"font-size: 170%; text-align: left; margin: 50px 20px 0 20px;\">".$row3['title']."</h1>
													<p class='lead-text'  style=\"font-size: 100%; text-align: left; margin: 5px 40px 0 40px; color: darkslategrey;\">- ".$row3['description']."</p>
													</div>
												</div>	
												<hr>
												";
											}
									}

								}
								
							}							

					} else {
						echo '
							<h1 class="display-3" style="margin-top: 35vh; padding: 0 10vw; text-align: center; font-size: 300%;">Sorry...<br> Your college is not in our database! Please contact your athletic advisor for more information.</h1>
						';
					}
                }
            }
            ?>
		</section>
		<hr class="featurette-divider">
		<footer class="container">
		<p class="float-right"><a href="#">Back to top</a></p>
		<p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
	</footer>
	<script>
        $(document).ready(function() { 
            $("#studentsli").addClass("active");
			
			$(".select").change(function() {
				var e = document.getElementById("exampleSelect1");
				var name = e.options[e.selectedIndex].value;
				var i = name.indexOf("[");
				name = name.substring(0, i-1);
				
				document.location.href = "students.php?value="+name;
			});


        });

		function display() {
			$('#messagesender').css('display', 'block');
			$('#showb').html('<button type=\"submit\" onclick=\"hidedisplay()\" class=\"btn btn-outline-danger\"><i class=\"fa fa-minus\" aria-hidden=\"true\"></i> Hide Message</button>');
		}

		function hidedisplay() {
			$('#messagesender').css('display', 'none');
			$('#showb').html('<button type=\"submit\" onclick=\"display()\" class=\"btn btn-outline-primary\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> Create Message</button>');
		}
    </script>
    <script src="javascript/loadDropdown.js"></script>
    </body>
</html>