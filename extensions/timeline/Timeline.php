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
};
$wgTimelineSettings = new TimelineSettings;
$wgTimelineSettings->ploticusCommand = "/usr/bin/ploticus";
$wgTimelineSettings->perlCommand = "/usr/bin/perl";
$wgTimelineSettings->timelineFile = "$IP/extensions/timeline/EasyTimeline.pl";

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfTimelineExtension';
} else {
	$wgExtensionFunctions[] = 'wfTimelineExtension';
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'EasyTimeline',
	'author' => 'Erik Zachte',
	'url' => 'http://www.mediawiki.org/wiki/Extension:EasyTimeline',
	'svn-date' => '$LastChangedDate: 2009-01-27 00:46:13 +0100 (wto, 27 sty 2009) $',
	'svn-revision' => '$LastChangedRevision: 46305 $',
	'description' => 'Adds <tt>&lt;timeline&gt;</tt> tag to create timelines',
	'descriptionmsg' => 'timeline-desc',
);
$wgExtensionMessagesFiles['Timeline'] = dirname(__FILE__) . '/Timeline.i18n.php';

function wfTimelineExtension() {
	global $wgParser;
	$wgParser->setHook( 'timeline', 'renderTimeline' );
	return true;
}

function renderTimeline( $timelinesrc ){
	global $wgUploadDirectory, $wgUploadPath, $IP, $wgTimelineSettings, $wgArticlePath, $wgTmpDirectory;
	$hash = md5( $timelinesrc );
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
		  " -T " . wfEscapeShellArg( $wgTmpDirectory ) . " -A " . wfEscapeShellArg( $wgArticlePath );

		$ret = `{$cmdline}`;

		unlink($fname);

		if ( $ret == "" ) {
			// Message not localized, only relevant during install
			return "<div id=\"toc\"><tt>Timeline error: Executable not found. Command line was: {$cmdline}</tt></div>";
		}

	}

	@$err = file_get_contents( $fname.".err" );

	if ( $err != "" ) {
		$txt = "<div id=\"toc\"><tt>$err</tt></div>";
	} else {
		@$map = file_get_contents( $fname.".map" );

		if( substr( php_uname(), 0, 7 ) == "Windows" ) {
			$ext = "gif";
		} else {
			$ext = "png";
		}

		$url = "{$wgUploadPath}/timeline/{$hash}.{$ext}";
		$txt  = "<map name=\"$hash\">{$map}</map>".
		        "<img usemap=\"#{$hash}\" src=\"$url\">";

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