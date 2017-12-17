<?php
require("php/config.php");
require("php/safe.php");

$user = "";

if(isset($_COOKIE['userid'])) {
    $userid = $_COOKIE['userid'];
    $sql2 = "SELECT * FROM users WHERE id=$userid";
    $res2 = mysql_query($sql2,$dbh);
    $user = mysql_fetch_array($res2);
}

if(isset($_POST['delete'])) {
	setcookie("SNIDCo", "1", time() - 3600, "/");
	setcookie("SNID_", "1", time() - 3600, "/");
	setcookie("userid", "1", time() - 3600, "/");
	
	$userid = $_COOKIE['userid'];
	
	$sql = "DELETE FROM login_tokens WHERE userid = $userid";
	$res = mysql_query($sql,$dbh);
	
	header("Location: index.php");
}

if(isset($_POST['createsport'])) {
	$sport = $_POST['sport'];
	$highschool = $_POST['highschool'];
	$level = $_POST['levelplayed'];
	$position = $_POST['position'];
	$awards = $_POST['awards'];
	$stats = $_POST['stats'];
	$extra = $_POST['extra'];

	$sport = safe($sport);
	$highschool = safe($highschool);
	$level = safe($level);
	$position = safe($position);
	$awards = safe($awards);
	$stats = safe($stats);
	$extra = safe($extra);

	$awards = str_replace("\n", "<br />", $awards);
	$stats = str_replace("\n", "<br />", $stats);
	$extra = str_replace("\n", "<br />", $extra);


	$uid = $_COOKIE['userid'];

	if($sport != "--------------") {
		$sql = "INSERT INTO sports VALUES (\"\", $uid, \"$sport\", \"$position\", \"$awards\", \"$highschool\", \"$level\", \"$stats\", \"$extra\")";
		$res = mysql_query($sql,$dbh);
	} else {
		echo '<script>alert("You must pick a sport!");</script>';
	}
}

if(isset($_POST['deletesport'])) {
	$id = $_GET['sportid'];

	$sql = "DELETE FROM sports WHERE id = $id";
	$res = mysql_query($sql,$dbh);
}

