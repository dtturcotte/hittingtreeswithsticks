<?php
//Query all images:
include 'dbconnect.php';


$site = $_GET['_site'];
$input = (isset($_GET['_input']) ? ($_GET['_input']) : 0);
$siteChoice = (isset($_GET['_choice']) ? ($_GET['_choice']) : $site);
$max = 4;


//if user goes to hittingtreeswithsticks.com... no "site" value will be set... so I need to set one
if ($site == null) {
	$site = "comics";
}

if ($siteChoice == "artwork") {
	$sql = "SELECT id, title, keywords, thumb FROM artwork";
	$thumbpath = "./images/Artwork/ArtThumbnails/";
}
else if ($siteChoice == "comics") {
	$sql = "SELECT id, title, keywords, thumb FROM comics";
	$thumbpath = "./images/Comics/ComicThumbnails/";
}
else {
	$sql = "SELECT id, title, keywords, thumb FROM $site";
	if ($site == "artwork") {
		$thumbpath = "./images/Artwork/ArtThumbnails/";
	}
	else {
		$thumbpath = "./images/Comics/ComicThumbnails/";
	}
}
/* For this to work, need all comics replicated in an "All Comics" file along with "All Thumbnails"
else {
    $sql = "SELECT id, title, thumb FROM comics
            UNION
            SELECT id, title, thumb FROM artwork";
    $thumbpath = "./images/AllThumbnails/";
}*/


$imgpaths = $mysqli->query($sql);
mysqli_close($mysqli);

$idresult = array();
$imgresult = array();
$thumbresult = array();

//CHECK IF $INPUT == IMAGE PATH
if (strlen($input) > 0)
{
	while ($row = $imgpaths->fetch_assoc())
	{
		//query against key words, not the image title (no one will remember the title)
		if (stripos($row['keywords'], $input) !== false || strtolower($input)==strtolower(substr($row['title'],0,strlen($input))))
			//if (strtolower($input)==strtolower(substr($row['title'],0,strlen($input))))
		{
			array_push($idresult, $row['id']);
			array_push($imgresult, $row['title']);
			array_push($thumbresult, $row['thumb']);
		}
	}
	//ECHO RESULTS ARRAY
	if(count($imgresult) == 0)
	{
		echo "<p>no suggestions</p>";
	}
	else
	{

		echo "<ul>";
		$k = 0;
		while ($k < count($imgresult) && $k < $max)
		{
			echo '<li>
                            <span class="sidebarimages"><a href=".?action=viewimage&site=' . $siteChoice . '&id=' . $idresult[$k] . '">
                            <img src="./php/thumber.php?img=.'.$thumbpath.$thumbresult[$k].'&mw=90&mh=90"/></a></span>
                          </li>';
			$k++;
		}

		$difference = count($imgresult)-$k;

		echo '<div id="moreResults">';
		while ($k < count($imgresult))
		{
			echo '<li>
                            <span class="sidebarimages"><a href=".?action=viewimage&site=' . $siteChoice . '&id=' . $idresult[$k] . '">
                            <img src="./php/thumber.php?img=.'.$thumbpath.$thumbresult[$k].'&mw=90&mh=90"/></a></span>
                          </li>';

			$k++;
		}
		echo '</div>';


		if (count($imgresult) > $max) {
			?>
			<i><a href="#" id="showMore"><br />Show <?php echo $difference; ?> more result<?php echo (($difference != 1) ? 's' : ''); ?>...</a></i>
		<?php
		}

		echo "</ul>";
	}
}
?>
<script type="text/javascript">
	$("#moreResults").hide();

	$("#showMore").click(function() {
		$("#moreResults").show();
		$("#showMore").hide();

	});
</script>
