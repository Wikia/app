<?php

class WikiaHtml extends Html {

	/**
	 * Output a <link rel=stylesheet> linking to the given URL for the given
	 * media type (if any).
	 *
	 * @param $url string
	 * @param $extendAttributes array HTML attributes to extend: rel, href, type, media
	 * @return string Raw HTML
	 */
	public static function linkedStyle( $url, $extendAttributes ) {
		$defaultAttrib = [
			'rel' => 'stylesheet',
			'href' => $url,
			'type' => 'text/css',
			'media' => 'all',
		];

		$attribs = array_merge(
			$defaultAttrib,
			(array) $extendAttributes
		);

		return self::element( 'link', $attribs );
	}

}
