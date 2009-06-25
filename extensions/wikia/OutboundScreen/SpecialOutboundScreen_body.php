<?php

class Outbound extends UnlistedSpecialPage {
	private $redirectDelay = 0; // in seconds

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgOutboundScreenConfig;

		$this->redirectDelay = $wgOutboundScreenConfig['redirectDelay'];

		parent::__construct( 'Outbound'/*class*/ );
		wfLoadExtensionMessages( 'Outbound' ); // Load internationalization messages
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgExtensionsPath, $wgOutboundScreenConfig;

		$url = $wgRequest->getText( 'u' );

		$loggedIn = $wgUser->isLoggedIn();
		if(($wgOutboundScreenConfig['anonsOnly'] == true) && $loggedIn) {
			$wgOut->redirect( $url );
			return true;
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars(
				array(
					'url' => $url,
					'redirectDelay' => $this->redirectDelay,
					'imagesPath' => ($wgExtensionsPath . '/wikia/OutboundScreen/images')
					)
			);
		echo $oTmpl->execute('page');
		exit;
	}

}
