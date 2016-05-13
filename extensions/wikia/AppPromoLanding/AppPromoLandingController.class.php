<?php

/**
 * Main class for the AppPromoLanding screen.  This comandeers /wiki/Community_App and displays
 * a page with very-little chrome on it that will let a user send the app link to their phone.
 *
 * @author Sean Colombo
 */
class AppPromoLandingController extends WikiaController {
	
	private static $extraBodyClasses = []; // TODO: REMOVE - ONLY DURING THE TEMPORARY COPYING OF OASISCONTROLLER

	const RESPONSE_OK = 200;

	/**
	 * Render HTML for whole App Promo Landing page.
	 */
	public function executeIndex() {
		// Since this "Community_App" article won't be found, we need to manually say it's okay so that it's not a 404.
		$this->response->setCode(self::RESPONSE_OK);

		// render the custom App Promo Landing body (this includes the nav bar and the custom content).
		$body = F::app()->renderView('AppPromoLanding', 'Content');

		// page has one column
		OasisController::addBodyClass('oasis-one-column');

		// adding 'appPromo' class as a CSS helper
		OasisController::addBodyClass('appPromo');

		// temporary grid transition code, remove after transition
		OasisController::addBodyClass('WikiaGrid');

		// render Oasis module to the 'html' var which the AppPromoLanding_index template will just dump out.
		$this->html = F::app()->renderView( 'Oasis', 'Index', array('body' => $body) );
	}

	/**
	 * This part of the controller is responsible for dumping the "body" of the page which
	 * will include both the standard Wikia GlobalNavigation
	 */
	public function executeContent(){
		wfProfileIn( __METHOD__ );

		// render global and user navigation
		$this->header = F::app()->renderView( 'GlobalNavigation', 'index' );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * We use the same general trick that Special:Chat uses to basically redirect rendering
	 * to be done by a specific Oasis module.  However, instead of being located inside of
	 * a special page, we are doing this by stealing the "Community_App" article title.
	 */
	public static function onOutputPageBeforeHTML( OutputPage &$out, &$text ){
		$title = $out->getTitle();
		$origTitle = $title->getDBkey();
		if($origTitle == "Community_App"){
			Wikia::setVar( 'OasisEntryControllerName', 'AppPromoLanding' );

			// TODO: CREATE AppPromoLanding MODULE IN ResourceLoader
			//$out->addModules( 'ext.AppPromoLanding' );
		}
		return $out;
	}
}
