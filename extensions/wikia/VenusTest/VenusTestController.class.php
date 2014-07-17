<?php
class VenusTestController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('VenusTest', '', false);
	}

	/**
	 * Main page for Special:VenusTest page
	 * 
	 * @return boolean
	 */
	public function index() {
		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->request->setVal('useskin', 'venus');

		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_NAV_ONLY );
		$this->response->addAsset( 'extensions/wikia/Venus/styles/Venus.scss' );
		$this->response->addAsset( 'extensions/wikia/VenusTest/styles/VenusTest.scss' );

		$this->wg->Out->setPageTitle( wfMessage( 'special-venustest-title' )->plain() );
		$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);

		$this->wg->Out->clearHTML();
		$this->wg->Out->addHtml( ( new Wikia\Template\MustacheEngine )
				->setPrefix( dirname( __FILE__ ) . '/templates' )
				->setData( [] )
				->render( 'VenusTest_index.mustache' )
		);

		// skip rendering
		$this->skipRendering();

		return true;
	}

	public static function onGetSkin(RequestContext $context, &$skin) {
		$skin = new SkinVenus();

		return false;
	}
}
