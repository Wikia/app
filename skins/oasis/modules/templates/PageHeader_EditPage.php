<div id="WikiaPageHeader" class="WikiaPageHeader WikiaPageHeaderDiffHistory">
	<?php
	if( !empty($isHistory) && !empty($isUserTalkArchiveModeEnabled) ) { ?>
		<?= F::app()->renderView('CommentsLikes', 'Index', array('comments' => $comments)); ?>
	<?php } ?>
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
<?php
	// edit button
	if (!empty($action)) {
		echo F::app()->renderView('MenuButton', 'Index', array('action' => $action, 'dropdown' => $dropdown, 'image' => $actionImage, 'name' => $actionName));
	}
?>
	<p><?= $subtitle ?></p>
</div>
