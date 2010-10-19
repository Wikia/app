<?php if ($language_list) { ?>
<nav class="WikiaArticleInterlang">
	<h3><?= wfMsg('oasis-interlang-languages'); ?> </h3>

	<ul>
	
	<?php 
	$count = 0;
	$class= "";
	foreach ($language_list as $val) {
		$count++;	 ?>
		<li <?= $class ?> ><a href="<?= $val["href"] ?>"><?= $val["name"]; ?></a></li>
		
		
		<?php 
		if ($count == $max_visible && $request_all != true) { ?>
		
		
			<li class="more-link"><a href="?interlang=all"><?= wfMsg('oasis-interlang-show-all'); ?></a></li>	
		<?php 
		}
		
		if ($enable_more == true && $count > $max_visible && $request_all != true) {
			$class = ' class="more"';
		}
	} ?>
	
	</ul>
</nav>
<?php } ?>
