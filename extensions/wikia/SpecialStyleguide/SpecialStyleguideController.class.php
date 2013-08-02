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
		global $wgAutoloadClasses;
		wfProfileIn( __METHOD__ );

		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_NAV_ONLY );
		$this->response->addAsset( 'extensions/wikia/SpecialStyleguide/css/SpecialStyleguide.scss' );
		$this->wg->Out->setPageTitle( wfMessage( 'styleguide-pagetitle' )->plain() );

		$wgAutoloadClasses['GlobalHeaderController'] = dirname( __FILE__ ) . '/SpecialStyleguideGlobalHeaderControllerOverride.php';

		$this->response->setCacheValidity(
			86400,
			86400,
			[
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			]
		);

		$subpage = mb_strtolower( $this->getFirstTextAfterSlash( $this->wg->Title->getSubpageText() ) );

		switch( $subpage ) {
			case 'components':
				$data = [
					'header' => $this->getSectionContent( 'header/components' ),
					'body' => $this->getSectionContent( 'components' ),
					'footer' => $this->getSectionContent( 'footer' ),
				];
				break;
			default:
				$data = [
					'header' => $this->getSectionContent( 'header' ),
					'body' => $this->getSectionContent( 'home' ),
					'footer' => $this->getSectionContent( 'footer' ), 
				];
				break;
		}

		$this->wg->Out->clearHTML();
		$this->wg->Out->addHtml( ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $data )
			->render( 'SpecialStyleguide_index.mustache' )
		);

		wfProfileOut( __METHOD__ );

		// skip rendering
		$this->skipRendering();
	}

	private function getFirstTextAfterSlash( $subpageText ) {
		$supageArr = explode( '/', $subpageText );
		return ( !empty($supageArr[1]) ) ? $supageArr[1] : '';
	}

	/**
	 * Returns rendered content of section given as param
	 *
	 * @param $sectionName string
	 * @return string
	 */
	public function getSectionContent( $sectionName ) {
		$sectionArray = explode( '/', $sectionName );
		$templateSectionName = $sectionArray[0];
		
		return ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $this->model->getPartOfSectionData( $sectionArray ) )
			->render( 'SpecialStyleguide_' . $templateSectionName . '.mustache' );
	}
}
