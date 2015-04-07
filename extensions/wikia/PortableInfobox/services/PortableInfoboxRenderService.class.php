<?php
class PortableInfoboxRenderService extends WikiaService {
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

	public function renderInfobox( array $infoboxdata ) {
		$infoboxHtmlContent = '';

		foreach ( $infoboxdata as $item ) {
			if ( !empty( $item['value'] ) ) {
				$infoboxHtmlContent .= $this->renderItem( $item['type'], $item['data'] );
			}
		}

		return $this->renderItem( ['content' => $infoboxHtmlContent], 'wrapper' );
	}

	private function renderItem( string $type, array $data ) {
		return $this->templateEngine
			->clearValues()
			->setValues( $data )
			->render( $this->templates[$type] );
	}
}
