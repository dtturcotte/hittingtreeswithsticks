<?php


//  comicsinsert();
//  artworkinsert();

//  clearComics();
//  clearArt();

//  foreignKey();
//  testInsert();
//  testInsertRecursive();


function testInsertRecursive() {
	$it = new RecursiveDirectoryIterator("./images/Artwork/Digital Art/");
	$display = Array ( 'png' );
	foreach(new RecursiveIteratorIterator($it) as $file)
	{
		if (in_array(strtolower(array_pop(explode('.', $file))), $display))
			echo $file . "<br/> \n";

		$sql = "INSERT INTO
                            artwork (title)
                        VALUES
                            ($file)
                        ON DUPLICATE KEY UPDATE
                            id=VALUES(id),
                            title=VALUES(title),
                            path=VALUES(path),
                            thumb=VALUES(thumb),
                            catidFK=VALUES(catidFK)";

		$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
	}
}

function testInsert() {
	include 'dbconnect.php';
	$j = 0;
	//make it dynamic so $dir changes when it reaches the count

	echo "running...";

	//Artwork




	$ART_thumbs = array(scandir('./images/Artwork/Three D/Three D Thumbs'), scandir('./images/Artwork/Digital Art/Digital Art Thumbs'), scandir('./images/Artwork/Progression/Progression Thumbs'), scandir('./images/Artwork/Traditional Art/Traditional Art Thumbs'));

	//Comics

	$COMICS_path = array('./images/Comics/Charts/', './images/Comics/Life/', './images/Comics/Misc/', './images/Comics/Office/', './images/Comics/Political/');

	$COMICS_files = array(scandir('./images/Comics/Charts/'), scandir('./images/Comics/Life/'), scandir('./images/Comics/Misc/'), scandir('./images/Comics/Office/'), scandir('./images/Comics/Political/'));

	$COMICS_thumbs = array(scandir('./images/Comics/Charts/Charts Thumbs'), scandir('./images/Comics/Life/Life Thumbs'), scandir('./images/Comics/Misc/Misc Thumbs'), scandir('./images/Comics/Office/Office Thumbs'), scandir('./images/Comics/Political/Political Thumbs'));



	$ART_files = array();
	$ART_paths = array('./images/Artwork/Three D/', './images/Artwork/Digital Art/', './images/Artwork/Progression/', './images/Artwork/Traditional Art/');
	foreach($ART_paths as $path) {
		$ART_files = array_merge($ART_files, scandir($path));
	}

	print_r($ART_files);

	$sql = "INSERT INTO
                artwork (path)
            VALUES
                ($ART_files[$j])
            ON DUPLICATE KEY UPDATE
                id=VALUES(id),
                title=VALUES(title),
                path=VALUES(path),
                thumb=VALUES(thumb),
                catidFK=VALUES(catidFK)";

	$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
	$j++;

	/*
		$ART_files = scandir('./images/Artwork/Three D/');
		$ART_files = scandir('./images/Artwork/Digital Art/');
		$ART_files = scandir('./images/Artwork/Traditional Art/');
		$ART_files = scandir('./images/Artwork/Progression/');



		//loop through each folder
		for ($i = 0; $i < count($ART_paths); $i++)
		{
			echo "<br /> paths: " . $ART_paths[$i];
			//loop through each file in each folder
			for ($x = 0; $x < count($ART_files); $x++)
			{

				//check that file is not a directory
				if(!is_dir($ART_paths . $ART_files[$x]))
				{
					echo "<br /> files: " . basename(($ART_files[$x]), ".png");*/
	/*  $sql = "INSERT INTO
					artwork (id, title, path, thumb, catidFK)
				VALUES
					('$j', '$ART_files[$x]', '$ART_paths[$i]$ART_files[$x]', '$ART_thumbs[$x]', 1)
				ON DUPLICATE KEY UPDATE
					id=VALUES(id),
					title=VALUES(title),
					path=VALUES(path),
					thumb=VALUES(thumb),
					catidFK=VALUES(catidFK)";

		$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
		$j++;   */
	//  }
	//  }
	//}
}

