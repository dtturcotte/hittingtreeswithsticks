<?php 
/*
Controls display of comic on the viewComic template
*/
include 'include/header.php';

global $site, $imgid, $table;

$cat = (isset($_GET['cat']) ? ($_GET['cat']) : null); 
$site = (isset($_GET['site']) ? ($_GET['site']) : null);
$title = (isset($_GET['title']) ? ($_GET['title']) : null);
$imgid = (isset($_GET['id']) ? ($_GET['id']) : null);

include './php/keyinput.php'; 

if ($site == "artwork") {
	$table = "artwork";
	
}
else { 
	$table = "comics";
	
}

/*if ($imgid < 0 || $imgid > count(getImages($cat, $site))) {
	//add a Jquery UI dialog that says, "don't do that!"
	header('Location: ./?action=viewcomic&id=dontdothat');
}*/



/*~~~ VIEWS COUNTER: ~~~*/
if(is_numeric($imgid)) {
	//addViews();
}
?>

<script type="text/javascript">

	function this_hover(id) {
		var images = {
			"like": [
				"./images/SiteDesign/like_hover.png",
				"./images/SiteDesign/like.png",	
			],
			"dislike": [
				"./images/SiteDesign/dislike_hover.png",
				"./images/SiteDesign/dislike.png",
			]
		}
		$("#"+id).on({
			mouseenter: function() {
				if (this.id in images) this.src = images[this.id][0];
			   
			},
			mouseleave: function() {
			   if (this.id in images) this.src = images[this.id][1];
			}
		});
	}
	
	function callBoth(choice) {
		likeCounter(choice);
	}

	function likeCounter(choice) {	
		
		$.get("./php/likecounter.php", {_choice : choice, _site : "<?php echo $site; ?>", _id : <?php echo $imgid; ?>},
			function(returned_data) {
				$("#choice").html(returned_data);
			}
		);
		$("#like, #dislike").remove();
		$("#getlikes").remove();
	}
	
	$(document).ready(function() {		
		$("#generateButton").click(function(e) {
				$.get("./php/chineseRestaurant.php",
					function(returned_data) {
						$("#generated").html(returned_data);
					}
				);
			}
		);
	});
	
</script>
	<div id="ChineseComic">
		<div id="chineseRestaurant">
			<table>
				<tr>
					<td><button id="generateButton">Click me to make your new restaurant name!</button></td>
					<td><b><span id="generated"></span></b></td>
				</tr>
			</table>
		<br />
		</div>
	</div>
	
		<br />
		
		<center>
			<div class="viewImageFix">
				<span id="prev"><img id="prevkey" src="./images/SiteDesign/prev.png" alt="Comic Navigation" /></span>
				<span id="random"><img id="randomkey" src="./images/SiteDesign/random.png" alt="Comic Navigation" /></span>
				<span id="next"><img id="nextkey" src="./images/SiteDesign/next.png" alt="Comic Navigation" /></span>
			</div>
		</center>
		
		<br/>
		<!--Get img.src from keyinput.php-->
		<?php if ($site == "") { 
			echo '<div class="row">
					<div class="span12">
						<div id="contentContainers">';
				}?>
							<center>
							<?php if ($site == "artwork") { ?>
								<span id="showtitle"></span>
								<br />
								<span id="showdescription"></span>
								<br />
							<?php } ?>
								<hr>
								<br/>
								<img src="" id="showimg"/>
								<br/>
								<br/>
								<hr>
								<?php echo getVoteImages(); ?>			
								<span id="choice"></span>
								<span id="getlikes"><?php echo getLikes(); ?></span>
								<p><?php// echo displayViews(); ?></p> 
							</center>
				<?php if ($site == "") {
				echo '		</div>
						</div>
					</div>';	
					}
				?>
		<center><b>Link to this <?php echo (($site == "artwork") ? 'artwork' : 'comic'); ?>:</b> <span id="showURL"></span></center>
		<div class="fb-like" data-href="http://www.hittingtreeswithsticks.com/?action=viewimage&site=<?php echo $site ?>&id=<?php echo $imgid; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="trebuchet ms"></div>
		<script type="text/javascript">
			document.getElementById('fb').setAttribute('data-href', sUrl);
			FB.XFBML.parse();
		</script>
		<!--************************ DISQUS CODE ************************ -->
		<center>
		<div id="disqus">
			 <div id="disqus_thread"></div>
				<script type="text/javascript">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_shortname = 'htws'; // required: replace example with your forum shortname

					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
			</div>
		</center>
		<!--************************ DISQUS CODE END ******************* -->

		<center>
		<br />
			<p><a href="./?action=allimages&site=<?php echo $site ?>">View all</a></p>
			<p><a href="./index.php?site=<?php echo $site ?>">Back to Homepage</a></p>
		</center>

	
<?php 

function getVoteImages() {
	include './php/dbconnect.php';
	global $site, $imgid, $table;
	
	$likeimage = "<img src='./images/SiteDesign/";
	$dislikeimage = "<img src='./images/SiteDesign/";
	
	$sql = "SELECT ip, tablename, imgid, vote FROM votes WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND tablename = '$table' AND imgid = $imgid";
	$result = $mysqli->query($sql);		
		
	$row = $result->fetch_assoc();	
	
	if ($row['vote'] == "like") {
		$likeimage.= "liked.png' id='like' onclick='callBoth(this.id)'/> ";
		$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
	}
	elseif ($row['vote'] == "dislike") {
		$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		$dislikeimage.= "disliked.png' id='dislike' onclick='callBoth(this.id)'/> ";	
	}
	else {
		$likeimage.= "like.png' id='like' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";
		$dislikeimage.= "dislike.png' id='dislike' onclick='callBoth(this.id)' onmouseover='this_hover(this.id)'/> ";	
	}

	echo $likeimage . " " . $dislikeimage;	
}


function getLikes() {
	include './php/dbconnect.php';
	global $site, $imgid, $table;
		
	$sql = "SELECT like_count, dislike_count FROM $table WHERE id = $imgid";
	
	$result = $mysqli->query($sql);	
	
	list($likes, $dislikes) = $result->fetch_array(MYSQLI_NUM);
	echo  "<p>" . $likes . "<span class='votespacer'>" . $dislikes . "</span></p>";
	
	mysqli_close($mysqli);
}

//update table with incremented view for img id 'x' if a unique IP address has seen it
function addViews() {
	include './php/dbconnect.php';
	global $site, $imgid, $table;
	
	/*$sql = "INSERT INTO 
				views (ip, table_name, imgid) 
			VALUES 
				(\"".$_SERVER['REMOTE_ADDR']."\", \"$table\", $imgid)
			ON DUPLICATE KEY UPDATE
				ip = VALUES(ip),
				table_name = VALUES(table_name),
				imgid = VALUES(imgid)";*/
		
	
	$sql = "UPDATE $table SET views = views + 1 WHERE id = $imgid";
	$mysqli->query($sql);
	
	mysqli_close($mysqli);
}

//display total views for img id 'x'
function displayViews() {
	include './php/dbconnect.php';
	global $site, $imgid, $table;
	
	$sql_views = "SELECT views FROM $table WHERE id = $imgid";
	$views = $mysqli->query($sql_views);
	
	list($views) = $views->fetch_array(MYSQLI_NUM);
	
	echo "Views: " . $views;
}

include 'include/footer.php'; 

?>