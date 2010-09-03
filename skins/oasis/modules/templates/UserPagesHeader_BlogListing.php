<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogListingHeader">
	<h1><?= htmlspecialchars($title) ?></h1>

<?php
	// render edit button / dropdown menu
	if (!empty($actionButton)) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $actionButton,
			'image' => MenuButtonModule::ADD_ICON,
			'name' => 'createblogpost',
		));
	}
?>
</div>
