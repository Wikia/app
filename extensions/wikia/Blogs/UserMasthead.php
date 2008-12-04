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

	$allowedNamespaces = array (
		0 => array(NS_BLOG_ARTICLE, NS_USER, NS_USER_TALK),
		1 => array(NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)
	);
	$allowedPages = array (
		0 => array('Watchlist', 'WidgetDashboard', 'Preferences'), 
		1 => array('Contributions')
	);
	
	if ( in_array( $namespace, array_merge($allowedNamespaces[0], $allowedNamespaces[1]) ) || 
		 ( ($namespace == NS_SPECIAL) && ( in_array( $dbKey, array_merge($allowedPages[0],$allowedPages[1]) ) ) ) 
	) {
		/**
		 * change dbkey for nonspecial articles, in this case we use NAMESPACE
		 * as key
		 */
		if ( $namespace != NS_SPECIAL ) {
			$dbKey = $namespace;
		}
		
		/* hides article/talk tabs in Monaco.php */
		$userMasthead = true; 
		$Avatar = null;
		$userspace = "";
		$out = array();
		/* check conditions */
		if ( in_array( $namespace, $allowedNamespaces[0] ) ) {
			#---
			$userspace = $wgTitle->getBaseText();
			$Avatar = BlogAvatar::newFromUserName( $userspace );
		} 
		if ( in_array( $namespace, $allowedNamespaces[1] ) || in_array( $dbKey, $allowedPages[0] ) ) {
			#---
			$userspace = $wgUser->getName();
			$Avatar = BlogAvatar::newFromUser( $wgUser );
		}

		if ( in_array( $dbKey, $allowedPages[1] ) ) {
			$reqTitle = $wgRequest->getText("title", false);
			if ( strpos( $reqTitle, "/") !== false ) {
				list ( , $userspace ) = explode( "/", $reqTitle, 2 );
				$Avatar = BlogAvatar::newFromUserName( $userspace );
			} else {
				$userspace = $wgUser->getName();
				$Avatar = BlogAvatar::newFromUser( $wgUser );
			}
		}
		if ($userspace != "") {
			$out['userspace'] = $userspace;

			$oTitle = Title::newFromText( $userspace, NS_USER ); 
			if ($oTitle instanceof Title) {
				$out['nav_links'][] = array('text' => wfMsg('nstab-user'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_USER );
			}
			$oTitle = Title::newFromText( $userspace, NS_USER_TALK ); 
			if ($oTitle instanceof Title) {
				$out['nav_links'][] = array('text' => wfMsg('talkpage'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_USER_TALK );
			}
			$oTitle = Title::newFromText( $userspace, NS_BLOG_ARTICLE ); 
			if ($oTitle instanceof Title) {
				$out['nav_links'][] = array('text' => wfMsg('blog-page'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_BLOG_ARTICLE );
			}
			if( !$isAnon ) {
				$oTitle = Title::newFromText( "Contributions/{$userspace}", NS_SPECIAL ); 
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg('contris'), 'href' => $oTitle->getLocalUrl(), "dbkey" => "Contributions" );
				}
			}

			if ( $wgUser->isLoggedIn() && $wgUser->getName() == $userspace ) {
				$out['nav_links'][] = array('text' => wfMsg('prefs-watchlist'), 'href' => Title::newFromText("Watchlist", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Watchlist" );
				$out['nav_links'][] = array('text' => wfMsg('blog-widgets-label'), 'href' => Title::newFromText("WidgetDashboard", NS_SPECIAL )->getLocalUrl(), "dbkey" => "WidgetDashboard" );
				$out['nav_links'][] = array('text' => wfMsg('preferences'), 'href' => Title::newFromText("Preferences", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Preferences" );
			} elseif ( !$isAnon ) {
				$oTitle = Title::newFromText( "EmailUser/{$userspace}", NS_SPECIAL ); 
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg("emailpage"), 'href' => $oTitle->getLocalUrl(), "dbkey" => "EmailUser" );
				}
			}

			$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$tmpl->set_vars( array(
				'data' => $out,
				"avatar" => $Avatar,
				"userspace" => $userspace,
				"current" => $dbKey
			));
			echo $tmpl->execute('UserMasthead');
		}
	}
	return true;
}
