<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">
	
<?php if ( empty( $isUserProfilePageExt ) ) { ?>
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
	<?php
		// render edit button / dropdown menu
		if (!empty($actionButton)) {
			echo wfRenderModule('MenuButton', 'Index', array(
				'action' => $actionButton,
				'image' => $actionImage,
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
<?php } else { ?>
	<!-- UserProfilePage Extension stuff /BEGIN -->
	<div class="wikia-avatar">
		<a href="<?= htmlspecialchars($userPage) ?>" class="avatar-link"><?= $avatar ?></a>
		<? if (!empty($avatarMenu)) :?>
			<div class="avatar-menu">
				<? foreach( $avatarMenu as $item ) :?>
					<span>
						<img class="sprite edit-pencil" src="<?= wfBlankImgUrl() ;?>"/>
						<?= $item ?>
					</span>
				<? endforeach ;?>
			</div>
		<? endif ;?>
	</div>
	<h1><?= $displaytitle != "" ? $title : htmlspecialchars($title) ?></h1>
	<hr />

	<?php
		// render edit button / dropdown menu
		if (!empty($actionButton)) {
			echo wfRenderModule('MenuButton', 'Index', array(
				'action' => $actionButton,
				'image' => $actionImage,
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


<?= wfRenderModule('CommentsLikes', 'Index', array('likes' => $likes)); ?>
	<?php
		if (!empty($stats)) {
	?>
		<div class="edits-info">
			<span class="count"><?= $stats['edits']; ?></span>
			<span class="date"><?= wfMsg( 'userprofilepage-edits-since', $stats['date'] ) ;?></span>
		</div>

	<?php
		}
	?>
	<!-- UserProfilePage Extension stuff /END -->
<?php } // isUserProfilePageExt ?>

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
</div>
<?php
	if ($subtitle != '') {
?>
<div id="contentSub"><?= $subtitle ?></div>
<?php
	}
?>
	<a name="EditPage"></a>