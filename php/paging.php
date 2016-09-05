<?php
//session_start();
//session_destroy();
//need to explicitly define variables globally at the top first so functions can refer to them as globals
global $imagesPerPage, $cat, $offset, $catname, $page, $site,
	   $totalComics, $has_next, $has_prev, $lastPage, $total, $thumbpath,
	   $table, $filterResult, $maxW, $maxH, $tagid, $tagname, $removeAll,
	   $tagsTable, $assocTable, $sessiontagIDs, $sessiontagnames, $HotPerPage, $sortBy;

$site = (isset($_GET['site']) ? ($_GET['site']) : "comics");
$page = (isset($_GET['page']) ? ($_GET['page']) : 1);
$cat = (isset($_GET['cat']) ? ($_GET['cat']) : null);
$catname = (isset($_GET['catname']) ? ($_GET['catname']) : "all categories");
$sortBy = (isset($_GET['sort']) ? ($_GET['sort']) : "latest");

$tagid = (isset($_GET['tagid']) ? ($_GET['tagid']) : null);
$tagname = (isset($_GET['tagname']) ? ($_GET['tagname']) : null);

$removeAll = (isset($_GET['remove']) ? ($_GET['remove']) : null);

//imagesPerPage = 16
$imagesPerPage = 16;
//HotPerPage = 7;
$HotPerPage = 7;

$totalComics = 0;
$has_next = false;
$has_prev = false;

if ($site == "artwork") {
	$thumbpath = "./images/Artwork/ArtThumbnails/";
	$table = "artwork";
	$assocTable = "arttagsassoc";
	$tagsTable = "arttags";
	$maxW = 150;
	$maxH = 150;
	$sessiontagIDs = 'arttagIDs';
	$sessiontagnames = 'arttagnames';
}
else {
	$thumbpath = "./images/Comics/ComicThumbnails/";
	$table = "comics";
	$assocTable = "comictagsassoc";
	$tagsTable = "comictags";
	$maxW = 155;
	$maxH = 155;
	$sessiontagIDs = 'comictagIDs';
	$sessiontagnames = 'comictagnames';
}

//echo $assocTable;

$filterResult = getFilters();

$filterResult->data_seek(0);
while ($row = $filterResult->fetch_assoc()) {
	$totalComics++;
}
$lastPage = ceil($totalComics/$imagesPerPage);


function hasNext() {
	global $page, $has_next, $lastPage;

	if ($page < $lastPage)
	{
		$has_next = true;
	}
	return $has_next;
}

function hasPrev() {
	global $page, $has_prev;

	if ($page != 1)
	{
		$has_prev = true;
	}
	return $has_prev;
}


function getImages() {
	global $imagesPerPage, $cat, $offset, $catname, $page, $site, $totalComics, $lastPage, $totalCategories, $thumbpath, $filterResult, $maxW, $maxH;

	$offset = $page * $imagesPerPage;

	//MOVES $filterResult ARRAY POINTER AHEAD BY OFFSET NUMBER FOR PAGING TO WORK
	$images_to_offset = $imagesPerPage;
	$filterResult->data_seek(0);
	while ($images_to_offset < $offset && ($row = $filterResult->fetch_assoc())) {
		$images_to_offset++;
	}

	$title = null;

	$current_date = new DateTime;
	echo '<ul>';
	$imageCounter = 0;
	while (($imageCounter < $imagesPerPage) && ($row = $filterResult->fetch_assoc())) {

		$comic_date = new DateTime($row['date']);
		$comic_date->modify('3 day');

		if ($site == "artwork") {
			$title = $row['title'];
			$imgLabel =  'imgTitle';
		}
		else {
			$title = null;
			$imgLabel = null;
			if ($comic_date >= $current_date) {
				$imgLabel = 'imgNew';
			}
		}
		$newText = ($comic_date >= $current_date) ? '<span class="newText"><i> *new </i><span>' : null;

		//commeting this out because I don't want artwork to show "newcomics" css
		//$class = ($comic_date >= $current_date) ? 'newcomics' : 'comics';
		$class = 'comics';

		echo '<li>';
		echo   '<span class="' . $class . '"><a href=".?action=viewimage&site='.$site. '&id=' . $row['id'] .'" alt="' . $row['title'] . '">
            <img src="./php/thumber.php?img=.' . $thumbpath.$row['thumb'] . '&mw='. $maxW . '&mh= ' . $maxH . '"/><span class="' . $imgLabel . '"> ' . $title . $newText . '</span></a></span>';
		$imageCounter++;
		echo '</li>';
	}
	echo '</ul>';


	//CHECK FOR URL TAMPERING: if user manually edits cat or page parameters from url, redirect them to homepage
	/*if($cat > $totalCategories || $cat < 0 || $page > $lastPage || $page < 1 )
	 {
	  header('Location: ./?action=homepage&page=1');
	 }*/

}


