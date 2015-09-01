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
		//TODO: use i18n message for title
		$this->wg->out->setHTMLTitle( 'Infobox Builder' );

		//TODO: get better way of handling $this->getPar() to deal with "/dadada/adasdasd"
		$url = $this->wg->server . '/' . infoboxBuilder . '/' . $this->getPar();

		$this->response->setVal('iframeUrl', $url);
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
