
<?php
ob_start();
session_start();
include 'include/header.php';
include 'login.php';
verifyAdmin();

?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#site').bind('change', function() {
			var elements = $('div.choosesite').children().hide(); 
			var value = $(this).val();
			
			if(value.length) {
				elements.filter('.' + value).show();
			}
		}).trigger('change');
	});
</script>

<center>
<h2>Add image to database</h2>
<br/>
<form action="./scripts/admin_functions.php" method="post">
	<table>
		<tr>
			<td>Site:</td>
			<td>
				<select size="1" id="site" title="" name="site">
					<option value=""></option>
					<option value="adminComics">Comics</option>
					<option value="adminArtwork">Artwork</option>			
				</select>
			</td>
		</tr>
		<tr>
			<td>	
			<div class="choosesite">
				<div class="adminComics">
					Comic category:
				</div>

				<div class="adminArtwork">
					Artwork category:
				</div>	
			</div>
			</td>
		

			<td>
				<div class="choosesite">
					<div class="adminComics">
						<select id="comicCat" name="comicCat">
							<option value="charts">charts</option>
							<option value="life">life</option>
							<option value="office">office</option>
							<option value="political">political</option>
							<option value="misc">misc</option>
						</select>
					</div>
					<div class="adminArtwork">
						<select id="artworkCat" name="artCat">
							<option value="3D">3D</option>
							<option value="Traditional Art">traditional art</option>
							<option value="Digital Art">digital art</option>
							<option value="Progression">progression</option>

						</select>
					</div>
				</div>
			</td>
		</tr>
		<tr><td>Image Title:</td> <td><input type="text" name="title"></td></tr>
		
		<tr><td>Keywords:</td> <td><input type="text" name="keywords"></td></tr>
		
		<tr><td>Description:</td> <td><input type="text" name="description"></td></tr>
	</table>


<br />
<input type="submit" value="Add Image">
<br />
<br />
<a href=".?action=homepage">Back to homepage</a>
</form>
</center>

<?php include 'include/footer.php';

ob_end_flush();
?>
	