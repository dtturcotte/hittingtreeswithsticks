<?php 

include 'include/header.php'; 
include 'php/paging.php';

//Uncomment when I want to run insert, update, or delete commands
include 'php/crud.php'; 

$sortBy = (isset($_GET['sort']) ? ($_GET['sort']) : "latest");
$showcaseArtID = 39;
$featuredArtID = 40;
$showcaseComicID = 0;


?>

	<div class="row">
		<div class="span3">
			<div class="rightside">
				<?php include 'include/search_field.php'; ?>
				
				<div id="contentContainers">
					<img src="./images/SiteDesign/Tag.png" />
					Tags <div class="taginfo"><i>(click tag again to remove)</i></div>

					<?php echo getDBTags(); ?>						
					
				</div>
				<div id="contentContainers">
				<img src="./images/SiteDesign/MyTag.png" />
					Your tags: <div class="taginfo"><a href=".?action=homepage&site=<?php echo $site ?>&cat=<?php echo $cat ?>&tagid=&tagname=&remove=true"><i>remove all tags</i></a></div>
					
					<?php echo getSelectedTags(); ?>
				</div>
				<div id="contentContainers">
					<p>Favorite comics and blogs</p>
					<div class="divider"></div>
					
					<a href="http://thegreatoclocknews.com/" target="_blank">The Great o'Clock News</a>
					<br/>
					<a href="http://theoatmeal.com/" target="_blank">The Oatmeal</a>
					<br/>
					<a href="http://xkcd.com/" target="_blank">xkcd</a>
					<br/>
					<a href="http://hyperboleandahalf.blogspot.com/" target="_blank">Hyperbole and a Half</a>
					<br/>					
					<a href="http://pbfcomics.com/" target="_blank">The Perry Bible Fellowship</a>
					<br/>						
					<a href="http://www.explosm.net/comics/" target="_blank">Cyanide & Happiness</a>
					<br/>	
					<a href="http://www.whosay.com/DemetriMartin/categories/art" target="_blank">Demetri Martin's Art</a>
					<br/>			
					<a href="http://threewordphrase.com/" target="_blank">Three Word Phrase</a>
					<br/>							
					
				</div>
				<?php
					if ($site == "comics" || $site == null) {  
						echo '<div id="contentContainers">';
							echo '<span class="latestImgPic"><a href=".?action=viewimage&site=artwork&id=' . $featuredArtID .'"><img src="./images/latest artwork.png"/></a>';
							echo '<div class="latestImgText">Featured Artwork</div>';
						echo '</div>';
					} 
				?>
			</div>
		</div>
		
		<div class="span9">
			<div class="row">
				<div class="span9">
					<?php 
						if ($site == "artwork") { 
							echo '<div class="highlightedComic"><a href=".?action=viewimage&site=artwork&id=' . $showcaseArtID .'"><img src="./images/highlighted artwork.png"/></a></div>';
						} 
						elseif ($site == "comics" || $site == null) {
							echo '<div class="highlightedComic"><a href=".?action=viewimage&site=comics&id=' . $showcaseComicID .'"><img src="./images/highlighted comic.png"/></a></div>';
						} 
					?>
				</div>				
			</div>
			<div class="row">
				<div class="span9">
					<div class="comicDisplay">					
						<div id="contentContainers">
							<div class="row">	
								<div class="span9">
								<?php 
								if ($sortBy == "random") { 
									$sortHeading = "randomHeading"; 
									$sortImg = "Random_sort";
								}
								elseif ($sortBy == "popular") {
									$sortHeading = "hotHeading"; 
									if ($site == "artwork") {
										$sortImg = "Popular_art";
									}
									else {
										$sortImg = "Popular";
									}
								}
								else {
									$sortHeading = "latestHeading"; 
									$sortImg = "Latest";
								}
								?>
									<div class=<?php echo $sortHeading ?>><img src="./images/SiteDesign/<?php echo $sortImg ?>.png" />Sorted by <?php echo $sortBy ?> <?php echo (($site == "artwork") ? "artwork" : "comics") ?>  
										<div class="sortBy">
											<a href='?action=homepage&site=<?php echo $site ?>&sort=latest'>latest</a> 
											| 
											<a href='?action=homepage&site=<?php echo $site ?>&sort=popular'>popular</a> 
											| 
											<a href='?action=homepage&site=<?php echo $site ?>&sort=random'>random</a> 
										</div>
									</div>	
								<?php getImages();?>									
								</div>			
							</div>
						</div>
					</div>
				</div>
			<center>
				<div id="nav">
						<?php 		
							
							if (hasPrev()) {
								echo '<li><span class=navItems><a href="?site=' . $site . '&cat=' . $cat . '&page='. ($page == 1) .'"> first </a></span></li>';
								echo '<li><span class=navItems><a href="?site=' . $site . '&cat=' . $cat . '&page='. ($page - 1) .'"> < prev </a></span></li>';
							}	
							for($i = 1; $i <= $lastPage; $i++) {
								$navCSS = ($page == $i) ? 'newNavItems' : 'navItems';
								echo '<li><span class=' . $navCSS . '><a href="?site=' . $site . '&cat=' . $cat . '&page=' . $i .'">' . $i . '</a></span></li>';
							}
							
							if (hasNext()) {
								echo '<li><span class=navItems><a href="?site=' . $site . '&cat=' . $cat . '&page='.($page + 1).'"> next > </a></span></li>';
								echo '<li><span class=navItems><a href="?site=' . $site . '&cat=' . $cat . '&page='.($lastPage).'"> last </a></span></li>';	
							}					
						?>
					<br/>
					<br/>
					<p><a href="./?action=allimages&site=<?php echo $site ?>">View all</a></p>
				</div>
			</center>
			</div>
		</div>
	</div><!--End top row-->
<?php include 'include/footer.php'; ?>


