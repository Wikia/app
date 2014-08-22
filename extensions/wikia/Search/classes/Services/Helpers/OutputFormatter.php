<?php

namespace Wikia\Search\Services\Helpers;

use WikiFactory;

class OutputFormatter {
	const WIKIA_URL_REGEXP = '|^(http(s?)://)(([^\.]+)\.wikia\.com)|';

	public static function replaceHostUrl( $url ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;
		if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
			return preg_replace_callback(
				static::WIKIA_URL_REGEXP, ['Wikia\Search\Services\Helpers\OutputFormatter', 'replaceHost'], $url );
		}
		return $url;
	}

	public static function replaceHost( $details ) {
		return $details[ 1 ] . WikiFactory::getCurrentStagingHost( $details[ 4 ], $details[ 3 ] );
	}
}