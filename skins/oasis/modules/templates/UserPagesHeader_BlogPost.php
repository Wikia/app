<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogPostHeader">
	<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>

	<h1><?= htmlspecialchars($title) ?></h1>
<?php
	if (!empty($actionMenu['action'])) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $actionMenu['action'],
			'dropdown' => $actionMenu['dropdown'],
			'image' => MenuButtonModule::EDIT_ICON,
		));
	}
?>

	<details>
		<?= $avatar ?>
		<span class="post-author"><a href="<?= htmlspecialchars($userPage) ?>"><?= htmlspecialchars($userName) ?></a></span>
		<span><?= $editTimestamp ?></span>
	</details>
</div>
