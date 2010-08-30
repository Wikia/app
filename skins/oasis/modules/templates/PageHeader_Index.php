<div id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">
	<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
	<? if ($isMainPage) { ?>
		<div class="tally">
			<em><?= $total ?></em>
			<span><?= wfMsg('oasis-total-articles-mainpage') ?></span>
			<?= View::specialPageLink('CreatePage', null, 'wikia-chiclet-button', 'blank.gif', 'oasis-create-page'); ?>
		</div>
	<? } ?>
	<h1><?= $displaytitle != "" ? $title : htmlspecialchars($title) ?></h1>
<?php
	// edit button with actions dropdown
	if (!empty($action)) {
		echo wfRenderModule('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
	}

	// render subtitle
	if ($subtitle != '') {
?>
	<h2><?= $subtitle ?></h2>
<?php
	}

	if (!empty($revisions) || !empty($categories)) {
?>
	<details>
<?php
		// most linked categories
		if (!empty($categories)) {
?>
		<span class="categories"><?= wfMsg('oasis-page-header-read-more', implode(', ', $categories)) ?></span>
<?php
		}

		// history dropdown
		if (!empty($revisions)) {
			echo wfRenderModule('HistoryDropdown', 'Index', array('revisions' => $revisions));
		}
?>
	</details>
<?php
	}

	// render search box
	if ($showSearchBox) {
		echo wfRenderModule('Search');
	}
?>
</div>