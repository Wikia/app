<?php

/**
 * Class PortableInfoboxBuilderSpecialController
 * @desc Special:InfoboxBuilder controller
 */
class PortableInfoboxBuilderSpecialController extends WikiaSpecialPageController {
	const PAGE_NAME = 'InfoboxBuilder';
	const PAGE_RESTRICTION = 'editinterface';
	const INFOBOX_BUILDER_MERCURY_ROUTE = 'infobox-builder';

	/**
	 * Special page constructor
	 *
	 * @param null $name
	 * @param string $restriction
	 * @param bool $listed
	 * @param bool $function
	 * @param string $file
	 * @param bool $includable
	 * @throws WikiaException
	 */
	public function __construct( $name = null, $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( self::PAGE_NAME, self::PAGE_RESTRICTION, $listed, $function, $file, $includable );
	}

	/**
	 * @throws MWException
	 */
	public function index() {
		$this->getOutput()->setHTMLTitle( wfMessage( 'portable-infobox-builder-title' )->text() );
		$this->forward( __CLASS__, $this->getMethodName() );
	}

	public function builder() {
		global $wgScriptPath;

		$title = $this->getPar();
		OasisController::addHtmlClass( 'full-screen-page' );
		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_GLOBAL_NAV_ONLY );
		Wikia::addAssetsToOutput( 'portable_infobox_builder_scss' );
		$this->response->setVal(
			'iframeUrl',
			wfExpandUrl(
				sprintf( '%s/%s/%s', $wgScriptPath, self::INFOBOX_BUILDER_MERCURY_ROUTE, $title )
			)
		);
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @throws MWException
	 */
	public function sourceEditor() {
		$this->getOutput()->redirect(Title::newFromText($this->getPar(), NS_TEMPLATE)->getEditURL());
	}

	/**
	 * @desc Decide what method to use according to rule, that we should redirect
	 * to source editor only when there's not supported infobox markup in the template.
	 * @return string
	 * @throws \MWException
	 */
	private function getMethodName() {
		if ( !empty( $this->getPar() ) ) {
			$title = Title::newFromText( $this->getPar(), NS_TEMPLATE );
			$infoboxes = PortableInfoboxDataService::newFromTitle( $title )->getInfoboxes();

			if (! ( new PortableInfoboxBuilderService() )->isValidInfoboxArray( $infoboxes ) ) {
				return 'sourceEditor';
			}
		}

		return 'builder';
	}
}
