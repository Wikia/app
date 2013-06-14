<?php

/**
 * Class SpecialStyleguideController
 * Controller that handles Special:Styleguide page
 */
class SpecialStyleguideController extends WikiaSpecialPageController {

	/**
	 * @var $model SpecialStyleguideDataModel
	 */
	private $model;

	public function __construct() {
		parent::__construct( 'Styleguide' );
		$this->model = new SpecialStyleguideDataModel();
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_NAV_ONLY );
		$this->response->addAsset( 'extensions/wikia/SpecialStyleguide/css/SpecialStyleguide.scss' );
		$this->wg->Out->setPageTitle( wfMessage( 'styleguide-pagetitle' )->plain() );

		$this->app->setGlobal( 'wgAutoloadClasses', dirname( __FILE__ ) . '/SpecialStyleguideGlobalHeaderControllerOverride.php', 'GlobalHeaderController' );

		$this->response->setCacheValidity(
			86400,
			86400,
			[
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			]
		);

		$this->wg->Out->clearHTML();
		$this->wg->Out->addHtml( ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( [
				'header' => $this->getSectionContent( 'header' ),
				'body' => $this->getSectionContent( 'home' ),
				'footer' => $this->getSectionContent( 'footer' ), ] )
			->render( 'SpecialStyleguide_index.mustache' )
		);

		wfProfileOut( __METHOD__ );

		// skip rendering
		$this->skipRendering();
	}

	/**
	 * Returns rendered content of section given as param
	 *
	 * @param $sectionName string
	 * @return string
	 */
	public function getSectionContent( $sectionName ) {
		return ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $this->model->getSectionData( $sectionName ) )
			->render( 'SpecialStyleguide_' . $sectionName . '.mustache' );
	}
}
