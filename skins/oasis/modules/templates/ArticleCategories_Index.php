<?php
	if ($catlinks != '') {
?>
<nav id="WikiaArticleCategories" class="WikiaArticleCategories">
	<h1><?= wfMsg( 'oasis-related-categories' ); ?></h1>
	<?= $catlinks ?>
</nav>
<?php
	}
?>
