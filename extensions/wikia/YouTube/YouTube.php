<?php

/**
 * Parser hook-based extension to show audio and video players
 * from YouTube and other similar sites.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @author Sean Colombo <sean@wikia-inc.com> for Wikia, Inc.
 * @copyright (C) 2006-2011, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
 * USA
 *
 * @todo one class (family) to rule 'em all
 * @todo make width/height_max != width/height_default; aoaudio height may be large - long playlist
 * @todo smart <video> and <audio> tag
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension.\n";
	exit( 1 );
}

use Wikia\Logger\WikiaLogger;

$wgHooks['EditPage::importFormData'][] = 'upgradeYouTubeTag';

$wgExtensionCredits['parserhook'][] = array
(
	'name'    	     => 'YouTube',
	'version'  	     => '1.10',
	'author'   	     => array(
		'Przemek Piotrowski',
		'Sean Colombo'
	),
	'url'      	     => 'http://community.wikia.com/wiki/Help:YouTube',
	'descriptionmsg' => 'youtube-desc',
);

/**
 * SUS-3285 | Migrate from <youtube> tags to "properly" embed videos with file pages
 *
 * @param EditPage $editpage
 * @param $request
 * @return bool
 */
function upgradeYouTubeTag( EditPage $editpage, $request ): bool {
	$app = F::app();

	// Don't convert <youtube> tags if the user is not logged in or is blocked.
	// It provides a loophole for those users to upload video.
	if ( !$app->wg->User->isLoggedIn() ) {
		return true;
	}
	if ( $app->wg->User->isBlocked() ) {
		return true;
	}

	if ( !$app->wg->User->isAllowed( 'videoupload' ) ) {
		return true;
	}

	$text = $editpage->textbox1;

	// Note that we match <nowiki> here to consume that text and any possible
	// <youtube> tags within it.  We don't want to convert anything within <nowiki>
	$text = preg_replace_callback(
		'/(<nowiki>.*?<\/nowiki>)|(<youtube([^>]*)>([^<]+)<\/youtube>)/i',
		function ( $matches ) {
			// If we don't have a youtube match (its a nowiki tag) return as is
			if ( empty( $matches[2] ) ) {
				return $matches[0];
			}

			WikiaLogger::instance()->info( 'Youtube tag used', [
				'method' => __METHOD__
			] );

			// Separate the Youtube ID and parameters
			$paramText = trim( $matches[3] );
			// Node value can look like: <youtube_id>|400px|thumb|center
			// @TODO evaluate calling parser to parse params and upload correctly styled video
			$nodeValues = explode( '|', $matches[4] );
			$ytid = trim( $nodeValues[0] );

			// Check to see if the whole URL is used
			if ( preg_match( '/(?:youtube\.com\/watch\?(?:[^&]*&)*v=|youtu\.be\/)([^?&\n]+)/', $ytid, $ytidMatches ) === 1 ) {
				$ytid = $ytidMatches[1];
			}

			// Parse out the width and height parameters
			$params = parseSizeParams( $paramText );

			$url = 'https://www.youtube.com/watch?v=' . $ytid;

			$videoService = new VideoService();
			$videoFileUploader = new VideoFileUploader();
			$videoFileUploader->setExternalUrl( $url );
			$apiWrapper = $videoFileUploader->getApiWrapper();
			if ( !$apiWrapper->videoExists() ) {
				// ok, there's no video, don't touch the tag
				return $matches[0];
			}

			$retval = $videoService->addVideo( $url );

			if ( is_array( $retval ) ) {
				WikiaLogger::instance()->info( 'Youtube tag upgraded', [
					'method' => __METHOD__
				] );
				list( $title, $videoPageId, $videoProvider ) = $retval;
				return "[[$title|" . $params['width'] . "px]]";
			} else {
				return $matches[0];
			}
		} ,
		$text
	);
	$editpage->textbox1 = $text;
	return true;
}

function parseSizeParams ( $paramText ) {
	// Some limits and defaults
	$width_max  = 640;
	$height_max = 385;
	$width_def  = 425;
	$height_def = 355;

	// Parse out the width and height parameters
	$params = array();
	if ( preg_match_all( '/(width|height)\s*=\s*["\']?([0-9]+)["\']?/', $paramText, $paramMatches ) ) {
		$paramKeys = $paramMatches[1];
		$paramVals = $paramMatches[2];

		foreach ( $paramKeys as $key ) {
			$params[$key] = array_shift( $paramVals );
		}
	}

	// Fill in a default value if none was given
	if ( empty( $params['height'] ) ) {
		$params['height'] = $height_def;
	}
	if ( empty ( $params['width'] ) ) {
		$params['width']  = $width_def;
	}

	// Constrain the max height and width
	if ( $params['height'] > $height_max ) {
		$params['height'] = $height_max;
	}
	if ( $params['width'] > $width_max ) {
		$params['width'] = $width_max;
	}

	return $params;
}
