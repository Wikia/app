<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogListingHeader">
<?php
	// render edit button / dropdown menu
	if (!empty($actionButton)) {
	echo wfRenderModule('MenuButton', 'Index', array(
				'action' => $actionButton,
				'image' => MenuButtonController::BLOG_ICON,
				'name' => 'createblogpost',
				));
	}
?>

	<h1><?= htmlspecialchars($title) ?></h1>
	<h2><?= htmlspecialchars($subtitle) ?></h2>

</div>
