<?php
session_start();
include 'include/header.php'; 
include 'php/paging.php';

?>
<div class="row">
	<div class="span12">
	<center><img src="../images/SiteDesign/Archive.png"></center>
	<br/>
	<ul>
		<?php echo getAllImages(); ?>
	</ul>
		<center>
			<p><?php 
				if ($site == "artwork") {
					echo "<br/><p>There " . (($total != 1) ? 'are ' : 'is ')  . $total . " piece" . (($total != 1) ? 's' : '' ) . " of art in total</p>"; 
				}
				else {
					echo "<br/><p>There " . (($total != 1) ? 'are ' : 'is ')  . $total . " comic" . (($total != 1) ? 's' : '' ) . " in total</p>"; 
				}	
				?>
			</p>
			<p><a href='./index.php?site=<?php echo $site ?>'>Back to Homepage</a></p>
		</center>
	</div>
	
	<!--<div class="span3">-->
		<?php //include './templates/include/search_field.php'; ?>
	<!--</div>-->
</div>

<?php include 'include/footer.php'; ?>



