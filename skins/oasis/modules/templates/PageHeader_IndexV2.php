<header id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>

<?php
	// edit button with actions dropdown
	if (!empty($action)) {
		echo wfRenderModule('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
	}

	// "Add a photo" button
	if (!empty($isNewFiles) && !empty($wgEnableUploads)) {
		echo Wikia::specialPageLink('Upload', 'oasis-add-photo', (!$isUserLoggedIn ? 'wikia-button upphotoslogin' :'wikia-button upphotos'), 'blank.gif', 'oasis-add-photo', 'sprite photo');
	}

	// comments & like button
	echo wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes));

	// "pages on this wiki" counter
	if (!is_null($total)) {
?>
	<div class="tally">
		<?= wfMsgExt('oasis-total-articles-mainpage', array( 'parsemag' ), $total ) ?>
	</div>
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

	// include undelete message (BugId:1137)
	if ($undelete != '') {
?>
	<div id="contentSub2"><?= $undelete ?></div>
<?php
	}
?>
</header>
<?php
	// render search box
	if ($showSearchBox) {
?>
<section id="WikiaSearchHeader" class="WikiaSearchHeader">
	<?=  wfRenderModule('Search') ?>
</section>
<?php
	}
?>
