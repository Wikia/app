<header id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">
	<? if ($isMainPage) { ?>
		<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
		<?php if( empty( $wgEnableWikiAnswers ) ): ?>
		<div class="mainpage-add-page">
			<?= View::specialPageLink('CreatePage', null, 'createpage', 'blank.gif', 'oasis-create-page', 'sprite new'); ?>
			<?= View::specialPageLink('CreatePage', 'oasis-add-page', 'createpage'); ?>
		</div>
		<?php endif; ?>
		<div class="tally mainpage-tally">
			<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total, 'fixedwidth' ) ?>
		</div>
	<? } ?>

	<?
	// comments & like button
	if (empty($isMainPage)) {
		echo wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes));
	}
	?>

	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>

<?php
	// edit button with actions dropdown
	if (!empty($action)) {
		echo wfRenderModule('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
	}
	if (!empty($isNewFiles)) {
?>

	<?= View::specialPageLink('Upload', 'oasis-add-photo', (!$wgUser->isLoggedIn() ? 'wikia-button upphotoslogin' :'wikia-button upphotos'), 'blank.gif', 'oasis-add-photo', 'sprite photo') ?>

<?php
	}
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
	
	// render search box
	if ($showSearchBox) {
		echo wfRenderModule('Search');
	}
?>
</header>
