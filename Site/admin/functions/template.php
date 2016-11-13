<?php
function nav_main($dbc,$pageid) {
	$query="SELECT * FROM pages";
	$result=mysqli_query($dbc, $query);
	while($nav=mysqli_fetch_assoc($result)){
		//echo '<li><a href="?page='.$nav['pageid'].'">'.$nav['title'].'</a></li>';
		?>
		<li <?php if($pageid == $nav['pageid']) {echo 'class="active"';} ?>><a href="?page=<?php echo $nav['pageid']; ?>"><?php echo $nav['label']; ?></a></li>					
		<?php						
	}
}
?>