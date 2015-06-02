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

function upgradeYouTubeTag( $editpage, $request ) {
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

			// Separate the Youtube ID and parameters
			$paramText = trim( $matches[3] );
			// Node value can look like: <youtube_id>|400px|thumb|center
			// @TODO evaluate calling parser to parse params and upload correctly styled video
			$nodeValues = explode( '|', $matches[4] );
			$ytid = trim( $nodeValues[0] );

			// Check to see if the whole URL is used
			$ytid = preg_replace( '/^.*youtube.com\/watch?.*v=([^&]+).*$/', '$1', $ytid );

			// Parse out the width and height parameters
			$params = parseSizeParams( $paramText );

			// If height is less than 30, they probably are using this as an audio file
			// so don't bother converting it.
			if ( $params['height'] <= AUDIO_ONLY_HEIGHT ) {
				return $matches[0];
			}

			$url = 'http://www.youtube.com/watch?v=' . $ytid;

			$videoService = new VideoService();
			$videoFileUploader = new VideoFileUploader();
			$videoFileUploader->setExternalUrl( $url );
			$apiWrapper = $videoFileUploader->getApiWrapper();
			if ( !$apiWrapper->videoExists() ) {
				return createRawOutput( $matches[0] );
			}

			$retval = $videoService->addVideo( $url );

			if ( is_array( $retval ) ) {
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
function wfYouTube( $parser ) {
	global $wgAllowNonPremiumVideos;

	if ( !$wgAllowNonPremiumVideos ) {
		return true;
	}
	$parser->setHook( 'youtube', 'embedYouTube' );
	$parser->setHook( 'gvideo',  'embedGoogleVideo' );
	$parser->setHook( 'aovideo', 'embedArchiveOrgVideo' );
	$parser->setHook( 'aoaudio', 'embedArchiveOrgAudio' );
	$parser->setHook( 'wegame', 'embedWeGame' );
	$parser->setHook( 'tangler', 'embedTangler' );
	$parser->setHook( 'gtrailer', 'embedGametrailers' );
	$parser->setHook( 'nicovideo', 'embedNicovideo' );
	$parser->setHook( 'ggtube', 'embedGoGreenTube' );
	$parser->setHook( 'cgamer', 'embedCrispyGamer' );
	$parser->setHook( 'longtail', 'embedLongtailVideo' );

	$parser->setFunctionHook( 'youtube', 'wfParserFunction_youTube' );

	return true;
}

function embedYouTube_url2ytid( $url ) {
	$id = $url;

	if ( preg_match( '/^http:\/\/www\.youtube\.com\/watch\?v=(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	} elseif ( preg_match( '/^http:\/\/www\.youtube\.com\/v\/([^&]+)(&autoplay=[0-1])?$/', $url, $preg ) ) {
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
		$url = "http://www.youtube.com/v/{$ytid}&enablejsapi=1&version=2&playerapiid={$ytid}"; // it's not mistake, there should be &, not ?
		return "<object type=\"application/x-shockwave-flash\" data=\"{$url}\" width=\"{$width}\" height=\"{$height}\" id=\"YT_{$ytid}\"><param name=\"movie\" value=\"{$url}\"/><param name=\"wmode\" value=\"transparent\"/><param name=\"allowScriptAccess\" value=\"always\"/></object>";
	}
}

function embedYouTube_url2gvid( $url ) {
	$id = $url;

	if ( preg_match( '/^http:\/\/video\.google\.com\/videoplay\?docid=([^&]+)(&hl=.+)?$/', $url, $preg ) ) {
		$id = $preg[1];
	} elseif ( preg_match( '/^http:\/\/video\.google\.com\/googleplayer\.swf\?docId=(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9-]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedGoogleVideo( $input, $argv, $parser ) {
	$gvid   = '';
	$width  = $width_max  = 400;
	$height = $height_max = 326;

	if ( !empty( $argv['gvid'] ) ) {
		$gvid = embedYouTube_url2gvid( $argv['gvid'] );
	} elseif ( !empty( $input ) ) {
		$gvid = embedYouTube_url2gvid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $gvid ) ) {
		$url = "http://video.google.com/googleplayer.swf?docId={$gvid}";
		return "<object type=\"application/x-shockwave-flash\" data=\"{$url}\" width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"{$url}\"/><param name=\"wmode\" value=\"transparent\"/></object>";
	}
}

function embedYouTube_url2aovid( $url ) {
	$id = $url;

	if ( preg_match( '/http:\/\/www\.archive\.org\/download\/(.+)\.flv$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9A-Za-z_\/.]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedArchiveOrgVideo( $input, $argv, $parser ) {
	$aovid = '';
	$width = $width_max  = 320;
	$height = $height_max = 263;

	if ( !empty( $argv['aovid'] ) ) {
		$aovid = embedYouTube_url2aovid( $argv['aovid'] );
	} elseif ( !empty( $input ) ) {
		$aovid = embedYouTube_url2aovid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $aovid ) ) {
		$url = "http://www.archive.org/download/{$aovid}.flv";
		return "<object type=\"application/x-shockwave-flash\" data=\"http://www.archive.org/flv/FlowPlayerWhite.swf\" width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"http://www.archive.org/flv/FlowPlayerWhite.swf\"/><param name=\"flashvars\" value=\"config={loop: false, videoFile: '{$url}', autoPlay: false}\"/></object>";
	}
}

function embedYouTube_url2aoaid( $url ) {
	$id = $url;

	if ( preg_match( '/http:\/\/www\.archive\.org\/details\/(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9A-Za-z_\/.]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedArchiveOrgAudio( $input, $argv, $parser ) {
	$aoaid   = '';
	$width  = $width_max  = 400;
	$height = $height_max = 170;

	if ( !empty( $argv['aoaid'] ) ) {
		$aoaid = embedYouTube_url2aoaid( $argv['aoaid'] );
	} elseif ( !empty( $input ) ) {
		$aoaid = embedYouTube_url2aoaid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $aoaid ) ) {
		$url = urlencode( "http://www.archive.org/audio/xspf-maker.php?identifier={$aoaid}" );
		return "<object type=\"application/x-shockwave-flash\" data=\"http://www.archive.org/audio/xspf_player.swf?playlist_url={$url}\" width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"http://www.archive.org/audio/xspf_player.swf?playlist_url={$url}\"/></object>";
	}
}

function embedYouTube_url2weid( $url ) {
	$id = $url;

	if ( preg_match( '/^http:\/\/www\.wegame\.com\/watch\/(.+)\/$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9A-Za-z_-]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedWeGame( $input, $argv, $parser ) {
	$weid   = '';
	$width  = $width_max  = 488;
	$height = $height_max = 387;

	if ( !empty( $argv['weid'] ) ) {
		$weid = embedYouTube_url2weid( $argv['weid'] );
	} elseif ( !empty( $input ) ) {
		$weid = embedYouTube_url2weid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $weid ) ) {
		return "<object type=\"application/x-shockwave-flash\" data=\"http://www.wegame.com/static/flash/player2.swf\" width=\"{$width}\" height=\"{$height}\"><param name=\"flashvars\" value=\"tag={$weid}\"/></object>";

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

function embedTangler( $input, $argv, $parser ) {
	$tid = $gid = '';

	if ( !empty( $argv['tid'] ) && !empty( $argv['gid'] ) ) {
		list( $tid, $gid ) = embedYouTube_url2tgid( "{$argv['tid']}|{$argv['gid']}" );
	} elseif ( !empty( $input ) ) {
		list( $tid, $gid ) = embedYouTube_url2tgid( $input );
	}

	if ( !empty( $tid ) && !empty( $gid ) ) {
		return "<p style=\"width: 410px; height: 480px\" id=\"tangler-embed-topic-{$tid}\"></p><script type=\"text/javascript\" src=\"http://www.tangler.com/widget/embedtopic.js?id={$tid}&gId={$gid}\"></script>";
	}
}

function embedYouTube_url2gtid( $url ) {
	$id = $url;

	if ( preg_match( '/^http:\/\/www\.gametrailers\.com\/player\/(.+)\.html$/', $url, $preg ) ) {
		$id = $preg[1];
	} elseif ( preg_match( '/^http:\/\/www\.gametrailers\.com\/remote_wrap\.php\?mid=(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedGametrailers( $input, $argv, $parser ) {
	$gtid   = '';
	$width  = $width_max  = 480;
	$height = $height_max = 392;

	if ( !empty( $argv['gtid'] ) ) {
		$gtid = embedYouTube_url2gtid( $argv['gtid'] );
	} elseif ( !empty( $input ) ) {
		$gtid = embedYouTube_url2gtid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $gtid ) ) {
		$url = "http://www.gametrailers.com/remote_wrap.php?mid={$gtid}";
		// return "<object type=\"application/x-shockwave-flash\" width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"{$url}\"/></object>";
		// gametrailers' flash doesn't work on FF with object tag alone )-: weird, yt and gvideo are ok )-: valid xhtml no more )-:
		return "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\"  codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" id=\"gtembed\" width=\"{$width}\" height=\"{$height}\">	<param name=\"allowScriptAccess\" value=\"sameDomain\" /> 	<param name=\"allowFullScreen\" value=\"true\" /> <param name=\"movie\" value=\"{$url}\"/> <param name=\"quality\" value=\"high\" /> <embed src=\"{$url}\" swLiveConnect=\"true\" name=\"gtembed\" align=\"middle\" allowScriptAccess=\"sameDomain\" allowFullScreen=\"true\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"{$width}\" height=\"{$height}\"></embed> </object>";
	}
}

function embedYouTube_url2nvid( $url ) {
	$id = $url;

	preg_match( '/([0-9A-Za-z]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedNicovideo( $input, $argv, $parser ) {
	$nvid = '';
	$width  = $width_max  = 640;
	$height = $height_max = 480;

	if ( !empty( $argv['nvid'] ) ) {
		$nvid = embedYouTube_url2nvid( $argv['nvid'] );
	} elseif ( !empty( $input ) ) {
		$nvid = embedYouTube_url2nvid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $nvid ) ) {
		$url = "http://ext.nicovideo.jp/thumb_watch/{$nvid}?w={$width}&amp;h={$height}";
		return "<script type=\"text/javascript\" src=\"{$url}\"></script>";
	}
}

function embedYouTube_url2ggid( $url ) {
	$id = $url;

	if ( preg_match( '/^http:\/\/www\.gogreentube\.com\/watch\.php\?v=(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	} elseif ( preg_match( '/^http:\/\/www\.gogreentube\.com\/embed\/(.+)$/', $url, $preg ) ) {
		$id = $preg[1];
	}

	preg_match( '/([0-9A-Za-z]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedGoGreenTube( $input, $argv, $parser ) {
	$ggid = '';
	$width  = $width_max  = 432;
	$height = $height_max = 394;

	if ( !empty( $argv['ggid'] ) ) {
		$ggid = embedYouTube_url2ggid( $argv['ggid'] );
	} elseif ( !empty( $input ) ) {
		$ggid = embedYouTube_url2ggid( $input );
	}
	if ( !empty( $argv['width'] ) && settype( $argv['width'], 'integer' ) && ( $width_max >= $argv['width'] ) ) {
		$width = $argv['width'];
	}
	if ( !empty( $argv['height'] ) && settype( $argv['height'], 'integer' ) && ( $height_max >= $argv['height'] ) ) {
		$height = $argv['height'];
	}

	if ( !empty( $ggid ) ) {
		$url = "http://www.gogreentube.com/embed/{$ggid}";
		return "<script type=\"text/javascript\" src=\"{$url}\"></script>";
	}
}

function embedYouTube_url2cvid( $url ) {
	$id = $url;

	preg_match( '/([0-9]+)/', $id, $preg );
	$id = $preg[1];

	return $id;
}

function embedCrispyGamer( $input, $argv, $parser ) {
	$cvid = '';

	if ( !empty( $argv['vid'] ) ) {
		$cvid = embedYouTube_url2cvid( $argv['vid'] );
	} elseif ( !empty( $input ) ) {
		$cvid = embedYouTube_url2cvid( $input );
	}

	if ( !empty( $cvid ) ) {
		$url = "http://www.crispygamer.com/partners/wikia.aspx?pid=0&amp;vid={$cvid}";
		return "<script type=\"text/javascript\" src=\"{$url}\"></script>";
	}
}

// Embed longtail video, given its key (as 'vid' attribute of <longtail> tag).
// example: <longtail vid='8YVNhJJj'/>
function embedLongtailVideo( $input, $argv, $parser ) {
	if ( !empty( $argv['vid'] ) ) {
		$vid = $argv['vid'];
		return "<script type=\"text/javascript\" src=\"http://content.bitsontherun.com/players/{$vid}-McXqFI4P.js\"></script>";
	}
}
