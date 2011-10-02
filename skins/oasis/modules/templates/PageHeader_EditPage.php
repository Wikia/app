<div id="WikiaPageHeader" class="WikiaPageHeader">
	<?php if( $isHistory && !$isUserTalkArchiveModeEnabled ) { ?>
		<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
	<?php } ?>
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
<?php
	// edit button
	if (!empty($action)) {
		echo wfRenderModule('MenuButton', 'Index', array('action' => $action, 'dropdown' => $dropdown, 'image' => $actionImage, 'name' => $actionName));
	}
?>
	<p><?= $subtitle ?></p>

	<?= wfRenderModule('Search') ?>
</div>