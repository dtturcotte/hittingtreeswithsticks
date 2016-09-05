<?php
/* Handles key input for viewcomic.php*/
?>

	<script type="text/javascript">
		//put back $catParam at some point
		var imgArray = [<?php echo implode(',', getImages($site)) ?>];
		var titleArray = [<?php echo implode(',', getTitles($site)) ?>];
		var descriptionArray = [<?php echo implode(',', getDescriptions($site)) ?>];
		var imgIndex = <?php echo $imgid; ?>;
		var currURL = document.URL;


		$(document).ready(function() {
			var img = document.getElementById("showimg");
			img.src = imgArray[imgIndex];

			if(imgIndex == 41) {
				$("#ChineseComic").show();
			}
			else {
				$("#ChineseComic").remove();
			}

			if("<?php echo $site; ?>" == "artwork") {
				$("#showtitle").text(titleArray[imgIndex]);
				$("#showdescription").text(descriptionArray[imgIndex]);
			}

			$("#showURL").text(currURL);

			$(document).keydown(function (e) {
				var key = e.which;
				var rightarrow = 39;
				var leftarrow = 37;
				var random = 82;


				if (key == rightarrow)
				{
					imgIndex++;
					if (imgIndex > imgArray.length-1)
					{
						imgIndex = 0;

					}
					img.src = imgArray[imgIndex];
					window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
					window.location.reload();
				}
				if (key == leftarrow)
				{
					if (imgIndex == 0)
					{
						imgIndex = imgArray.length;
					}
					img.src = imgArray[--imgIndex];
					window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
					window.location.reload();
				}
				if (key == random)
				{
					imgIndex = Math.floor((Math.random()*(imgArray.length-1))+1);
					img.src = imgArray[imgIndex];
					window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
					window.location.reload();
				}
				if(imgIndex == 54) {
					$("#generateButton").show();
					$("#generated").show();
				}
				else {
					$("#generateButton").hide();
					$("#generated").hide();
				}
			});

			$("#next").click(function() {
				imgIndex++;
				if (imgIndex > imgArray.length-1)
				{
					imgIndex = 0;
				}
				img.src = imgArray[imgIndex];
				window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
				window.location.reload();

				if(imgIndex == 54) {
					$("#generateButton").show();
					$("#generated").show();
				}
				else {
					$("#generateButton").hide();
					$("#generated").hide();
				}
			});
			$("#prev").click(function() {
				if (imgIndex == 0)
				{
					imgIndex = imgArray.length;
				}
				img.src = imgArray[--imgIndex];
				window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
				window.location.reload();
				if(imgIndex == 54) {
					$("#generateButton").show();
					$("#generated").show();
				}
				else {
					$("#generateButton").hide();
					$("#generated").hide();
				}
			});
			$("#random").click(function() {
				imgIndex = Math.floor((Math.random()*(imgArray.length-1))+1);
				img.src = imgArray[imgIndex];
				window.history.pushState(null, null, '.?action=viewimage&site=<?php echo $site; ?>&id=' + imgIndex);
				window.location.reload();
				if(imgIndex == 54) {
					$("#generateButton").show();
					$("#generated").show();
				}
				else {
					$("#generateButton").hide();
					$("#generated").hide();
				}
			});
		});

	</script>

<?php
function getImages($siteParam) {
	include 'dbconnect.php';
	if ($siteParam == 'artwork') {
		$table = "artwork";
	}
	else {
		$table = "comics";
	}

	$catResult = $mysqli->query("SELECT id, title, path FROM $table");
	$img = array();
	while($row = $catResult->fetch_assoc())
	{
		$img[] = "'" . $row['path'] . "'";
	}
	return $img;
}

function getTitles($siteParam) {
	include 'dbconnect.php';

	if ($siteParam == 'artwork') {
		$table = "artwork";
	}
	else {
		$table = "comics";
	}
	$titles = array();
	$titleResult = $mysqli->query("SELECT id, title, path FROM $table");
	while($row = $titleResult->fetch_assoc())
	{
		$titles[] = "'" . $row['title'] . "'";
	}
	return $titles;

}

function getDescriptions($siteParam) {
	include 'dbconnect.php';

	if ($siteParam == 'artwork') {
		$table = "artwork";
	}
	else {
		$table = "comics";
	}
	$descriptions = array();
	$descResult = $mysqli->query("SELECT id, title, path, description FROM $table");
	while($row = $descResult->fetch_assoc())
	{
		$descriptions[] = "'" . $row['description'] . "'";
	}
	return $descriptions;

}
?>
