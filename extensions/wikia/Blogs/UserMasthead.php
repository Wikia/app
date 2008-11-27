<?php
$wgHooks['MonacoBeforePageBar'][] = 'userMasthead';

function userMasthead() {
	global $wgTitle, $wgUser, $userMasthead, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgRequest;

	/**
	 * we want to match in another way current used links
	 */
	$wgOut->addHtml("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/Blogs/css/UserMasthead.css?{$wgStyleVersion}\" />");
	$namespace = $wgTitle->getNamespace();

	$dbKey = $wgTitle->getDBkey();
	$isAnon = $wgUser->isAnon();

	if( $namespace == NS_BLOG_ARTICLE ||
		$namespace == NS_USER ||
		$namespace == NS_USER_TALK ||
		$namespace == NS_SPECIAL && (
			$dbKey == 'Watchlist' ||
			$dbKey == 'WidgetDashboard' ||
			$dbKey == 'Preferences' ||
			$dbKey == 'Contributions'
		)
	){

		/**
		 * change dbkey for nonspecial articles, in this case we use NAMESPACE
		 * as key
		 */
		if( $namespace != NS_SPECIAL ) {
			$dbKey = $namespace;
		}
		$userMasthead = true; //hides article/talk tabs in Monaco.php
		$out = array();
		//DEFINE USERSPACE - THE USERNAME THAT BELONGS ON THE MASTHEAD
		if ( in_array( $namespace, array( NS_USER, NS_USER_TALK, NS_BLOG_ARTICLE ) ) ) {
			if( strpos( $wgTitle->getDBkey(), "/") ) {
				list ( $userspace, $title ) = explode( "/", $wgTitle->getDBkey(), 2 );
			}
			else {
				$userspace = $wgTitle->getDBkey();
			}
			$Avatar = BlogAvatar::newFromUserName( $userspace );
		}
		if( $dbKey == 'Watchlist' || $dbKey == 'WidgetDashboard' || $dbKey == 'Preferences' ) {
			$userspace = $wgUser->getName();
			$Avatar = BlogAvatar::newFromUser( $wgUser );
		}

		if( $dbKey == 'Contributions' ) {
			$reqTitle = $wgRequest->getText("title", false);
			if( strpos( $reqTitle, "/") !== false ) {
				list ( $title, $userspace ) = explode( "/", $reqTitle, 2 );
				$Avatar = BlogAvatar::newFromUserName( $userspace );
			}
			else {
				$userspace = $wgUser->getName();
				$Avatar = BlogAvatar::newFromUser( $wgUser );
			}
		}
		$out['userspace'] = $userspace;

		/**
		 * get avatar for this user
		 */

		$out['nav_links'][] = array('text' => wfMsg('nstab-user'), 'href' => Title::newFromText( $userspace, NS_USER )->getLocalUrl(), "dbkey" => NS_USER );
		$out['nav_links'][] = array('text' => wfMsg('talkpage'), 'href' => Title::newFromText( $userspace, NS_USER_TALK )->getLocalUrl(), "dbkey" => NS_USER_TALK );
		$out['nav_links'][] = array('text' => wfMsg('blog-page'), 'href' => Title::newFromText( $userspace, NS_BLOG_ARTICLE )->getLocalUrl(), "dbkey" => NS_BLOG_ARTICLE );
		if( !$isAnon ) {
			$out['nav_links'][] = array('text' => wfMsg('contris'), 'href' => Title::newFromText( "Contributions/{$userspace}", NS_SPECIAL )->getLocalUrl() );
		}

		if ( $wgUser->isLoggedIn() && $wgUser->getName() == $userspace ) {
			$out['nav_links'][] = array('text' => wfMsg('prefs-watchlist'), 'href' => Title::newFromText("Watchlist", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Watchlist" );
			$out['nav_links'][] = array('text' => wfMsg('manage_widgets'), 'href' => Title::newFromText("WidgetDashboard", NS_SPECIAL )->getLocalUrl(), "dbkey" => "WidgetDashboard" );
			$out['nav_links'][] = array('text' => wfMsg('preferences'), 'href' => Title::newFromText("Preferences", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Preferences" );
		} elseif ( !$isAnon ) {
			$out['nav_links'][] = array('text' => wfMsg("emailpage"), 'href' => Title::newFromText( "EmailUser/{$userspace}", NS_SPECIAL )->getLocalUrl(), "dbkey" => "EmailUser" );
		}

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$tmpl->set_vars( array(
			'data' => $out,
			"avatar" => $Avatar,
			"current" => $dbKey
		));
		echo $tmpl->execute('UserMasthead');
	}
	return true;
}

?>
