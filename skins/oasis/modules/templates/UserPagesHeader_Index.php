<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">

<?php if ($fbAccessRequestURL) { ?>
<a data-href="<?= $fbAccessRequestURL?>" data-id="syncprofile" class="wikia-button sync-profile-button" accesskey="s">
	<img src="<?= $wgStylePath ?>/oasis/images/icon_fb_sync.png" class="popout"><?=wfMsg('fb-sync-button')?></a>
<?php } ?>

<?php if( empty($isUserProfilePageExt) && empty($isUserProfilePageV3Enabled) ) { //user profile page v1? ?>
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
		if (!empty($stats) && !empty($stats['edits'])) {
			if( !$isInternalWiki && !$isPrivateWiki ) {
	?>
				<span class="member-since"><?= wfMsg('oasis-member-since', $stats['date']) ?></span>
			<?php } else { ?>
				<?php if( !$isUserAnon ) { ?>
					<span class="member-since"><?= wfMsg('oasis-member-since', $stats['date']) ?></span>
				<?php } ?>
			<?php }?>
		<span class="member-edits"><?= wfMsgExt('oasis-edits-counter', array('parsemag'), $stats['edits']) ?></span>
	<?php
		}
	?>
<?php } else if( !empty($isUserProfilePageV3Enabled) ) {?>
		<!-- User Identity Box /BEGIN -->
		<?php echo F::app()->renderView( 'UserProfilePage', 'renderUserIdentityBox' ); ?>
		<!-- User Identity Box /END -->
<?php } else { //user profile page v2? ?>
	<!-- UserProfilePage Extension /BEGIN -->
	<?= wfRenderModule( 'UserProfilePage', 'Masthead', array( 'userName' => $userName, 'userPage' => $userPage, 'avatarMenu' => $avatarMenu, 'displayTitle' => $displaytitle, 'title' => $title, 'actionButton' => $actionButton, 'actionImage' => $actionImage, 'actionName' => $actionName, 'actionMenu' => $actionMenu, 'likes' => $likes, 'stats' => $stats ) ); ?>
	<!-- UserProfilePage Extension /END -->
<?php } // isUserProfilePageExt ?>

	<div class="tabs-container">
		<ul class="tabs">
<?php
		foreach($tabs as $tab) {
?>
			<li<?= !empty($tab['selected']) ? ' class="selected"' : '' ?><?= !empty($tab['data-id']) ? ' data-id="'.$tab['data-id'].'"' : '' ?>><?= $tab['link'] ?><?php
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

	<a name="EditPage"></a>
	
<?php if ($fbData) {?>
	<?= $fbData ?>
<?php } ?>


<?php if (isset($userInterview)) {?>
	<?= $userInterview ?>
<?php } ?>
