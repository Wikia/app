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

// Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfYouTube';

// Initialize magic word for the parserfunction(s).
$wgHooks['LanguageGetMagic'][] = 'wfParserFunction_magic';

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

// i18n
$wgExtensionMessagesFiles['YouTube'] = __DIR__ . '/YouTube.i18n.php';

// Define the tallest a video can be to qualify as audio only
define( 'AUDIO_ONLY_HEIGHT', 30 );

// Register the magic word "youtube" so that it can be used as a parser-function.
function wfParserFunction_magic( &$magicWords, $langCode ) {
	global $wgAllowNonPremiumVideos;

	if ( !$wgAllowNonPremiumVideos ) {
		return true;
	}

	$magicWords['youtube'] = array( 0, 'youtube' );
	return true;
}

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

			// If height is less than 30, they probably are using this as an audio file
			// so don't bother converting it.
			if ( $params['height'] <= AUDIO_ONLY_HEIGHT ) {
				return $matches[0];
			}

			$url = 'https://www.youtube.com/watch?v=' . $ytid;

			$videoService = new VideoService();
			$videoFileUploader = new VideoFileUploader();
			$videoFileUploader->setExternalUrl( $url );
			$apiWrapper = $videoFileUploader->getApiWrapper();
			if ( !$apiWrapper->videoExists() ) {
				return createRawOutput( $matches[0] );
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

/**
 * Create raw value which would be displayed inside article and no object would be created.
 *
 * @param string $value
 * @return string
 */
function createRawOutput( $value ) {
	return '<nowiki>' . $value . '</nowiki>';
}

/**
 * @param Parser $parser
 * @return bool
 */
function wfYouTube( Parser $parser ): bool {
	global $wgAllowNonPremiumVideos;

	if ( !$wgAllowNonPremiumVideos ) {
		return true;
	}
	$parser->setHook( 'youtube', 'embedYouTube' );
	$parser->setFunctionHook( 'youtube', 'wfParserFunction_youTube' );

	return true;
}

function embedYouTube_url2ytid( $url ) {
	$id = $url;

	if ( preg_match( '/^https?:\/\/www\.youtube\.com\/watch\?v=(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	} elseif ( preg_match( '/^https?:\/\/www\.youtube\.com\/v\/([^&]+)(&autoplay=[0-1])?$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9A-Za-z_-]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

/**
 * Parser-function for #youtube.  The purpose of having this in addition to the parser-tag is that
 * parser-functions can receive template-parameters as input so this parser function can be used
 * in a template.
 *
 * Example usage:
 * {{#youtube:Vd34vJohGXc|250|209}}
 */
function wfParserFunction_youTube( $parser, $ytid = '', $width = '', $height = '' ) {
	$width = ( $width == "" ? "":" width='$width'" );
	$height = ( $height == "" ? "":" height='$height'" );
	$output = "<youtube ytid='$ytid'$width$height/>";

	// Note: an alternate way to do this would be to set up parameters and call embedYouTube directly (and the returned output
	// would not need to still be made parseable).  Any benefit to that?  The current way seems more easily debuggable by the end-user if they mess up.

	// Return the code in such a way that it still gets parsed (since we're just returning the parsertag).
	return array( $output, 'noparse' => false );
} // end wfParserFunction_youTube()

function embedYouTube( $input, $argv, $parser ) {
	// $parser->disableCache();

	$ytid   = '';
	$width_max  = 640;
	$height_max = 385;
	$width  = 425;
	$height = 355;

	if ( !empty( $argv['ytid'] ) ) {
		$ytid = embedYouTube_url2ytid( $argv['ytid'] );
	} elseif ( !empty( $input ) ) {
		$ytid = embedYouTube_url2ytid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	// If $wgAllVideosAdminOnly is set and is above the allowed audio only height
	// then don't convert this.  Without this, a non-admin could add a full sized youtube
	// tag that would not get upgraded to a file page on save, but remain a <youtube> tag.
	// The non-admin would continue to see this, but the admin would see the
	// youtube video player.
	global $wgAllVideosAdminOnly;
	if ( ( $height > AUDIO_ONLY_HEIGHT ) && $wgAllVideosAdminOnly ) {
		return $input;
	}

	if ( !empty( $ytid ) ) {
		WikiaLogger::instance()->info( 'Embedding youtube: ' . $ytid, [
			'method' => __METHOD__,
			'video_source' => 'youtube'
		] );
		$url = "https://www.youtube.com/v/{$ytid}&enablejsapi=1&version=2&playerapiid={$ytid}"; // it's not mistake, there should be &, not ?
		return "<object type=\"application/x-shockwave-flash\" data=\"{$url}\" width=\"{$width}\" height=\"{$height}\" id=\"YT_{$ytid}\"><param name=\"movie\" value=\"{$url}\"/><param name=\"wmode\" value=\"transparent\"/><param name=\"allowScriptAccess\" value=\"always\"/></object>";
	}
}

function embedYouTube_url2tgid( $input ) {
	$tid = $gid = 0;

	if ( preg_match( '/^id=([0-9]+)\|gId=([0-9]+)$/i', $input, $preg ) ) {
		$tid = $preg[1];
		$gid = $preg[2];
	} elseif ( preg_match( '/^gId=([0-9]+)\|id=([0-9]+)$/i', $input, $preg ) ) {
		$tid = $preg[2];
		$gid = $preg[1];
	} elseif ( preg_match( '/^([0-9]+)\|([0-9]+)$/', $input, $preg ) ) {
		$tid = $preg[1];
		$gid = $preg[2];
	}

	return array( $tid, $gid );
}
