<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">
	<ul class="wikia-avatar<?= !empty($avatarMenu) ? ' wikia-avatar-menu' : '' ?>">
		<li>
			<a href="<?= htmlspecialchars($userPage) ?>" class="avatar-link"><?= $avatar ?></a>
<?php
	if (!empty($avatarMenu)) {
?>
			<ul>
<?php
		foreach($avatarMenu as $item) {
?>
				<li><?= $item ?></li>
<?php
		}
?>
			</ul>
<?php
	}
?>
		</li>
	</ul>

	<h1><?= $displaytitle != "" ? $title : htmlspecialchars($title) ?></h1>
	<?= wfRenderModule('CommentsLikes', 'Index', array('likes' => $likes)); ?>

<?php
	if (!empty($stats)) {
?>
	<span class="member-since"><?= wfMsg('oasis-member-since', $stats['date']) ?></span>
	<span class="member-edits"><?= wfMsgExt('oasis-edits-counter', array('parsemag'), $stats['edits']) ?></span>
<?php
	}
?>

	<div class="tabs-container">
		<ul class="tabs">
<?php
		foreach($tabs as $tab) {
?>
			<li<?= !empty($tab['selected']) ? ' class="selected"' : '' ?>><?= $tab['link'] ?><?php
			if (!empty($tab['selected'])) {
?>
				<img class="chevron" src="<?= $wgBlankImgUrl; ?>">
<?php
			}
?></li>
<?php
		}
?>
		</ul>
	</div>
<?php
	// render edit button / dropdown menu
	if (!empty($actionButton)) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $actionButton,
			'image' => MenuButtonModule::EDIT_ICON,
			'name' => $actionName,
		));
	}
	else if (!empty($actionMenu)) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $actionMenu['action'],
			'image' => $actionImage,
			'dropdown' => $actionMenu['dropdown'],
			'name' => $actionName,
		));
	}
?>
</div>
<?php
	if ($subtitle != '') {
?>
<div id="contentSub"><?= $subtitle ?></div>
<?php
	}
?>
