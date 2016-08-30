<?php

/**
 * Class WikiaMapsSpecialController
 * @desc Special:Maps controller
 */
class PortableInfoboxBuilderSpecialController extends WikiaSpecialPageController {
	const PAGE_NAME = 'InfoboxBuilder';
	const PAGE_RESTRICTION = 'editinterface';
	const INFOBOX_BUILDER_MERCURY_ROUTE = 'infobox-builder';
	const PATH_SEPARATOR = '/';
	const EXPLODE_LIMIT = 2;

	/**
	 * Special page constructor
	 *
	 * @param null $name
	 * @param string $restriction
	 * @param bool $listed
	 * @param bool $function
	 * @param string $file
	 * @param bool $includable
	 */
	public function __construct( $name = null, $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( self::PAGE_NAME, self::PAGE_RESTRICTION, $listed, $function, $file, $includable );
	}

	public function index() {
		$this->wg->out->setHTMLTitle( wfMessage( 'portable-infobox-builder-title' )->text() );
		$this->forward( __CLASS__, $this->getMethodName() );
	}

	public function builder() {
		$title = $this->getPar();
		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_GLOBAL_NAV_ONLY );

		$this->response->addAsset( 'portable_infobox_builder_scss' );
		$this->response->addAsset( 'portable_infobox_scss' );
		$this->response->addAsset( 'portable_infobox_js' );

		$url = implode( self::PATH_SEPARATOR, [ $this->wg->server, self::INFOBOX_BUILDER_MERCURY_ROUTE, $title ] );
		$this->response->setVal( 'iframeUrl', $url );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function sourceEditor() {
		$this->wg->out->redirect(Title::newFromText($this->getPar(), NS_TEMPLATE)->getEditURL());
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
