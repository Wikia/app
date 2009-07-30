<?php
global $wgStyleVersion, $wgExtensionsPath, $wgTitle, $wgUser;

if ($wgTitle->getNamespace() == NS_USER || $wgTitle->getNamespace() == NS_USER_TALK) {
	global $wgTitle;
	$userMastheadName = $wgTitle;
}
if ($wgTitle == 'Special:Watchlist') {
	$userMastheadName = $wgUser->getName();
}

?>

<div id="user_masthead" class="reset clearfix">
	<?php echo $avatar->display( 50, 50, false, "avatar", false, ( ( $userspace == $wgUser->getName() ) || ( $wgUser->isAllowed( 'removeavatar' ) && ( !$avatar-> isDefault() ) ) ), 'usermasthead/user' ) ?>
<? if ( ( $userspace == $wgUser->getName() ) || ( $wgUser->isAllowed( 'removeavatar' ) ) ) { ?>
	<span class="avatarOverlay color1" style="visibility: hidden;" id="wk-avatar-change" onmouseover="this.style.visibility='visible';" onmouseout="this.style.visibility='hidden';">
<? if ( $userspace == $wgUser->getName() ) { ?>	
		<span onclick="WET.byStr('usermasthead/editavatar');javascript:location='<?php echo Title::newFromText("Preferences", NS_SPECIAL)->getLocalUrl(); ?>'"><?=wfMsg('blog-avatar-edit')?></span>
<? } ?>
<? if ( ( $wgUser->isAllowed( 'removeavatar' ) ) && ( !$avatar-> isDefault() ) ) { ?>	
		<span onclick="WET.byStr('usermasthead/removeavatar');javascript:location='<?php echo Title::newFromText("RemoveAvatar", NS_SPECIAL)->getLocalUrl("action=search_user&av_user={$avatar->getUserName()}"); ?>'"><?=wfMsg('blog-avatar-delete')?></span>
<? } ?>		
	</span>
<? } ?>
	<div id="user_masthead_head" class="clearfix">
		<h2><?=$data['userspace']?></h2>
		<ul class="nav_links_head">
			<?
			global $wgStylePath;
			foreach( $data['nav_links_head'] as $navLink ) {
				$id = strtolower($navLink['dbkey']);
				echo '<li id="mt_' . $id . '"><a id="mt_' . $id . '_icon" href="'. $navLink['href'] .'" onclick="WET.byStr(\'usermasthead/' . $navLink['tracker'] . '\')" rel="nofollow"><img id="mt_' . $id . '_img" class="sprite" src="' . $wgStylePath . '/monobook/blank.gif" alt="'. $navLink['text'] .'"/></a> <div><a id="mt_' . $id . '_link" href="'. $navLink['href'] .'" onclick="WET.byStr(\'usermasthead/' . $navLink['tracker'] . '\')">'. $navLink['text'] .'</a></div></li>';
			}
			?>
		</ul>
	</div>
	<ul class="nav_links">
		<?
		foreach( $data['nav_links'] as $navLink ) {
			echo "<li ". ( ( $current  == $navLink[ "dbkey" ]) ? 'class="selected">' : ">" ) . '<a href="'. $navLink['href'] .'" onclick="WET.byStr(\'usermasthead/' . $navLink['tracker'] . '\')" rel="nofollow">'. $navLink['text'] .'</a></li>';
		}
		?>
	</ul>
</div>
