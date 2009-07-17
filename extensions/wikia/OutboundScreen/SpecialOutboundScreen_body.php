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

		// output only template content
		$wgOut->setArticleBodyOnly(true);

		$skin = $wgUser->getSkin();
		$skinName = get_class($skin);

		// this may not be set yet
		if (empty($skin->skinname)) {
			$skin->skinname = substr($skinName, 4);
		}

		// add MW CSS
		$skin->setupUserCss($wgOut);

		// Monaco themes
		if ($skinName == 'SkinMonaco' && !empty($skin->themename)) {
			switch($skin->themename) {
				case 'custom':
					break;

				case 'sapphire':
					$wgOut->addStyle('monaco/css/root.css');
					break;

				default:
					$wgOut->addStyle('monaco/' . $skin->themename . '/css/main.css');
					break;
			}
		}

		// render <link> tags
		$css = $wgOut->buildCssLinks();

		// render template
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars(
				array(
					'url' => $url,
					'css' => $css,
					'redirectDelay' => $this->redirectDelay,
					'imagesPath' => $wgExtensionsPath . '/wikia/OutboundScreen/images',
				)
		);

		// just output content of template
		$wgOut->clearHTML();
		$wgOut->addHTML( $oTmpl->execute('page') );
	}
}
