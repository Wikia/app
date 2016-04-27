<?php

/**
 * Crunchyroll
 *
 * A Crunchyroll extension for MediaWiki
 *
 * @author Jakub Kurcek  <jakub@wikia.inc>
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

class CrunchyrollAjax {

	/**
	 * Returns section html.
	 *
	 * @param $class string
	 * @return string
	 */

	static public function axGetPage(){
		global $wgRequest;

		$pageId = (int)$wgRequest->getVal( 'page' );
		$serieId = (int)$wgRequest->getVal( 'serie' );

		$crunchyroll = new CrunchyrollVideo();
		$crunchyroll->setSerieId( $serieId );

		return array(
			'page' => $crunchyroll->getPaginatedGallery( $pageId, true ),
			'paginator' => $crunchyroll->getBarHTML()
		);
	}
}

\Wikia\Logger\WikiaLogger::instance()->warning( 'Crunchyroll extension in use', [ 'file' => __FILE__ ] );
