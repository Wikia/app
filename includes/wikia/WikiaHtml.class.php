<?php

class WikiaHtml extends Html {

	/**
	 * Output a <link rel=stylesheet> linking to the given URL for the given
	 * media type (if any).
	 *
	 * @param $url string
	 * @param $media mixed A media type string, like 'screen'
	 * @param $crossorigin mixed Configure the CORS requests for the fetched data
	 * @return string Raw HTML
	 */
	public static function linkedStyle( $url, $media = 'all', $crossorigin = null ) {
		$attribs = array(
			'rel' => 'stylesheet',
			'href' => $url,
			'type' => 'text/css',
			'media' => $media,
		);

		if ( $crossorigin !== null ) {
			$attribs['crossorigin'] = $crossorigin;
		}

		return self::element( 'link', $attribs );
	}

}
