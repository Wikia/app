<?php
/**
 * EasyTimeline - Timeline extension
 * To use, include this file from your LocalSettings.php
 * To configure, set members of $wgTimelineSettings after the inclusion
 *
 * @file
 * @ingroup Extensions
 * @author Erik Zachte <xxx@chello.nl (nospam: xxx=epzachte)>
 * @license GNU General Public License version 2
 * @link http://www.mediawiki.org/wiki/Extension:EasyTimeline Documentation
 */

class TimelineSettings {
	var $ploticusCommand, $perlCommand;
	
	// Update this timestamp to force older rendered timelines
	// to be generated when the page next gets rendered.
	// Can help to resolve old image-generation bugs.
	var $epochTimestamp = '20010115000000';

	// Path to the EasyTimeline.pl perl file, which is used to actually generate the timelines.
	var $timelineFile;
	
	//Font file. Must in path specified by environment variable $GDFONTPATH
	//use the fontname 'ascii' to use the internal ploticus font that does not require
	//an external font file. Default to FreeSans for backwards compatability.
	//Note: according to ploticus docs, filename should not have any space in it or issues may occur.
	var $fontFile = 'FreeSans.ttf';
};
$wgTimelineSettings = new TimelineSettings;
$wgTimelineSettings->ploticusCommand = "/usr/bin/ploticus";
$wgTimelineSettings->perlCommand = "/usr/bin/perl";
$wgTimelineSettings->timelineFile = dirname(__FILE__)."/EasyTimeline.pl";

$wgHooks['ParserFirstCallInit'][] = 'wfTimelineExtension';
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'EasyTimeline',
	'author' => 'Erik Zachte',
	'url' => 'http://www.mediawiki.org/wiki/Extension:EasyTimeline',
	'description' => 'Adds <tt>&lt;timeline&gt;</tt> tag to create timelines',
	'descriptionmsg' => 'timeline-desc',
);
$wgExtensionMessagesFiles['Timeline'] = dirname(__FILE__) . '/Timeline.i18n.php';

function wfTimelineExtension( &$parser ) {
	$parser->setHook( 'timeline', 'renderTimeline' );
	return true;
}

