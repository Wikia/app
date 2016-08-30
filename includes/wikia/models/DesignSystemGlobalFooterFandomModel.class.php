<?php

class DesignSystemGlobalFooterFandomModel extends DesignSystemGlobalFooterModel {

	public function __construct( $id, $lang = self::DEFAULT_LANG ) {
		parent::__construct( $id, $lang = self::DEFAULT_LANG );
	}

	protected function getSitenameData() {
		return [
			'type' => 'text',
			'value' => 'Fandom'
		];
	}

	protected function getLocalSitemapUrl() {
		return $this->getHref( 'local-sitemap-fandom' );
	}
}
