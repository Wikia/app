<header id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>

<?php
	// edit button with actions dropdown

	// render page type line
	if ($pageSubtitle != '') {
?>
	<h2><?= $pageSubtitle ?></h2>
<?php
	}

	// MW subtitle
	if ($subtitle != '') {
?>
	<div class="subtitle"><?= $subtitle ?></div>
<?php
	}	
?>
</header>
