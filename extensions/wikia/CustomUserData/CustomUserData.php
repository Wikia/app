<?php
$wgHooks['CustomUserData'][] = 'wfCustomUserData';

function wfCustomUserData( $skin, &$tpl, &$custom_user_data ) {
	global $wgUser, $wgTitle;
	
	//links 
	$register = Title::makeTitle(NS_SPECIAL, "UserRegister");
	$login = Title::makeTitle(NS_SPECIAL, "Userlogin");
	
	if( $wgUser->isLoggedIn() ){
		$custom_user_data  .= "<li>
			Welcome <b><a href=\"".htmlspecialchars($skin->data['userlinks']['userpage']['href'])."\">" .  htmlspecialchars($skin->data['userlinks']['userpage']['text']) . "</a></b>
		</li>
		<li id=\"header_username\">
			<a href=\"".htmlspecialchars($skin->data['userlinks']['mytalk']['href'])."\">".wfMsg('mytalk')."</a>
		</li>
		<li>
			<a href=\"".htmlspecialchars($skin->data['userlinks']['watchlist']['href'])."\">".htmlspecialchars($skin->data['userlinks']['watchlist']['text'])."</a>
		</li>
		<li>
			<dl id=\"headerButtonUser\" class=\"headerMenuButton\">
				<dt>".trim(wfMsg('moredotdotdot'), ' .')."</dt>
				<dd>&nbsp;</dd>
			</dl>
		</li>
		<li>
			<a href=\"".htmlspecialchars($skin->data['userlinks']['logout']['href'])."\">".wfMsg('logout')."</a>
		</li>";
	} else {
		$custom_user_data .= "<li id=\"userLogin\">
			<a class=\"wikia_button\" href=\"".$login->escapeFullURL()."\">
				<span>".wfMsg('log_in')."</span>
			</a>
		</li>
		<li>
			<a class=\"wikia_button\" href=\"".$register->escapeFullURL()."\">
				<span>".wfMsg('create_an_account')."</span>
			</a>
			
		</li>";
	}
	return true;
}

?>
