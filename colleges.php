<?php
require("php/config.php");
require("php/safe.php");

$uid = $_COOKIE['userid'];

if(isset($_POST['submit'])) {
	$college = $_POST['college'];
	$college = safe($college);
    $sql = "UPDATE users SET college = \"$college\" WHERE id = $uid";
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
        <script src="node_modules/easy-autocomplete/dist/jquery.easy-autocomplete.min.js"></script>    
		<link rel="stylesheet" href="node_modules/easy-autocomplete/dist/easy-autocomplete.min.css"> 
    <title>CoRecruit</title>	
</head> 
	<body>
        <?php include('php/setNav.php');
            include('php/checkLogin.php'); ?>
		<section id="index-body">
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
					
					$name = $user['college'];
					$sql2 = "SELECT * FROM colleges WHERE name = \"$name\"";
					$res2 = mysql_query($sql2, $dbh);
					if($res2 != FALSE) {
						$college = mysql_fetch_array($res2);
						if($college['name'] != "") {
							echo "
									<div>
										<h1 class=\"display-3\" style=\"margin: 100px 0 0 30px; width: 50vw;\">$name</h1>
										<div style=\"text-align: right; color: #001f3f; margin-right: 30px;\">
								";		
					
							if($college['twitter'] != "" ) {
								echo "<a class=\"link\" href=\"".$college['urltwitter']."\" style=\"margin: -10px 10px 0 0;\"><i class=\"fa fa-twitter fa-2x\" aria-hidden=\"true\"></i></a>";
							}
							
							if($college['facebook'] != "") {
								echo "<a class=\"link\" href=\"".$college['urlfacebook']."\" style=\"margin: -10px 10px 0 0;\"><i class=\"fa fa-facebook fa-2x\" aria-hidden=\"true\"></i></a>";
							}
							
							if($college['instagram'] != "") {
								echo "<a class=\"link\" href=\"".$college['urlinstagram']."\" style=\"margin: -10px 10px 0 0;\"><i class=\"fa fa-instagram fa-2x\" aria-hidden=\"true\"></i></a>";
							}
							
							if($college['youtube'] != "") {
								echo "<a class=\"link\" href=\"".$college['urlyoutube']."\" style=\"margin: -10px 10px 0 0;\"><i class=\"fa fa-youtube fa-2x\" aria-hidden=\"true\"></i></a>";
							}
							
							$sports_array = explode("<br>", $college['sports']);
							$schedule_array = explode("<br>", $college['schedules']);
							$admin_array = explode("<br>", $college['administration']);
							$title_array = explode("<br>", $college['titles']);
							$phone_array = explode("<br>", $college['phone']);
							$email_array = explode("<br>", $college['email']);
							$roster_array = explode("<br>", $college['rosters']);
					 
							echo '
										</div>
										<hr>
									<div class="container-fluid">
									  <div class="row">
										<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar" style="margin-top: ;">
										  <ul class="nav nav-pills flex-column">';
										  
											for($i = 0; $i < sizeof($sports_array)-1; $i++) {
												echo '<li class="nav-item" style="margin-bottom: 10px;">
														<a class="nav-link" href="colleges.php?sport='.$i.'#sched" id="sportsnum'.$i.'">'.$sports_array[$i].'</a>
													</li>';
											}
											
											
										echo '</ul>
										</nav>

										<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3" style="position: absolute; top: 0;">
										  <h1>Administration</h1>

										  <section class="row text-center placeholders" style="margin-top: 50px;">
											<table class="table">
												<thead class="thead-inverse">
													<tr>
														<th>Name</th>
														<th>Title</th>
														<th>Phone</th>
														<th>Email</th>';
														if($user['coach'] == 1) {
															echo '<th>Delete</th>';
														} 
										echo '			</tr>
												</thead>
												<tbody id="tablebody">
												';

											for($i = 0 ; $i < sizeOf($admin_array)-1; $i++) {
													echo '
													<tr>
														<th scope="row">'.$admin_array[$i].'</th>
														<td style="text-align: left;">'.$title_array[$i].'</td>
														<td style="text-align: left;">'.$phone_array[$i].'</td>
														<td style="text-align: left;">'.$email_array[$i].'</td>';

														if($user['coach'] == 1) {
															echo '<td><button id="delete'.$i.'" onclick="deleteperson('.$i.')" type="button" class="btn btn-outline-danger"><i class="fa fa-minus" aria-hidden="true"></i> Delete</button></td>';
														}

													echo '</tr>';
											}

												echo '
												</tbody>
											</table>';

											if($user['coach'] == 1) {
												echo '<div id="containbuttons"><button id="add" type="button" class="btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add a Contact</button></div>
												<br>';
											}

											echo '<p class="lead-text" id="sched" style="margin: 0 auto">Click <a href="'.$college['directory'].'">HERE</a> to view the entire staff directory.</p>
										  </section>';
								
										if(isset($_GET['sport'])) {  
										
										$index = $_GET['sport'];
										$url = $schedule_array[$index];
										
											if($url != "") {
											echo ' <h2 style="margin-top: 50px;" >Schedule</h2>
												<iframe scrolling="yes" height="800" src="'.$url.'" style="width: 95%; margin: 0 auto;"></iframe>
												';
											}	

											$roster = $roster_array[$index];
											
												if($roster != "") {
												echo ' <h2 style="margin-top: 50px;">Roster</h2>
													<iframe scrolling="yes" height="800" src="'.$roster.'" style="width: 95%; margin: 0 auto;"></iframe>
													';
												}	

										}
										
										echo '</main>
									  </div>
									</div>

								';
						} else {
							echo '
								<h1 class="display-3" style="margin-top: 35vh; padding: 0 10vw; text-align: center; font-size: 300%;">Sorry...<br> Your college is not in our database! Please contact your athletic advisor for more information.</h1>
							';
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
            $("#collegeli").addClass("active");
			
			var selected = <?php if(isset($_GET['sport'])) { echo $_GET['sport']; } else { echo -1; }?>;
			$("#sportsnum"+selected).addClass("active");

			$('#add').click(function() {
				$('#tablebody').html(
					$('#tablebody').html() + `
				<tr>
					<th scope="row"><input type="text" class="form-control" id="addname" aria-describedby="name" placeholder="Enter name"></th>
					<td style="text-align: left;"><input type="text" class="form-control" id="addtitle" aria-describedby="name" placeholder="Enter title"></td>
					<td style="text-align: left;"><input type="text" class="form-control" id="addphone" aria-describedby="name" placeholder="Enter phone #"></td>
					<td style="text-align: left;"><input type="email" class="form-control" id="addemail" aria-describedby="name" placeholder="Enter email"></td>
				</tr>
				`);

				$('#containbuttons').html('<button id="save" onclick="save()" type="button" class="btn btn-outline-primary">Save</button>');
			});
			
        });

		function save() {

			var id = <?php echo $_COOKIE['userid']; ?>;
			var name = $("#addname").val();
			var title = $("#addtitle").val();
			var phone = $("#addphone").val();
			var email = $("#addemail").val();

			$.ajax({
				type: "POST",
				url: "php/addcontact.php?userid="+id+"&name="+name+"&title="+title+"&phone="+phone+"&email="+email,
				processData: false,
				contentType: "application/json",
				data: `
				{
				}
				`,
				success: function(r) {
					console.log(r);
					location.reload();
				},
				error: function(r) {
					console.log(r);
				}
			});
		}

		function deleteperson(index) {
			var origname = "<?php echo safe($college['administration']); ?>";
			var origtitle = "<?php echo safe($college['titles']); ?>";
			var origphone = "<?php echo safe($college['phone']); ?>";
			var orignemail = "<?php echo safe($college['email']); ?>";

			var orignamearray = origname.split("<br>");
			var name = "";
			for(var i = 0; i < orignamearray.length-1; i++) {
				if(i != index) {
					name += orignamearray[i]+"<br>";
				}
			}

			var origtitlearray = origtitle.split("<br>");
			var title = "";
			for(var i = 0; i < origtitlearray.length-1; i++) {
				if(i != index) {
					title += origtitlearray[i]+"<br>";
				}
			}

			var origphonearray = origphone.split("<br>");
			var phone = "";
			for(var i = 0; i < origphonearray.length-1; i++) {
				if(i != index) {
					phone += origphonearray[i]+"<br>";
				}
			}

			var orignemailarray = orignemail.split("<br>");
			var email = "";
			for(var i = 0; i < orignemailarray.length-1; i++) {
				if(i != index) {
					email += orignemailarray[i]+"<br>";
				}
			}

			id = <?php echo $_COOKIE['userid']; ?>;

			$.ajax({
				type: "POST",
				url: "php/deletecontact.php?userid="+id+"&name="+name+"&title="+title+"&phone="+phone+"&email="+email,
				processData: false,
				contentType: "application/json",
				data: `
				{
				}
				`,
				success: function(r) {
					console.log(r);
					location.reload();
				},
				error: function(r) {
					console.log(r);
				}
			});

		}

    </script>
    <script src="javascript/loadDropdown.js"></script>
    </body>
</html>