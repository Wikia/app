<?php

class PortableInfoboxRenderService extends WikiaService {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'key' => 'PortableInfoboxItemKeyVal.mustache'
	];
	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
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
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];

			if ( !empty( $data[ 'value' ] ) ) {
				// skip rendering for not supported type and log it
				if ( !isset( $this->templates[ $type ] ) ) {
					Wikia\Logger\WikiaLogger::instance()->info( LOGGER_LABEL, [
						'type' => $type
					] );
					continue;
				}
				$infoboxHtmlContent .= $this->renderItem( $type, $data );
			}
		}

		return $this->renderItem( 'wrapper', [ 'content' => $infoboxHtmlContent ] );
	}

	/**
	 * renders part of infobox
	 *
	 * @param string $type
	 * @param array $data
	 * @return string - HTML
	 */
	private function renderItem( $type, array $data ) {
		$this->templateEngine->clearData();
		$this->templateEngine->setData( $data );
		return $this->templateEngine->render( $this->templates[ $type ] );
	}
}