//queries based on tag and/or category selections
function getFilters() {
	include 'dbconnect.php';

	global $cat, $site, $table, $tagid, $removeAll, $tagsTable, $assocTable, $sessiontagIDs, $sortBy;

	if ($sortBy == "random") {
		$order = " ORDER BY RAND()";
	}
	elseif ($sortBy == "popular") {
		$order = " ORDER BY like_count DESC";
	}
	else {
		$order = " ORDER BY date DESC";
	}

	if (!isset($_SESSION[$sessiontagIDs]) || !is_array($_SESSION[$sessiontagIDs]) || $removeAll == "true") {
		$_SESSION[$sessiontagIDs] = array();
	}

	if (isset($_SESSION[$sessiontagIDs]) && is_array($_SESSION[$sessiontagIDs])) {
		$key = array_search($tagid, $_SESSION[$sessiontagIDs]);
		if ($key !== false) {
			unset($_SESSION[$sessiontagIDs][$key]);
		}
		//if it doesn't, add it
		else {
			$_SESSION[$sessiontagIDs][] = $tagid;
		}

		if ($cat != null) $catquery = " AND catidFK = $cat";
		else $catquery = null;

		$_SESSION[$sessiontagIDs] = array_filter($_SESSION[$sessiontagIDs]);

		$sql =
			"SELECT distinct tbl.*
        FROM $table tbl
        LEFT JOIN $assocTable a ON (tbl.id = a.imgID)
        LEFT JOIN $tagsTable t ON (t.tagid = a.tagID)
        WHERE ";

		// Only add this WHERE condition if the array is nonempty. Otherwise a harmless 1=1
		$sql .= !empty($_SESSION[$sessiontagIDs]) ? "a.tagID IN (" . implode(', ', $_SESSION[$sessiontagIDs]). ") " : "1 = 1";
		$sql .= $catquery ." " . $order;

		if (!$mysqli->query($sql)) printf("<br /><b>Error:</b> %s\n", $mysqli->error);

		//var_dump($sql);

		$query = $mysqli->query($sql);

		return $query;
	}
}

/*Was originally using this to display latest comic or artwork in "Featured Artwork" section... */
function getLatestImg() {
	include 'dbconnect.php';

	//need local instances of cat and site because I'm modifying the values... do not want to modify global values... it'll change every other instance
	$cat = (isset($_GET['cat']) ? ($_GET['cat']) : null);
	$site = (isset($_GET['site']) ? ($_GET['site']) : "comics");

	//swap
	if ($site == 'comics') {
		$site = 'artwork';
		$thumbpath = "./images/Artwork/ArtThumbnails/";
	}
	elseif ($site == 'artwork') {
		$site = 'comics';
		$thumbpath = "./images/Comics/ComicThumbnails/";
	}

	$thumbpath = "./images/Artwork/ArtThumbnails/";

	$query = $mysqli->query("SELECT id, title, path, thumb, views, date, catidFK, description FROM artwork ORDER BY date DESC LIMIT 1");

	$row = $query->fetch_assoc();
	echo  '<span class="latestImgPic"><a href=".?action=viewimage&site='.$site. '&id=' . $row['id'] .'" title="' . $row['description'] . '" alt="' . $row['title'] . '">
        <img src="./php/thumber.php?img=.' . $thumbpath.$row['thumb'] . '&mw=80&mh=80"/></a></span>';
}

function getAllImages() {
	include 'dbconnect.php';

	global $cat, $site, $thumbpath, $table, $total;

	$imgpath = $mysqli->query("SELECT id, number, title, path, thumb, views, date, catidFK FROM $table ORDER BY date DESC");

	mysqli_close($mysqli);

	$total = 0;
	while ($row = $imgpath->fetch_assoc()) {
		$total++;

		echo '<li>
    <span class="archivecomics"><a href=".?action=viewimage&site='.$site.'&id=' . $row['id'] . '&cat='.$cat.'">
     <img src="./php/thumber.php?img=.' . $thumbpath.$row['thumb'] . '&mw=100&mh=100"/><span class="date">#' . $row['number'] . ",  <span class='number'>" . date('m/d/y', strtotime($row['date'])) . '</span></span>
     </a></span>
   </li>';
	}

}

//gets the selected tag names and outputs them
function getSelectedTags() {
	global $tagid, $tagname, $removeAll, $sessiontagnames;

	if (!isset($_SESSION[$sessiontagnames]) || !is_array($_SESSION[$sessiontagnames]) || $removeAll == "true") {
		$_SESSION[$sessiontagnames] = array();
	}

	if (isset($_SESSION[$sessiontagnames]) && is_array($_SESSION[$sessiontagnames])) {
		$key = array_search($tagname, $_SESSION[$sessiontagnames]);
		if ($key !== false) {
			unset($_SESSION[$sessiontagnames][$key]);
		}
		else {
			$_SESSION[$sessiontagnames][] = $tagname;
		}

		$_SESSION[$sessiontagnames] = array_filter($_SESSION[$sessiontagnames]);
		foreach ($_SESSION[$sessiontagnames] as $tn) {
			echo '<span class="tags">' . htmlspecialchars($tn) . '</span>';
		}
	}
}

function getDBTags() {
	include 'dbconnect.php';

	global $site, $cat, $tagsTable;

	$sql = "SELECT tagid, tagname FROM $tagsTable";

	$query = $mysqli->query($sql);

	while ($row = $query->fetch_assoc()) {
		echo '<span class="tags"><a href=".?action=homepage&site='.$site.'&cat='.$cat.'&tagid='.$row['tagid'].'&tagname='.$row['tagname'].'">'.$row['tagname'].'</a></span>';
	}

}
?>
