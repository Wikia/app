<?php

/**
 * Special page with map editor interface using Google Maps.
 *
 * @since 2.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialMapEditor extends SpecialPage{

	/**
	 * @see SpecialPage::__construct
	 *
	 * @since 2.0
	 */
	public function __construct() {
		parent::__construct( 'MapEditor' );
	}

	/**
	 * @see SpecialPage::execute
	 *
	 * @since 2.0
	 *
	 * @param null|string $subPage
	 */
	public function execute( $subPage ) {
		$this->setHeaders();

		$outputPage = $this->getOutput();

		$outputPage->addHtml( MapsGoogleMaps3::getApiScript(
			$this->getLanguage()->getCode(),
			array( 'libraries' => 'drawing' )
		) );

		$outputPage->addModules( 'mapeditor' );
        $editorHtml = new MapEditorHtml( $this->getAttribs() );
		$html = $editorHtml->getEditorHtml();
		$outputPage->addHTML( $html );
	}

	/**
	 * @since 2.1
	 *
	 * @return array
	 */
	protected function getAttribs(){
		return array(
            'id' => 'map-canvas',
            'context' => 'SpecialMapEditor'
        );
	}

	protected function getGroupName() {
		return 'maps';
	}
}
