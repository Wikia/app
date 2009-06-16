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

	function execute($url) {
		global $wgRequest;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$fragment = $wgRequest->getText( 'f' );
		if ( !empty( $fragment ) )
			$url .= '#' . $fragment;

		$oTmpl->set_vars(
				array(
					'url' => $url,
					'redirectDelay' => $this->redirectDelay
					)
			);
		echo $oTmpl->execute('page');
		exit;
	}

}
