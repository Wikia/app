<?php
/**
 * Class WikiaMapsSpecialController
 * @desc Special:Maps controller
 */
class PortableInfoboxBuilderSpecialController extends WikiaSpecialPageController {
	const PAGE_NAME = 'PortableInfoboxBuilder';
	const PAGE_RESTRICTION = 'editinterface';
	const INFOBOX_BUILDER_MERCURY_ROUTE = 'infoboxBuilder';

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

	/**
	 * Infobox Builder special page
	 */
	public function index() {
		$this->wg->SuppressPageHeader = true;
		$this->wg->out->setHTMLTitle( wfMessage( 'portable-infobox-builder-tite' )->plain() );

		$title = $this->getTemplateTitle( $this->getPar() );
		$noTemplateSet = empty( $title ) ? true : false;

		if ( $noTemplateSet ) {
			$this->response->setVal('noTemplateSet', true );
			$this->response->setVal('setTemplateNameCallToAction', wfMessage(
				'portable-infobox-builder-no-template-title-set' )->plain() );
		} else {
			$url = $this->wg->server . '/' . self::INFOBOX_BUILDER_MERCURY_ROUTE . '/' . $title;
			$this->response->setVal( 'iframeUrl', $url );
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * renders HTML for create new template page entry point
	 */
	public function renderCreateTemplateEntryPoint() {
		$this->response->setVal( 'createInfobox', wfMessage(
			'portable-infobox-builder-create-template-entry-point-create-infobox' )->plain() );
		$this->response->setVal( 'createTemplate', wfMessage(
			'portable-infobox-builder-create-template-entry-point-create-regular-template' )->plain() );
		$this->response->setVal( 'title', $this->request->getVal('title'), '' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @desc return template title base of the URL path
	 * @param string $par - URL path after Special:PortableInfoboxBuilder/
	 * @return string
	 */
	private function getTemplateTitle( $par ) {
		$slicePos = strpos( $par, '/' );

		return urlencode( is_int( $slicePos ) ? substr( $par, 0, $slicePos ) : $par );
	}
}
