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

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'EasyTimeline',
	'author' => 'Erik Zachte',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EasyTimeline',
	'descriptionmsg' => 'timeline-desc',
);

class TimelineSettings {
	public $ploticusCommand, $perlCommand;

	// Update this timestamp to force older rendered timelines
	// to be generated when the page next gets rendered.
	// Can help to resolve old image-generation bugs.
	public $epochTimestamp = '20010115000000';

	// Path to the EasyTimeline.pl perl file, which is used to actually generate the timelines.
	public $timelineFile;

	//Font file. Must in path specified by environment variable $GDFONTPATH
	//use the fontname 'ascii' to use the internal ploticus font that does not require
	//an external font file. Default to FreeSans for backwards compatability.
	//Note: according to ploticus docs, filename should not have any space in it or issues may occur.
	public $fontFile = 'FreeSans.ttf';

	// The name of the FileBackend to use for timeline (see $wgFileBackends)
	public $fileBackend = '';
}
$wgTimelineSettings = new TimelineSettings;
$wgTimelineSettings->ploticusCommand = "/usr/bin/ploticus";
$wgTimelineSettings->perlCommand = "/usr/bin/perl";
$wgTimelineSettings->timelineFile = dirname(__FILE__)."/EasyTimeline.pl";

$wgHooks['ParserFirstCallInit'][] = 'wfTimelineExtension';
$wgExtensionMessagesFiles['Timeline'] = dirname(__FILE__) . '/Timeline.i18n.php';

/**
 * @param $parser Parser
 * @return bool
 */
function wfTimelineExtension( &$parser ) {
	$parser->setHook( 'timeline', 'wfRenderTimeline' );
	return true;
}

/**
 * @param $timelinesrc string
 * @return string
 */
function wfRenderTimeline( $timelinesrc ) {
	global $wgUploadDirectory, $wgUploadPath, $wgArticlePath, $wgTmpDirectory, $wgRenderHashAppend;
	global $wgTimelineSettings;

	// Get the backend to store plot data and pngs
	if ( $wgTimelineSettings->fileBackend != '' ) {
		$backend = FileBackendGroup::singleton()->get( $wgTimelineSettings->fileBackend );
	} else {
		$backend = new FSFileBackend( array(
			'name'           => 'timeline-backend',
			'lockManager'    => 'nullLockManager',
			'containerPaths' => array( 'timeline-render' => "{$wgUploadDirectory}/timeline" ),
			'fileMode'       => 777
		) );
	}

	// Get a hash of the plot data
	$hash = md5( $timelinesrc );
	if ( $wgRenderHashAppend != '' ) {
		$hash = md5( $hash . $wgRenderHashAppend );
	}

	// Storage destination path (excluding file extension)
	$fname = 'mwstore://' . $backend->getName() . "/timeline-render/$hash";

	// Wikia change - begin
	wfRunHooks( 'BeforeRenderTimeline', [ &$backend, &$fname, $hash ] );
	// Wikia change - end

	$previouslyFailed = $backend->fileExists( array( 'src' => "{$fname}.err" ) );
	$previouslyRendered = $backend->fileExists( array( 'src' => "{$fname}.png" ) );
	if ( $previouslyRendered ) {
		$timestamp = $backend->getFileTimestamp( array( 'src' => "{$fname}.png" ) );
		$expired = ( $timestamp < $wgTimelineSettings->epochTimestamp );
	} else {
		$expired = false;
	}

	// Create a new .map, .png (or .gif), and .err file as needed...
	if ( $expired || ( !$previouslyRendered && !$previouslyFailed ) ) {
		if ( !is_dir( $wgTmpDirectory ) ) {
			mkdir( $wgTmpDirectory, 0777 );
		}
		$tmpFile = TempFSFile::factory( 'timeline_' );
		if ( $tmpFile ) {
			$tmpPath = $tmpFile->getPath();
			file_put_contents( $tmpPath, $timelinesrc ); // store plot data to file

			// Get command for ploticus to read the user input and output an error, 
			// map, and rendering (png or gif) file under the same dir as the temp file.
			$cmdline = wfEscapeShellArg( $wgTimelineSettings->perlCommand, $wgTimelineSettings->timelineFile ) .
			" -i " . wfEscapeShellArg( $tmpPath ) . " -m -P " . wfEscapeShellArg( $wgTimelineSettings->ploticusCommand ) .
			" -T " . wfEscapeShellArg( $wgTmpDirectory ) . " -A " . wfEscapeShellArg( $wgArticlePath ) .
			" -f " . wfEscapeShellArg( $wgTimelineSettings->fontFile );

			// Actually run the command...
			wfDebug( "Timeline cmd: $cmdline\n" );
			$retVal = null;
			$ret = wfShellExec( $cmdline, $retVal );

			// Copy the output files into storage...
			// @TODO: store error files in another container or not at all?
			$opt = array( 'force' => 1, 'nonLocking' => 1, 'allowStale' => 1 ); // performance
			$backend->prepare( array( 'dir' => dirname( $fname ) ) );
			$backend->store( array( 'src' => "{$tmpPath}.map", 'dst' => "{$fname}.map" ), $opt );
			$backend->store( array( 'src' => "{$tmpPath}.png", 'dst' => "{$fname}.png" ), $opt );
			$backend->store( array( 'src' => "{$tmpPath}.err", 'dst' => "{$fname}.err" ), $opt );
		} else {
			return "<div id=\"toc\" dir=\"ltr\"><tt>Timeline error. " .
				"Could not create temp file</tt></div>"; // ugh
		}

		if ( $ret == "" || $retVal > 0 ) {
			// Message not localized, only relevant during install
			return "<div id=\"toc\" dir=\"ltr\"><tt>Timeline error. " .
				"Command line was: " . htmlspecialchars( $cmdline ) . "</tt></div>";
		}
	}

	// Wikia change - begin
	if ( $backend->fileExists( array( 'src' => "{$fname}.err", 'latest' => true /* omit cache */ ) ) ) {
		$err = $backend->getFileContents( array( 'src' => "{$fname}.err" ) );
	}
	else {
		$err = '';
	}
	// Wikia change - end

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
		$txt = "<div id=\"toc\" dir=\"ltr\"><tt>$encErr</tt></div>";
	} else {
		// Wikia change - begin
		if ( $backend->fileExists( array( 'src' => "{$fname}.map", 'latest' => true /* omit cache */ ) ) ) {
			$map = $backend->getFileContents( array( 'src' => "{$fname}.map" ) );
		}
		else {
			$map = '';
		}
		// Wikia change - end

		$map = str_replace( ' >', ' />', $map );
		$map = "<map name=\"timeline_" . htmlspecialchars( $hash ) . "\">{$map}</map>";
		$map = easyTimelineFixMap( $map );

		$url = "{$wgUploadPath}/timeline/{$hash}.png";

		// Wikia change - begin
		$url = wfReplaceImageServer($url);
		// Wikia change - end

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
 * @param $html string
 * @return string
 */
function easyTimelineFixMap( $html ) {
	global $wgUrlProtocols;
	$doc = new DOMDocument( '1.0', 'UTF-8' );
	wfSuppressWarnings();
	$status = $doc->loadXML( $html );
	wfRestoreWarnings();
	if ( !$status ) {
		 // Load messages only if error occurs
		return '<strong class="error">' . wfMsg( 'timeline-invalidmap' ) . '</strong>';
	}

	$map = $doc->firstChild;
	if ( strtolower( $map->nodeName ) !== 'map' ) {
		 // Load messages only if error occurs
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
