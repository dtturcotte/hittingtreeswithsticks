<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
<html lang="en">
	<head>
		<title>Comics and Artwork - Hitting Trees with Sticks</title>
		<meta name="description" content="Hitting Trees with Sticks is dedicated to sharing high quality original satirical comics with the world.">
		<meta name="keywords" content="comics, web comics, art, artwork, illustration, funny, comedy, posters, funny quotes, funny jokes, art gallery, artists, comic books, jokes">
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW, ARCHIVE" />
		<meta property="og:title" content="Hitting Trees with Sticks Web Comics" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.hittingtreeswithsticks.com" />
		<meta property="og:image" content="" />
		<meta property="og:site_name" content="Hitting Trees with Sticks.com" />
		<meta property="fb:admins" content="48809443" />
		
		<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="./bootstrap/js/bootstrap.js" ></script>
		<script type="text/javascript" src="./js/funStuff.js"></script>
		<script type="text/javascript" src="./lib/jsLettering.js"></script>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css" />
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
				
		<!--Google Analytics tracking code-->
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-36176151-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		<!--END Google Analytics tracking code-->
					
		<?php 
			$site = (isset($_GET['site']) ? ($_GET['site']) : null);
			if ($site == "artwork") {
				?>
				<link rel="stylesheet" type="text/css" href="./css/artwork_style.css"/>
				<?php
			}
			else {
				?>
				<link rel="stylesheet" type="text/css" href="./css/comic_style.css" />
				<?php
			}
		?>
		
		
		<script type="text/javascript">
			var images = {
				"prevkey": [
					"./images/SiteDesign/prev_hover.png",
					"./images/SiteDesign/prev.png"
				],
				"nextkey": [
					"./images/SiteDesign/next_hover.png",
					"./images/SiteDesign/next.png"
				],
				"randomkey": [
					"./images/SiteDesign/random_hover.png",
					"./images/SiteDesign/random.png"
				], 	
			};
			
			jQuery(document).ready(function($) {
				$("#prevkey, #nextkey, #randomkey").hover(function(e) {
					 // mouseover handler
					 if (this.id in images) // check for key in map
						 this.src = images[this.id][0];
				}, function(e) {
					 // mouseout handler
					 if (this.id in images)
						 this.src = images[this.id][1];
				});
			});
		
		</script>
				
	</head>
	<body>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	
	<div class="container-fluid">
		<div id="header">	
			<center>
				<table>
					<tr>
						<td valign="top">
							<a href="./?action=homepage&page=1&site=comics">
								<img id="logo" src="./images/SiteDesign/Logo_Small.png" alt="HTwS Logo"/>
							</a>
						</td>
						<td valign="middle">	
							<div class="headingTitles">
								<a href="./?action=homepage&page=1&site=comics">
									<h3 class="title">Comics</h3>
									<div class="fallingLetters"></div>
								</a>
							</div>
						</td>
						<td valign="middle">
							<div class="headingTitles">
								<a href="./?action=about&page=1&site=about">
									<h3 class="title">About</h3>
									<div class="fallingLetters"></div>
								</a>
							</div>
						</td>
						<td valign="middle">
							<div class="headingTitles">
								<a href="./?action=homepage&page=1&site=artwork">
									<h3 class="title">Artwork</h3>
									<div class="fallingLetters"></div>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</center>
		</div> <!--End div id = header-->
		<div class="row-fluid">
			<div id="catoptions">
					<?php
					//display category types:
						include './php/dbconnect.php';
						
						switch($site) {	
							case 'artwork':
								$cattable = "artcategories";
								$table = "artwork";
								break;
							default:
								$cattable = "categories";
								$table = "comics";
						}					
						$categories = $mysqli->query("SELECT catid, catname, catdesc FROM $cattable");
						
						//define as global so paging.php functions can use it
						global $totalCategories;
						$totalCategories = 0;
						
						$urlCat = (isset($_GET['catname']) ? ($_GET['catname']) : null);	
											
						echo "<div id='categories'>";			
						echo "<div class='row-fluid'>";
						echo "<div class='span5 offset3'>";
							while($row = $categories->fetch_assoc()) {
								if ($site != "about") {
									//current page highlighting
									$currCat = $row['catname']; 
									$highlight = ($currCat == $urlCat) ? 'currCats' : 'cats';	
									echo "<span class=" . $highlight . "><a href='?action=homepage&site=" . $site . "&cat=" . $row['catid'] . "&catname=" . $row['catname'] . "'/>" . $row['catname'] . "</a></span>";
									$totalCategories++;	
								}
							}
							?>
							
							
							<?php
						echo "</div>";
						?>
						<div class="span2">
							<span class='rightside'>
								<a href="http://www.facebook.com/HittingTreesWithSticks" target="_blank" >		
									<img src="./images/SiteDesign/fb_logo.png" alt="Facebook" />
								</a>
								<a href="http://www.facebook.com/HittingTreesWithSticks" target="_blank" >		
									<img src="./images/SiteDesign/tw_logo.png" alt="Twitter" />
								</a>
								<a href="http://imgur.com/user/Growler" target="_blank" >		
									<img src="./images/SiteDesign/imgur_logo.png" alt="Imgur" />
								</a>
							</span>		
						</div>
						
						<span class='admin'>
							<a href="./?action=admin_login">Admin Login</a>
						</span>
					</div>
				</div>
			
					
						<?php
											
						echo "<div id='spacer'/>";
						
						//Get total images (either comics or artwork)
						$images = $mysqli->query("SELECT id, title, path, thumb, views, catidFK FROM $table");
						mysqli_close($mysqli);
						$totalImages = 0;
						while($row = $images->fetch_assoc()) {
							$totalImages++;
						}						

						?>	
			</div>
		</div>
	</div><!--Ending Container-Fluid-->
	<div class="container">
	<?php 
	?>
