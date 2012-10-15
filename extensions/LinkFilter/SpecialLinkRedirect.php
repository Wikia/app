<?php

class LinkRedirect extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LinkRedirect' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		$wgOut->setArticleBodyOnly( true );
		$sk = $wgUser->getSkin();
		$url = $wgRequest->getVal( 'url' );
		$wgOut->addHTML(
			"<html>
				<body onload=window.location=\"{$url}\">
				{$sk->bottomScripts( $wgOut )}
				</body>
			</html>"
		);

		return '';
	}
}