if(isset($_POST['deletepost'])) {
	$postid = $_GET['postid'];

	$sql = "DELETE FROM posts WHERE id = $postid";
	$res = mysql_query($sql,$dbh);
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
        <?php 
            include('php/setNav.php');
            include('php/checkLogin.php'); 

        ?>
        <center>
        <div id="profilecontainer" style="margin-top:10px; padding-top: 30px; overflow: hidden; height: 500px;">
            <video src="img/backgroundprof.mp4" autoplay="true" loop="true" style="width: 100vw;; z-index: 1; margin-top: -10vw;"></video>
            <div id="overlay-contain" style="position: absolute; top: 10px; width: 100vw; height: 500px; padding-top: 100px; background: rgba(111,111,111,0.5);">
                <img src="upload/<?php if($user['profileimg'] != "") {echo $user['profileimg'];}else{ echo "default.jpeg"; } ?>" height="250" width="250" style="border-radius: 100%;  box-shadow: 5px 5px 5px rgba(100,100,100,0.5); margin-bottom: 30px; z-index: 10;">
                <br>
                <h1 class="display-3" style="color: white; background: rgba(111,111,111,0.7); padding: 5px 0;"> <?php echo $user['first_name']." ".$user['last_name']; ?></h1>
            </div>
        </div>
        <div class="row" style="margin-top: -15px; padding-bottom: 50px;background: #F5F5F5;">
            <div class="col" style="border-right: 2px solid rgba(111,111,111,0.1);">
                <hr>
                <h3 class="display-3" style="font-size: 250%">Personal Information</h3>
                <hr>
                <br>
                <font style="font-size: 100%">
                <table class="table table-striped text-center" style="width: 80%; margin: 0 auto;">
                <thead>
                    <tr>
                    <th style="text-align: center">Type</th>
                    <th style="text-align: center">Answer</th>
                    <th style="text-align: center">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><i class="fa fa-user-circle-o" aria-hidden="true"></i> <strong>Username:</strong></td>
                    <td id="td0"><?php if($user['username'] != "") {echo $user['username'];}else{ echo "N/A"; } ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td00"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(0, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
                    <tr>
                    <td><i class="fa fa-address-book" aria-hidden="true"></i> <strong>Email:</strong></td>
                    <td id="td1"><?php if($user['email'] != "") {echo $user['email'];}else{ echo "N/A"; } ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td10"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(1, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
                    <tr>
                    <td><i class="fa fa-venus-mars" aria-hidden="true"></i> <strong>Gender:</strong></td>
                    <td id="td2"><?php if($user['gender'] != "") {echo $user['gender'];}else{ echo "N/A"; } ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td20"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(2, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
                    <tr>
                    <td><i class="fa fa-hashtag" aria-hidden="true"></i> <strong>Zipcode:</strong></td>
                    <td id="td3"><?php if($user['zipcode'] != "") {echo $user['zipcode'];}else{ echo "N/A"; } ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td30"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(3, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
                    <tr>
                    <td><i class="fa fa-map-marker" aria-hidden="true"></i> <strong>City:</strong></td>
                    <td id="td4"><?php if($user['city'] != "") {echo $user['city'];}else{ echo "N/A"; } ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td40"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(4, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
                    <tr>
                    <td><i class="fa fa-globe" aria-hidden="true"></i> <strong>State:</strong></td>
                    <td id="td5"><?php if($user['state'] != "") {echo $user['state'];}else{ echo "N/A"; }; ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td50"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(5, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
					<tr>
                    <td><i class="fa fa-globe" aria-hidden="true"></i> <strong>Change Profile:</strong></td>
                    <td id="td6"><?php if($user['profileimg'] != "") {echo $user['profileimg'];}else{ echo "Default"; }; ?></td>
                    <td style="color: #001f3f" class="hoverg" id="td60"><i class="fa fa-pencil" aria-hidden="true" onclick="edit(6, <?php echo $_COOKIE['userid']; ?>)" style="color: #001f3f;"></i></td>
                    </tr>
					<tr>
                    <td><i class="fa fa-lock" aria-hidden="true"></i> <strong>Change Password:</strong></td>
                    <td id="td7"></td>
                    <td style="color: #001f3f" class="hoverg" id="td70"><i class="fa fa-pencil" onclick="location.href = 'changepass.php'" aria-hidden="true" style="color: #001f3f;"></i></td>
                    </tr>
                </tbody>
                </table>
				</font>
            </div>
            <div class="col" style="border-left: 2px solid rgba(111,111,1111,0.1);">
            <hr>
                <h3 class="display-3" style="font-size: 250%">Sports Information</h3>
                <hr>
				<br>
				<font style="font-size: 100%">
				<?php
				$userid = $_COOKIE['userid'];
				$sql = "SELECT * FROM sports WHERE userid = $userid";
				$res = mysql_query($sql,$dbh);

				if($res != False) {
					if(mysql_num_rows($res)>0) {
						while($row = mysql_fetch_array($res)) {

							$sportid = $row['id'];

							echo '
							<font style="font-size: 100%">
							<table class="table table-striped text-center" style="width: 80%; margin: 0 auto;">
							<thead>
								<tr>
								<th style="text-align: center">Type</th>
								<th style="text-align: center">Answer</th>
								<th style="text-align: center">Edit</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								<td><i class="fa fa-futbol-o" aria-hidden="true"></i> <strong>Sport:</strong></td>
								<td id="td0s'.$sportid.'">';
								if($row['sport'] != "") {echo $row['sport'];}else{ echo "N/A"; } 
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td00s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(0, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-graduation-cap" aria-hidden="true"></i> <strong>Highschool:</strong></td>
								<td id="td1s'.$sportid.'">';
								if($row['school'] != "") {echo $row['school'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td10s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(1, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-street-view" aria-hidden="true"></i> <strong>Position:</strong></td>
								<td id="td2s'.$sportid.'">';
								if($row['position'] != "") {echo $row['position'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td20s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(2, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-trophy" aria-hidden="true"></i> <strong>Awards:</strong></td>
								<td id="td3s'.$sportid.'">';
								if($row['awards'] != "") {echo $row['awards'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td30s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(3, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-user-times" aria-hidden="true"></i> <strong>Level:</strong></td>
								<td id="td4s'.$sportid.'">';
								if($row['level'] != "") {echo $row['level'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td40s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(4, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-id-card" aria-hidden="true"></i> <strong>Stats:</strong></td>
								<td id="td5s'.$sportid.'">';
								if($row['statistics'] != "") {echo $row['statistics'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td50s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(5, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td><i class="fa fa-bars" aria-hidden="true"></i> <strong>Extra:</strong></td>
								<td id="td6s'.$sportid.'">';
								if($row['extra'] != "") {echo $row['extra'];}else{ echo "N/A"; }
								echo '</td>
								<td style="color: #001f3f" class="hoverg" id="td60s'.$sportid.'"><i class="fa fa-pencil" aria-hidden="true" onclick="edits(6, '.$_COOKIE['userid'].', '.$sportid.')" style="color: #001f3f;"></i></td>
								</tr>
								<tr>
								<td></td>
								<td><form action="profile.php?sportid='.$sportid.'" method="post"><button type="submit" name="deletesport" class="btn btn-outline-danger">Delete Sport</button></form></td>							
								<td></td>
								</tr>
							</tbody>
							</table>
							<br><hr><br>
							</font>
							';
						}
					}
				}

				?>
                </font>
				<button type="button" onclick="openmodal(1)" class="btn btn-outline-primary">Add A Sports Profile <i class="fa fa-plus" aria-hidden="true" style="margin-left: 10px;"></i></button>
            </div>
			<div class="containimg" style="width: 80%; margin: 0 auto;">
				<hr style="margin-top: 100px;">
                <h3 class="display-3" style="font-size: 250%; width: 100%;">Videos / Images</h3>
                <hr>
				<?php
					$userid = $_COOKIE['userid'];
					$sql = "SELECT * FROM posts WHERE userid = $userid ORDER BY id";
					$res = mysql_query($sql,$dbh);

					if($res != FALSE) {
						if(mysql_num_rows($res)>0) {
							while($row = mysql_fetch_array($res)) {

								list($width, $height, $type, $attr) = getimagesize("upload/".$row['url']."");

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
								
								$postid = $row['id'];

								if($row['type'] == "Image") {
									echo "
									<div style=\"border-left: 5px solid lightgrey; width: 90%; margin: 20px auto; padding: 40px 0;\">
										<img src='upload/".$row['url']."' width='".$resizeWidth."px' height = '".$resizeHeight."px' style=\"box-shadow: 5px 5px 5px darkslategrey;\">
										<div style='border-left: 2px solid grey; border-right: 2px solid grey; width: 60%; margin: 0 auto;'>
										<h1 class='display-3' style=\"font-size: 170%; text-align: left; margin: 50px 20px 0 20px;\">".$row['title']."</h1>
										<p class='lead-text'  style=\"font-size: 100%; text-align: left; margin: 5px 40px 0 40px; color: darkslategrey;\">- ".$row['description']."</p>
										<br><br>
										<form action=\"profile.php?postid=$postid\" method=\"post\"><button type=\"submit\" name=\"deletepost\" class=\"btn btn-outline-danger\">Delete Post</button></form>																		
										</div>
									</div>	
									<hr>
									";
								} else if ($row['type'] == "Video") {
									echo "
									<div style=\"border-left: 5px solid lightgrey; width: 90%; margin: 20px auto; padding: 40px 0;\">
										<video width=\"650\" controls style=\"box-shadow: 5px 5px 5px darkslategrey;\">
										<source src=\"upload/".$row['url']."\">
										<source src=\"upload/".$row['url']."\">
										Your browser does not support HTML5 video.
									  </video>
										<div style='border-left: 2px solid grey; border-right: 2px solid grey; width: 60%; margin: 0 auto;'>
										<h1 class='display-3' style=\"font-size: 170%; text-align: left; margin: 50px 20px 0 20px;\">".$row['title']."</h1>
										<p class='lead-text'  style=\"font-size: 100%; text-align: left; margin: 5px 40px 0 40px; color: darkslategrey;\">- ".$row['description']."</p>
										<br><br>
										<form action=\"profile.php?postid=$postid\" method=\"post\"><button type=\"submit\" name=\"deletepost\" class=\"btn btn-outline-danger\">Delete Post</button></form>
										</div>
									</div>	
									<hr>
									";
								}
							}
						}
					}
				?>
				<br>
				<button type="button" onclick="openmodal(2)" class="btn btn-outline-primary">Post an Image or Video <i class="fa fa-plus" aria-hidden="true" style="margin-left: 10px;"></i></button>
        	</div>
		</div>
		</center>
		<div id="letthelightsgoout1" style="display: none; width: 100vw; height: 100vh; position: fixed; top: 0; left: 0; background: rgba(0,0,0,0.7);">
			<div class="mymodal" style="width: 700px;  height: 78vh; overflow-y: scroll; position: fixed; top: 12vh; left: calc(50vw - 350px); box-shadow: 10px 10px 10px slategrey;">
				<div class="modal-head" style="background: slategrey; padding: 10px 20px 50px 20px">
					<p id="close" style="color: white; float: right;" onclick="closemodal(1)">X</p>
					<h1 class="display-3" style="color: white; font-size: 200%; border-bottom: 1px solid white; padding-bottom: 10px; margin-top: 50px;">Create a Sports Profile</h1>
				</div>
				<div class="modal-body" style="background: #f1f1f1;">
				<center>
				<i class="fa fa-futbol-o fa-5x" aria-hidden="true" style="margin: 30px auto;"></i>
				</center>
					<p class="led-text" style="font-size: 120%;">Welcome to the Sports Profile Creator!</p>
					<p class="led-text" style="font-size: 100%; color: darkslategrey">Here is where you get to show off your skills to your college. Fill out the information below for any sport and make sure you click save on the bottom. Once you click save, all coaches can see your sports profile.</p>
					<form class="form-inline" id="" action="" method="post">
						<div class="alert alert-danger" role="alert" id="fail" style="display: none; margin-top: 10px; width: 100%;">
							<strong>Oh snap!</strong> Make sure you fill out all the forms. The username and password is case sensitive.
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
						<label for="sport" style="">Sport</label>
						<select class="form-control" id="sport" name="sport" style="width: 100%;" required>
						<option>--------------</option>
						  <option value="Baseball">Baseball</option>
							<option value="Basketball">Basketball</option>
							<option value="Bowling">Bowling</option>
							<option value="Cross Country">Cross Country</option>
							<option value="Football">Football</option>
							<option value="Golf">Golf</option>
							<option value="Half MarathonCT">Half Marathon</option>
							<option value="Lacrosse">Lacrosse</option>
							<option value="Soccer">Soccer</option>
							<option value="SoftballFL">Softball</option>
							<option value="Swimming">Swimming</option>
							<option value="Diving">Diving</option>
							<option value="Tennis">Tennis</option>
							<option value="Track & Field">Track & Field</option>
							<option value="Volleyball">Volleyball</option>
							<option value="Wrestling">Wrestling</option>
						</select>
					    </div>
						<br>
						<div class="form-group" id="highschool" style="width: 100%; margin-top: 15px;">
							<label for="highschool">Highschool</label>
							<input type="text" id="highschool" name="highschool" class="form-control login" placeholder="High School" style="width: 100%;">
						</div>
						<div class="form-group" id="levelplayed" style="width: 100%; margin-top: 15px;">
							<label for="levelplayed">Level Played (JV or Varsity)</label>
							<input type="text" id="levelplayed" name="levelplayed" class="form-control login" placeholder="Level Played" style="width: 100%;">
						</div>
						<div class="form-group" id="position" style="width: 100%; margin-top: 15px;">
							<label for="position">Position</label>
							<input type="text" id="position" name="position" class="form-control login" placeholder="Position" style="width: 100%;">
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
							<label for="awards">Awards</label>
							<textarea class="form-control" name="awards" id="awards" rows="3" style="width: 100%;"></textarea>
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
							<label for="stats">Statistics</label>
							<textarea class="form-control" name="stats" id="stats" rows="3" style="width: 100%;"></textarea>
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
							<label for="extra">Extra</label>
							<textarea class="form-control" name="extra" id="extra" rows="3" style="width: 100%;"></textarea>
						</div>
						<br>
						<button type="submit" name="createsport" class="btn btn-danger btn-lg"  style="margin: 20px auto;">Save</button>
					</form>
				</div>
			</div>
		</div>
		<div id="letthelightsgoout2" style="display: none; width: 100vw; height: 100vh; position: fixed; top: 0; left: 0; background: rgba(0,0,0,0.7);">
			<div class="mymodal" style="width: 700px;  height: 78vh; overflow-y: scroll; position: fixed; top: 12vh; left: calc(50vw - 350px); box-shadow: 10px 10px 10px slategrey;">
				<div class="modal-head" style="background: slategrey; padding: 10px 20px 50px 20px">
					<p id="close" style="color: white; float: right;" onclick="closemodal(2)">X</p>
					<h1 class="display-3" style="color: white; font-size: 200%; border-bottom: 1px solid white; padding-bottom: 10px; margin-top: 50px;">Post an Image Or Video</h1>
				</div>
				<div class="modal-body" style="background: #f1f1f1;">
				<center>
				<i class="fa fa-camera-retro fa-5x" aria-hidden="true" style="margin: 30px auto;"></i>
				</center>
					<p class="led-text" style="font-size: 120%;">Welcome to the media poster!</p>
					<p class="led-text" style="font-size: 100%; color: darkslategrey">Here is where you can post images and videos to show off your skills to potential coaches. Don't forget to add a title to the image and video and tell the coaches what they are watching in the decription.</p>
					<form class="form-inline" id="" action="php/upload_file.php?post=true" enctype="multipart/form-data" method="post">
						<div class="alert alert-danger" role="alert" id="fail" style="display: none; margin-top: 10px; width: 100%;">
							<strong>Oh snap!</strong> Make sure you fill out all the forms. The username and password is case sensitive.
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
						<label for="type" style="">Type</label>
						<select class="form-control" id="type" name="type" style="width: 100%;" required>
						<option>--------------</option>
						  <option value="Image">Image</option>
							<option value="Video">Video</option>
						</select>
					    </div>
						<br>
						<div class="form-group" id="title" style="width: 100%; margin-top: 15px;">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" class="form-control login" placeholder="Title" style="width: 100%;">
						</div>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
							<label for="description">Description</label>
							<textarea class="form-control" name="description" id="description" rows="3" style="width: 100%;"></textarea>
						</div>
						<br>
						<div class="form-group" style="width: 100%; margin-top: 15px;">
							<label for="file">File</label>
							<input type="file" name="file" id="file">
						</div>
						<button type="submit" name="createpost" class="btn btn-danger btn-lg"  style="margin: 20px auto;">Save</button>
					</form>
				</div>
			</div>
		</div>
		<style>
			#close:hover {
				cursor: pointer;
			}
		</style>
        <script src="javascript/profile.js"></script>
		<script>

			function openmodal(id) {
				$('#letthelightsgoout'+id).css('display', 'block');
				$('body').css('overflow', 'hidden');
			}
			

			function closemodal(id) {
				$('#letthelightsgoout'+id).css('display', 'none');
				$('body').css('overflow', 'auto');
			}
		</script>
		<hr class="featurette-divider">
		<footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2017 CoRecruit, Inc. &middot; <a href="privacy.php">Privacy</a> &middot; <a href="terms.php">Terms</a></p>
      </footer>
	</body>	
</html>