<?php
$wgHooks['MonacoBeforePageBar'][] = 'userMasthead';

function userMasthead() {
	global $wgTitle, $wgUser, $userMasthead, $wgOut, $wgExtensionsPath, $wgStyleVersion;

	$wgOut->addHtml("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/Blogs/css/UserMasthead.css?{$wgStyleVersion}\" />");
	$namespace = $wgTitle->getNamespace();
	if ( $namespace == NS_BLOG_ARTICLE || $namespace == NS_USER || $namespace == NS_USER_TALK || $namespace == NS_SPECIAL && ($wgTitle->getDBkey() == 'Watchlist' || $wgTitle->getDBkey() == 'WidgetDashboard' || $wgTitle->getDBkey() == 'Preferences')) {

		$userMasthead = true; //hides article/talk tabs in Monaco.php
		$out = array();
		//DEFINE USERSPACE - THE USERNAME THAT BELONGS ON THE MASTHEAD
		if ( in_array( $namespace, array( NS_USER, NS_USER_TALK, NS_BLOG_ARTICLE ) ) ) {
			$userspace = $wgTitle->getDBkey();
		}
		if ($wgTitle == 'Special:Watchlist' || $wgTitle == 'Special:WidgetDashboard' || $wgTitle == 'Special:Preferences' ) {
			$userspace = $wgUser->getName();
		}
		$out['userspace'] = $userspace;

		$out['nav_links'] = array (
			array('text' => wfMsg('nstab-user'), 'href' => Title::newFromText( $userspace, NS_USER )->getLocalUrl() ),
			array('text' => wfMsg('talkpage'), 'href' => Title::newFromText( $userspace, NS_USER_TALK )->getLocalUrl() ),
			array('text' => wfMsg('blog-page'), 'href' => Title::newFromText( $userspace, NS_BLOG_ARTICLE )->getLocalUrl() ),
			array('text' => wfMsg('contris'), 'href' => Title::newFromText( "Contributions/{$userspace}", NS_SPECIAL )->getLocalUrl() )
		);

		if ( $wgUser->isLoggedIn() && $wgUser->getName() == $userspace ) {
			$out['nav_links'][] = array('text' => wfMsg('prefs-watchlist'), 'href' => Title::newFromText("Watchlist", NS_SPECIAL )->getLocalUrl());
			$out['nav_links'][] = array('text' => wfMsg('manage_widgets'), 'href' => Title::newFromText("WidgetDashboard", NS_SPECIAL )->getLocalUrl());
			$out['nav_links'][] = array('text' => wfMsg('preferences'), 'href' => Title::newFromText("Preferences", NS_SPECIAL )->getLocalUrl());
		} else {
			$out['nav_links'][] = array('text' => wfMsg("emailpage"), 'href' => Title::newFromText( "EmailUser/{$userspace}", NS_SPECIAL )->getLocalUrl());
		}

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$tmpl->set_vars( array(
			'data' => $out
		));
		echo $tmpl->execute('UserMasthead');
	}
	return true;
}

?>
