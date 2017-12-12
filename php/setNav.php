<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse" style="background-color: transparent">
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">CoRecruit</a>
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item" id="indexli">
				<a class="nav-link"  href="index.php">Home <span class="sr-only">(current)</span></a>
			  </li>
				<li class="nav-item" id='contactli'>
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
			  
			
			<?php 
			if(isset($_COOKIE['SNIDCo'])){
				if(isset($_COOKIE['userid'])) {
					
					$userid = $_COOKIE['userid'];
					
					$sql = "SELECT * FROM users WHERE id = $userid";
					$res = mysql_query($sql,$dbh);
					$usersel = mysql_fetch_array($res);
					
					if($usersel['coach'] == 0) {

						echo "<li class=\"nav-item\" id='profileli'>
								<a class=\"nav-link\" href=\"profile.php?userid=".$_COOKIE['userid']."\">Profile</a>
								</li>";

						echo "<li class=\"nav-item\" id='collegeli'>
								<a class=\"nav-link\" href=\"colleges.php\">Colleges</a>
							</li>";

						echo '</ul>
							<form class="form-inline mt-2 mt-md-0" action="index.php" method="post">
							  <p class="display-2" style="color: white; font-size: 27px; margin: -3px 15px 0 0;">Hello '.$usersel['first_name'].'!</p>
							  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="delete">Logout</button>
							</form>';
						
					} else {
						
						echo "<li class=\"nav-item\" id='studentsli'>
								<a class=\"nav-link\" href=\"students.php\">Students</a>
								</li>";

						echo "<li class=\"nav-item\" id='collegeli'>
								<a class=\"nav-link\" href=\"colleges.php\">Colleges</a>
							</li>";

							echo "<li class=\"nav-item\" id='favoritesli'>
							<a class=\"nav-link\" href=\"favorites.php\">Favorites</a>
							</li>";

						echo '</ul>
							<form class="form-inline mt-2 mt-md-0" action="index.php" method="post">
							  <p class="display-2" style="color: white; font-size: 27px; margin: -3px 15px 0 0;">Hello '.$usersel['first_name'].'!</p>
							  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="delete">Logout</button>
							</form>';
						
					}
					
				} 
			} else {
				echo '<li class="nav-item mt-2 mt-md-0">
							<a class="nav-link" href="login.php">LogIn/SignUp</a>
					  </li></ul>';
					  
			}
			?>
			
		  </div>
		</nav>	