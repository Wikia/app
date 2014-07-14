<?php
class VenusTestController extends WikiaSpecialPageController {
	protected  $model;

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

		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_NAV_ONLY );
		$this->response->addAsset( 'extensions/wikia/Venus/styles/Venus.scss' );

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
}
