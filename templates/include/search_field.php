<?php $site = (isset($_GET['site']) ? ($_GET['site']) : null); ?>

<div id="sidebar" class="searchborder">
		<!--Allow users to search for comic-->
	<!--<span class="search">Search for <?php// echo (($site == "artwork") ? 'artwork' : 'a comic'); ?> </span>-->
	
	<script type="text/javascript">
		
		/*
		var myChoice = <?php echo $site ?>;
		var mySearchString = 0;
			
		function search(searchString) {     
				mySearchString = searchString;
				GetSearch();
				}

		function searchChoice(choice) {     
				myChoice = choice;
				GetSearch();
				}*/

		function GetSearch(mySearchString){
		 $.get("./php/search.php", {_input : mySearchString, _site : '<?php echo $site ?>'},
				function(returned_data) {
					$("#output").html(returned_data);
				}
			);

		}
	</script>
	<center>
		<table>
			<!--<tr>
				<td>
					
						<div class="btn-group" data-toggle="buttons-radio">
							<span class="search">
								
								<button type="button" class="btn" id="comics" onclick="searchChoice(this.id)">Comics</button>
								<button type="button" class="btn" id="artwork" onclick="searchChoice(this.id)">Artwork</button>
								<button type="button" class="btn" id="all" onclick="searchChoice(this.id)">All</button>
							</span>
						</div>
				</td>
			</tr>-->
			<tr>
				<td>
					
					<span class="search">
					<img src="./images/SiteDesign/Search.png" />
						<input type="text" onkeyup="GetSearch(this.value)" name="input" value="" />
						
						<!--<input id="site" type="hidden" value="<?php// echo $site; ?>">-->
					</span>
				</td>
			</tr>
		</table>
	</center>
	<span id="output">  </span>
	
</div>
