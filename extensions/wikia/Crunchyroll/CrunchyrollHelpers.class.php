<?php

/**
 * CrunchyrollHelpers class
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2010-10-11
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class CrunchyrollHelpers {

	static public function makeCrunchyrollGallery( $contents, $attributes, $parser ) {

		$crunchyRollVideo = new CrunchyrollVideo();

		if ( isset( $attributes['serie'] ) ){
			$crunchyRollVideo->setSerie( $attributes['serie'] );
		}

		if ( isset( $attributes['serieid'] ) ){
			$crunchyRollVideo->setSerieId( $attributes['serieid'] );
		}

		if ( isset( $attributes['number'] ) ){
			$crunchyRollVideo->setNumber( $attributes['number'] );
		} else {
			$crunchyRollVideo->setNumber( 6 );
		}

		return $crunchyRollVideo->getGallery();

	}

	static public function crunchyrollSetup( Parser &$parser ) {

		$parser->setHook( 'crunchyroll', 'CrunchyrollHelpers::makeCrunchyrollGallery' );

		return true;
	}
}

\Wikia\Logger\WikiaLogger::instance()->warning( 'Crunchyroll extension in use', [ 'file' => __FILE__ ] );