function artworkinsert() {
	include 'dbconnect.php';

	$ThreeD = scandir('./images/Artwork/Three D/');
	$DigitalArt = scandir('./images/Artwork/Digital Art/');
	$Progression = scandir('./images/Artwork/Progression/');
	$TraditionalArt = scandir('./images/Artwork/Traditional Art/');


	$ThreeDPath = './images/Artwork/Three D/';
	$DigitalArtPath = './images/Artwork/Digital Art/';
	$ProgressionPath = './images/Artwork/Progression/';
	$TraditionalArtPath = './images/Artwork/Traditional Art/';


	$ThreeDThumbs = scandir('./images/Artwork/Three D/Three D Thumbs/');
	$DigitalArtThumbs = scandir('./images/Artwork/Digital Art/Digital Art Thumbs/');
	$ProgressionThumbs = scandir('./images/Artwork/Progression/Progression Thumbs/');
	$TraditionalArtThumbs = scandir('./images/Artwork/Traditional Art/Traditional Art Thumbs/');


	//ARTWORK:

	$j = 0;
	for($x=0; $x<count($ThreeD); $x++)
	{
		if(!is_dir($ThreeDPath . $ThreeD[$x]))
		{
			$sql = "INSERT INTO
                        artwork (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($ThreeD[$x]), ".png") . "', '$ThreeDPath$ThreeD[$x]', '$ThreeDThumbs[$x]', 1)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($TraditionalArt); $x++)
	{
		if(!is_dir($TraditionalArtPath . $TraditionalArt[$x]))
		{
			$sql = "INSERT INTO
                        artwork (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($TraditionalArt[$x]), ".png") . "', '$TraditionalArtPath$TraditionalArt[$x]', '$TraditionalArtThumbs[$x]', 2)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($DigitalArt); $x++)
	{
		if(!is_dir($DigitalArtPath . $DigitalArt[$x]))
		{
			$sql = "INSERT INTO
                        artwork (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($DigitalArt[$x]), ".png") . "', '$DigitalArtPath$DigitalArt[$x]', '$DigitalArtThumbs[$x]', 3)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($Progression); $x++)
	{
		if(!is_dir($ProgressionPath . $Progression[$x]))
		{
			$sql = "INSERT INTO
                        artwork (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Progression[$x]), ".png") . "', '$ProgressionPath$Progression[$x]', '$ProgressionThumbs[$x]', 4)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}
}




function comicsinsert() {
	include 'dbconnect.php';

	$Charts = scandir('./images/Comics/Charts/');
	$Life = scandir('./images/Comics/Life/');
	$Office = scandir('./images/Comics/Office/');
	$Political = scandir('./images/Comics/Political/');
	$Misc = scandir('./images/Comics/Misc/');

	$ChartsPath = './images/Comics/Charts/';
	$LifePath = './images/Comics/Life/';
	$OfficePath = './images/Comics/Office/';
	$PoliticalPath = './images/Comics/Political/';
	$MiscPath = './images/Comics/Misc/';

	$ChartsThumbs = scandir('./images/Comics/Charts/Charts Thumbs/');
	$LifeThumbs = scandir('./images/Comics/Life/Life Thumbs/');
	$OfficeThumbs = scandir('./images/Comics/Office/Office Thumbs/');
	$PoliticalThumbs = scandir('./images/Comics/Political/Political Thumbs/');
	$MiscThumbs = scandir('./images/Comics/Misc/Misc Thumbs/');

	$j = 0;
	for($x=0; $x<count($Charts); $x++)
	{
		if(!is_dir($ChartsPath . $Charts[$x]))
		{
			$sql = "INSERT INTO
                        comics (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Charts[$x]), ".png") . "', '$ChartsPath$Charts[$x]', '$ChartsThumbs[$x]', 1)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($Life); $x++)
	{
		if(!is_dir($LifePath . $Life[$x]))
		{
			$sql = "INSERT INTO
                        comics (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Life[$x]), ".png") . "', '$LifePath$Life[$x]', '$LifeThumbs[$x]', 2)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($Office); $x++)
	{
		if(!is_dir($OfficePath . $Office[$x]))
		{
			$sql = "INSERT INTO
                        comics (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Office[$x]), ".png") . "', '$OfficePath$Office[$x]', '$OfficeThumbs[$x]', 3)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($Political); $x++)
	{
		if(!is_dir($PoliticalPath . $Political[$x]))
		{
			$sql = "INSERT INTO
                        comics (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Political[$x]), ".png") . "', '$PoliticalPath$Political[$x]', '$PoliticalThumbs[$x]', 4)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}

	for($x=0; $x<count($Misc); $x++)
	{
		if(!is_dir($MiscPath . $Misc[$x]))
		{
			$sql = "INSERT INTO
                        comics (id, title, path, thumb, catidFK)
                    VALUES
                        ($j, '" .  basename(($Misc[$x]), ".png") . "', '$MiscPath$Misc[$x]', '$MiscThumbs[$x]', 5)
                    ON DUPLICATE KEY UPDATE
                        id=VALUES(id),
                        title=VALUES(title),
                        path=VALUES(path),
                        thumb=VALUES(thumb),
                        catidFK=VALUES(catidFK)";

			$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
			$j++;
		}
	}
}



function foreignKey() {
	$sql = "ALTER TABLE comics
            ADD CONSTRAINT catidFK
            FOREIGN KEY (catid)
            REFERENCES categories (catid)";

	$mysqli->query($sql) or trigger_error($mysqli->error.$sql);
}

function clearComics() {
	include 'dbconnect.php';
	echo "deleting data from comics table...";

	$result = $mysqli->query("SELECT * FROM comics");
	while($row = $result->fetch_assoc())
	{
		$mysqli->query("TRUNCATE TABLE comics");
	}
}

function clearArt() {
	include 'dbconnect.php';
	echo "deleting data from artwork table...";

	$result = $mysqli->query("SELECT * FROM artwork");
	while($row = $result->fetch_assoc())
	{
		$mysqli->query("TRUNCATE TABLE artwork");
	}
}


?>
