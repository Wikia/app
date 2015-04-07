<?php
class PortableInfoboxRenderService extends WikiaService {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper',
		'title' => 'PortableInfoboxItemTitle',
		'image' => 'PortableInfoboxItemImage',
		'keyVal' => 'PortableInfoboxItemKeyVal'
	];
	private $templateEngine;

	function __construct() {
		$this->templateEngine = (new Wikia\Template\MustacheEngine)->setPrefix( dirname(__FILE__) . '/templates' );
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata ) {
		$infoboxHtmlContent = '';

		foreach ( $infoboxdata as $item ) {
			$data = $item['data'];
			$type = $item['type'];

			if ( !empty( $data['value'] ) ) {

				// skip rendering for not supported type and log it
				if ( array_key_exists( $type, $this->templates ) ) {
					Wikia\Logger\WikiaLogger::instance()->info( LOGGER_LABEL, [
						'type' => $type
					] );

					continue;
				}

				$infoboxHtmlContent .= $this->renderItem( $type, $data );
			}
		}

		return $this->renderItem( ['content' => $infoboxHtmlContent], 'wrapper' );
	}

	/**
	 * renders part of infobox
	 *
	 * @param string $type
	 * @param array $data
	 * @return string - HTML
	 */
	private function renderItem( string $type, array $data ) {
		return $this->templateEngine
			->clearValues()
			->setValues( $data )
			->render( $this->templates[$type] );
	}
}
