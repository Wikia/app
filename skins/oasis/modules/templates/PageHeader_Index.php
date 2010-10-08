<header id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">
	<? if ($isMainPage) { ?>
		<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
		<div class="mainpage-add-page">
			<?= View::specialPageLink('CreatePage', null, null, 'blank.gif'); ?>
			<?= View::specialPageLink('CreatePage', 'oasis-add-page'); ?>
		</div>
		<div class="tally mainpage-tally">
			<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total ) ?>
			<? /* View::specialPageLink('CreatePage', null, 'wikia-chiclet-button createpage', 'blank.gif', 'oasis-create-page'); */ ?>
		</div>
	<? } ?>

	<?
	// comments & like button
	if (empty($isMainPage)) {
		echo wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes));
	}
	?>

	<h1><?= $displaytitle != "" ? $title : htmlspecialchars($title) ?></h1>

<?php
	// edit button with actions dropdown
	if (!empty($action)) {
		echo wfRenderModule('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
	}

	// render page type line
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
</header>
<?php
	if ($contentsub != '') {
?>
<div id="contentSub"><?= $contentsub ?></div>
<?php
	}
?>
