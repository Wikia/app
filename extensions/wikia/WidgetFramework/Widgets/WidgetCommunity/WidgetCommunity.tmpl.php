<?php
	echo wfMsg('monaco-articles-on', $total);
?>

<br />

<?php
	global $wgUser, $wgShowIPinHeader, $wgTitle;
	if($wgUser->isLoggedIn()) {
        if ( !empty( $GLOBALS["wgWikiaEnableSocialTools"] ) ) {
            echo '<a rel="nofollow" href="/index.php?title=Special:AvatarUpload"><img src="'.$avatarLink.'" id="community_avatar" /></a>';
        }
		echo wfMsg('monaco-welcome-back', '<a rel="nofollow" href="'.htmlspecialchars($userpageurl).'" id="'.$widgetId.'-my-name">'.$username.'</a>');
		echo '<span style="font-size: 11px" id="'.$widgetId.'-my-menu">';
		echo '<a rel="nofollow" href="'.htmlspecialchars($userpageurl).'">'.wfMsg('mypage').'</a>';
		echo ' | ';
		echo '<a rel="nofollow" href="'.htmlspecialchars($talkpageurl).'">'.wfMsg('mytalk').'</a>';
		echo ' | ';
		echo '<a rel="nofollow" href="#" id="cockpit2">'.wfMsg('monaco-widgets').'</a>';
		echo '</span>';
	} else {
		echo '<a rel="nofollow" id="community_register" href="'. htmlspecialchars(Skin::makeSpecialUrl( 'Userlogin', 'type=signup')) .'" class="bigButton" style="margin-bottom: 5px;"><big>'. wfMsg('create_an_account') .'</big><small>&nbsp;</small></a>';
		echo '<br style="clear: left;"/>';
		echo wfMsg('already_a_member') .' <a rel="nofollow" id="community_login" href="'. htmlspecialchars(Skin::makeSpecialUrl( 'Userlogin', 'returnto=' . $wgTitle->getPrefixedURL() )) .'">'. wfMsg('log_in') .'</a>';
	}

	if(is_array($recentlyEdited) && count($recentlyEdited) > 0) {
?>
<br /><br />

<div class="community_details color2">
	<div class="community_toggle" onclick="WidgetCommunityDetailsToggle(this);"></div>
	<h3><?= wfMsg('monaco-latest') ?></h3>
	<ul id="<?= $widgetId ?>-recently-edited">
<?php
		foreach($recentlyEdited as $key => $val) {
?>
		<li><?= wfMsg('monaco-latest-item',
		'<a rel="nofollow" href="'.Title::newFromText($val['title'])->escapeLocalURL().'">'.$val['title'].'</a><br />',
		'<a rel="nofollow" href="'.Title::newFromText($val['user'], NS_USER)->escapeLocalURL().'">'.$val['user'].'</a>'. WidgetCommunityFormatTime($val['timestamp']));
		?></li>
<?php
		}
?>
		<li class="right">
			<a rel="nofollow" href="<?= htmlentities(Skin::makeSpecialUrl('Recentchanges')) ?>" id="<?= $widgetId ?>-more"><?= strtolower(wfMsg('moredotdotdot')) ?></a>
		</li>
	</ul>
	<br />
<?php
	}
	if(is_array($users) && count($users) > 0) {
		global $wgUser;
		foreach($users as $user) {
			$usershtml[] = '<a rel="nofollow" href="'.htmlentities(Title::newFromText($user['user'], NS_USER)->getLocalURL()).'">'.htmlspecialchars($user['user']).'</a>';
		}
?>
	<h3><?= wfMsg('monaco-whos-online') ?></h3>
	<?= implode(', ', $usershtml)?>
	<ul>
		<li class="right">
			<a rel="nofollow" href="<?= htmlentities(Skin::makeSpecialUrl('WhosOnline')) ?>"><?= strtolower(wfMsg('moredotdotdot')) ?></a>
		</li>
	</ul>
<?php
	}
?>
</div>
