<?php
$adj = array("Happy", "Great", "Mandarin", "New", "Golden", "Ming's", "Royal", "Oriental", "Szechuan", "Lee's", "Wang's", "Hunan", "House of", "Lucky", "Joy", "Imperial", "Feng's");
$noun = array("Dragon", "Sea", "Wok", "Fortune", "Rice", "Empire", "Garden", "China", "Village", "Palace", "Kitchen", "Mountain", "Bamboo", "Star", "Wall", "Pond", "Bistro", "Lotus", "River", "Empire", "Gate", "Pagoda", "Temple", "Moon");

$x = rand(0, count($adj)-1);
$y = rand(0, count($noun)-1);
$z = rand(0, count($noun)-1);

echo '<p>' . $adj[$x] . " " . $noun[$y] . " " . $noun[$z] . '</p>';

?>
