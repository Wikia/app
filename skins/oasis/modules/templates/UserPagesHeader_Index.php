<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">

<?php if ($fbAccessRequestURL) { ?>
<a data-href="<?= $fbAccessRequestURL?>" data-id="syncprofile" class="wikia-button sync-profile-button" accesskey="s">
	<img src="<?= $wgStylePath ?>/oasis/images/icon_fb_sync.png" class="popout"><?=wfMsg('fb-sync-button')?></a>
<?php } ?>

<?php if ( empty( $isUserProfilePageExt ) ) { ?>
	<!-- UPPv3 /BEGIN -->
	<?php echo F::app()->renderView( 'UserProfilePage', 'renderUserIdentityBox', array() ); ?>
	<!-- UPPv3 /END -->
<?php } else { ?>
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
<?php
	if ($subtitle != '') {
?>
<div id="contentSub"><?= $subtitle ?></div>
<?php
	}
?>
	<a name="EditPage"></a>
	
	
<?php if ($fbData) {?>
	<?= $fbData ?>
<?php } ?>


<?php if (isset($userInterview)) {?>
	<?= $userInterview ?>
<?php } ?>
