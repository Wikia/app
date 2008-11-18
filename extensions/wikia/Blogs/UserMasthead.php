<?php
$wgHooks['MonacoBeforePageBar'][] = 'userMasthead';

function userMasthead() {
	global $wgTitle, $wgUser, $userMasthead, $wgOut, $wgExtensionsPath, $wgStyleVersion;

	$wgOut->addHtml("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/Blogs/css/UserMasthead.css?{$wgStyleVersion}\" />");
	$namespace = $wgTitle->getNamespace();
	if ( $namespace == NS_BLOG_ARTICLE || $namespace == NS_USER || $namespace == NS_USER_TALK || $namespace == NS_SPECIAL && ($wgTitle->getDBkey() == 'Watchlist' || $wgTitle->getDBkey() == 'EmailUser' || $wgTitle->getDBkey() == 'WidgetDashboard' || $wgTitle->getDBkey() == 'Preferences')) {

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
			array('text' => 'User page', 'href' => Title::newFromText( $userspace, NS_USER )->getLocalUrl() ),
			array('text' => 'Talk page', 'href' => Title::newFromText( $userspace, NS_USER_TALK )->getLocalUrl() ),
			array('text' => 'Blog', 'href' => Title::newFromText( $userspace, NS_BLOG_ARTICLE )->getLocalUrl() ),
			array('text' => 'Contributions', 'href' => 'http://www.framezero.com')
		);

		if ( $wgUser->isLoggedIn() && $wgUser->getName() == $userspace) {
			$out['nav_links'][] = array('text' => 'Watchlist', 'href' => Title::newFromText("Watchlist", NS_SPECIAL )->getLocalUrl());
			$out['nav_links'][] = array('text' => 'Widget Dashboard', 'href' => Title::newFromText("WidgetDashboard", NS_SPECIAL )->getLocalUrl());
			$out['nav_links'][] = array('text' => 'Preferences', 'href' => Title::newFromText("Preferences", NS_SPECIAL )->getLocalUrl());
		} else {
			$out['nav_links'][] = array('text' => 'email user', 'href' => $wgTitle);
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
