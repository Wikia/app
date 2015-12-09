<?php

/**
 * Controller for Wikia's Special:ImageReview page
 * We use a custom extension for this because we deploy via package, not via repo.
 * @author rwilinski
 *
 */
class ImageReviewMercuryController extends WikiaSpecialPageController {
	/**
	 * Constructor method. Overrides the original Special:Version page.
	 */
	public function __construct() {
		$this->version = (new ImageReviewMercury);

		parent::__construct( 'Version' );
	}

	public function index() {
		$title = Title::newFromText( 'Version', NS_SPECIAL );
		$popts = ParserOptions::newFromContext( RequestContext::getMain() );

		$this->wg->Title = $title;
		$this->specialPage->setHeaders();

		$this->setVal( 'wikiaCodeVersion', $this->version->getWikiaCodeVersion() );
	}

	function urlHandler () {
		$this->response->addAsset( 'fooandbar_js' );
		$this->response->addAsset( 'fooandbar_scss' );
		$this->response->addAsset( 'fooandbar_css' );

		// Interface code
		// ...

		// Data to be used in FooAndBarController_urlhandler.php template
		$this->templateValue = 'foo';
	}
}