function renderTimeline( $timelinesrc ){
	global $wgUploadDirectory, $wgUploadPath, $IP, $wgTimelineSettings, $wgArticlePath, $wgTmpDirectory, $wgRenderHashAppend;
	$hash = md5( $timelinesrc );
	if ($wgRenderHashAppend != "")
		$hash = md5( $hash . $wgRenderHashAppend );
	$dest = $wgUploadDirectory."/timeline/";
	if ( ! is_dir( $dest ) ) { mkdir( $dest, 0777 ); }
	if ( ! is_dir( $wgTmpDirectory ) ) { mkdir( $wgTmpDirectory, 0777 ); }

	$fname = $dest . $hash;

	$previouslyFailed = file_exists( $fname.".err" );
	$previouslyRendered = file_exists( $fname.".png" );
	$expired = $previouslyRendered &&
		( filemtime( $fname.".png" ) <
			wfTimestamp( TS_UNIX, $wgTimelineSettings->epochTimestamp ) );

	if ( $expired || ( !$previouslyRendered && !$previouslyFailed ) ){
		$handle = fopen($fname, "w");
		fwrite($handle, $timelinesrc);
		fclose($handle);

		$cmdline = wfEscapeShellArg( $wgTimelineSettings->perlCommand, $wgTimelineSettings->timelineFile ) .
		  " -i " . wfEscapeShellArg( $fname ) . " -m -P " . wfEscapeShellArg( $wgTimelineSettings->ploticusCommand ) .
		  " -T " . wfEscapeShellArg( $wgTmpDirectory ) . " -A " . wfEscapeShellArg( $wgArticlePath ) .
		  " -f " . wfEscapeShellArg( $wgTimelineSettings->fontFile );

		wfDebug( "Timeline cmd: $cmdline\n" );
		$ret = `{$cmdline}`;

		unlink($fname);

		if ( $ret == "" ) {
			// Message not localized, only relevant during install
			return "<div id=\"toc\"><tt>Timeline error: Executable not found." . 
				"Command line was: " . htmlspecialchars( $cmdline ) . "</tt></div>";
		}

	}

	@$err = file_get_contents( $fname.".err" );

	if ( $err != "" ) {
		// Convert the error from poorly-sanitized HTML to plain text
		$err = strtr( $err, array(
			'</p><p>' => "\n\n",
			'<p>' => '',
			'</p>' => '',
			'<b>' => '',
			'</b>' => '',
			'<br>' => "\n" ) );
		$err = Sanitizer::decodeCharReferences( $err );

		// Now convert back to HTML again
		$encErr = nl2br( htmlspecialchars( $err ) );
		$txt = "<div id=\"toc\"><tt>$encErr</tt></div>";
	} else {
		@$map = file_get_contents( $fname.".map" );
		$map = str_replace( ' >', ' />', $map );
		$map = "<map name=\"timeline_" . htmlspecialchars( $hash ) . "\">{$map}</map>";
		$map = easyTimelineFixMap( $map );

		if (wfIsWindows()) {
			$ext = "gif";
		} else {
			$ext = "png";
		}

		$url = "{$wgUploadPath}/timeline/{$hash}.{$ext}";
		$txt = $map .
			"<img usemap=\"#timeline_" . htmlspecialchars( $hash ) . "\" " . 
			"src=\"" . htmlspecialchars( $url ) . "\">";

		if( $expired ) {
			// Replacing an older file, we may need to purge the old one.
			global $wgUseSquid;
			if( $wgUseSquid ) {
				$u = new SquidUpdate( array( $url ) );
				$u->doUpdate();
			}
		}
	}
	return $txt;
}

/**
 * Do a security check on the image map HTML
 */
function easyTimelineFixMap( $html ) {
	global $wgUrlProtocols;
	$doc = new DOMDocument( '1.0', 'UTF-8' );
	wfSuppressWarnings();
	$status = $doc->loadXML( $html );
	wfRestoreWarnings();
	if ( !$status ) {
		wfLoadExtensionMessages( 'Timeline' ); // Load messages only if error occurs
		return '<strong class="error">' . wfMsg( 'timeline-invalidmap' ) . '</strong>';
	}

	$map = $doc->firstChild;
	if ( strtolower( $map->nodeName ) !== 'map' ) {
		wfLoadExtensionMessages( 'Timeline' ); // Load messages only if error occurs
		return '<strong class="error">' . wfMsg( 'timeline-invalidmap' ) . '</strong>';
	}
	$name = $map->attributes->getNamedItem( 'name' )->value;
	$html = Xml::openElement( 'map', array( 'name' => $name ) );

	$allowedAttribs = array( 'shape', 'coords', 'href', 'nohref', 'alt', 
		'tabindex', 'title' );
	foreach ( $map->childNodes as $node ) {
		if ( strtolower( $node->nodeName ) !== 'area' ) {
			continue;
		}
		$ok = true;
		$attributes = array();
		foreach ( $node->attributes as $name => $value ) {
			$value = $value->value;
			$lcName = strtolower( $name );
			if ( !in_array( $lcName, $allowedAttribs ) ) {
				$ok = false;
				break;
			}
			if ( $lcName == 'href' && substr( $value, 0, 1 ) !== '/' ) {
				$ok = false;
				foreach ( $wgUrlProtocols as $protocol ) {
					if ( substr( $value, 0, strlen( $protocol ) ) == $protocol ) {
						$ok = true;
						break;
					}
				}
				if ( !$ok ) {
					break;
				}
			}
			$attributes[$name] = $value;
		}
		if ( !$ok ) {
			$html .= "<!-- illegal element removed -->\n";
			continue;
		}

		$html .= Xml::element( 'area', $attributes );
	}
	$html .= '</map>';
	return $html;
}
