<?php

class OpenGraphImageHelper {
	public static function getUrl(): string {
		$cacheTTL = 3600; // an hour

		return \WikiaDataAccess::cache( wfMemcKey( 'opengraph-image-helper' ), $cacheTTL,
			function () {
				$wikiPng = 'Wiki.png';

				try {
					return WikiaFileHelper::getFileFromTitle( $wikiPng )->transform( [
						'width' => 1200,
					] )->getUrl();
				}
				catch ( Error $error ) {
					return '';
				}
			} );
	}
}
