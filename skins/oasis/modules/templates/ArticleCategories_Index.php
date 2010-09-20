<?php
	if ($catlinks != '') {
?>
<nav id="WikiaArticleCategories" class="WikiaArticleCategories">
	<? if (!$wgSingleH1) { ?>
	<h1>Related Categories</h1>
	<? } ?>
	<?= $catlinks ?>
</nav>
<?php
	}
?>
