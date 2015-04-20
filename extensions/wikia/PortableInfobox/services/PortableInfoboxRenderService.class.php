<?php

class PortableInfoboxRenderService extends WikiaService {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'pair' => 'PortableInfoboxItemKeyVal.mustache'
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
			if ( !$item['isEmpty'] ) {
				// skip rendering for not supported type and log it
				if ( !isset( $this->templates[ $type ] ) ) {
					Wikia\Logger\WikiaLogger::instance()->info( self::LOGGER_LABEL, [
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
		return $this->templateEngine->clearData()
			->setData( $data )
			->render( $this->templates[ $type ] );
	}
}
