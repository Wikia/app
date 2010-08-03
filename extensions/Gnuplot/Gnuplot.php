<?php

#####################
# PURPOSE
#   PHP script for the extension to use Gnuplot in a mediawiki instance.
#   Insert the Gnuplot code between the tags <gnuplot>...</gnuplot>.
# AUTHOR
#   Christina Pöpper
#   The work has been funded by a fellowship at ESA.
# DATE
#   Jan 19, 2006: creation
#   Jun 30, 2006: security upgrade (filter out system commands) and
#                 filenames instead of paths v1.1
# NOTE
#   Code adapted from the timeline extension.
#   Include this file in your LocalSettings.php:
#     add 'include("extensions/Gnuplot/Gnuplot.php")' to the end of the file.
#   Set $wgGnuplotCommand to your gnuplot.
####################

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'Gnuplot',
	'author'         => 'Christina Pöpper',
	'svn-date' => '$LastChangedDate: 2009-03-19 13:34:14 +0100 (czw, 19 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48578 $',
	'description'    => 'Adds the tag <code><nowiki><gnuplot></nowiki></code> to use Gnuplot',
	'descriptionmsg' => 'gnuplot-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Gnuplot',
);

$wgExtensionMessagesFiles['Gnuplot'] =  dirname(__FILE__) . '/Gnuplot.i18n.php';

$wgGnuplotCommand = '/usr/bin/gnuplot';
$wgGnuplotDefaultTerminal = 'set terminal png';
$wgGnuplotDefaultSize = 'set size 0.5,0.5';

$wgExtensionFunctions[] = "wfGnuplotExtension";

function wfGnuplotExtension() {
	global $wgParser;
	$wgParser->setHook( "gnuplot", "renderGnuplot" );
}

function renderGnuplot( $gnuplotsrc ) {
	global $wgGnuplotDefaultTerminal, $wgGnuplotDefaultSize, $wgGnuplotCommand;
	global $wgUploadDirectory, $wgUploadPath;

	// filter out harmfull system commands to close a security hole
	$replaces = array("`" => "", "system" => "", "shell" => "");
	$gnuplotsrc = strtr($gnuplotsrc, $replaces);

	// create directory for storing the plot
	$gnuplotDir = "/gnuplot/";
	$dest = $wgUploadDirectory . $gnuplotDir;
	if (!is_dir($dest)) {
		mkdir($dest, 0777);
		chmod($dest, 0777);
	}

	// get the name of the graph to be produced
	$name = getOutputName ($gnuplotsrc);
	$graphname = $dest . $name;
	$fname = $graphname . ".tmp";

	// write the default settings and the input code from wiki into a
	// temporary file to be executed by gnuplot, then execute the command
	if ( ! (file_exists($fname) || file_exists($fname . '.err'))) {
		$handle = fopen($fname, 'x');
		if( $handle === FALSE )
			// not sure what to do here, this shouldn't happen
			return '<p><b><img src="' . htmlspecialchars($wgUploadPath . $gnuplotDir . $name) .
				'" alt="Gnuplot Plot"></b></p>';

		// if terminal and size are not set in the gnuplot source we do it here
		if (strpos($gnuplotsrc, 'set terminal ') === false) {
			fwrite($handle, $wgGnuplotDefaultTerminal . "\n");
		}
		if (strpos($gnuplotsrc, 'set size ') === false) {
			fwrite($handle, $wgGnuplotDefaultSize . "\n");
		}

		// Need to find each occurance of src:<FILE NAME> and replace it
		// with the complete file path
		while (strpos($gnuplotsrc, 'src:') != false) {
			$srcStartPosition = strpos ($gnuplotsrc, 'src:') + strlen("src:");
			$srcEndPosition = strpos ($gnuplotsrc, ' ', $srcStartPosition);
			$tmpString = substr($gnuplotsrc, $srcStartPosition, $srcEndPosition-$srcStartPosition-1);
			$srcFileNamePath = getSourceDataPath($tmpString);
			$gnuplotsrc = str_replace("src:$tmpString",$srcFileNamePath,$gnuplotsrc);
		}

		fwrite($handle, "\nset output '" . $graphname . "'\n");
		// Remove the 'set output' command from the source as we will set it.
		$gnuplotsrc = preg_replace( '/^set output.*$/m', '', $gnuplotsrc );

		fwrite($handle, $gnuplotsrc . "\n");
		fclose($handle);

		$cmdlinePlot = wfEscapeShellArg($wgGnuplotCommand)
			. ' ' . wfEscapeShellArg( $fname );
		shell_exec($cmdlinePlot);

		// some cleanup
		unlink($fname);
	}

	return '<p><b><img src="' . htmlspecialchars($wgUploadPath . $gnuplotDir . $name) .
		'" alt="Gnuplot Plot"></b></p>';
}

/***
 * Function: getOutputName
 * Purpose : Determines the name of the output file. If it is specified by the
 *           user ("set output 'name'") this name is returned,
 *	     otherwise a new name is computed (by a hash function).
 * Input   : $gnuplotsrc - the gnuplot input code from wiki
 * Output  : the file name to be used
 */
function getOutputName ( $gnuplotsrc ) {
	// determine the file format of the plot - default is png
	$format = "png";
	$termpos = strpos($gnuplotsrc, "set terminal ");
	if ($termpos === true) {
		list( , ,$format, ) = split(" ", substr($gnuplotsrc, $termpos), 4);
	}

	$output = "";
	$strlength = strlen("set output ");
	$pos = strpos ($gnuplotsrc, "set output");
	if (! $pos ) {	// If there is no output file specified
		$output = md5($gnuplotsrc) . "." . $format;
	} else {		// If the output file is directly specified
		$posEnd = strpos($gnuplotsrc, "\n", $pos);
		$output = substr($gnuplotsrc,
			$pos + $strlength + 1,
			$posEnd - $pos - $strlength - 2);
	}
	// remove /, otherwise users may possibly write to random places in the FS
	$output = str_replace( '/', '', $output );
	return $output;
}

/***
 * Function: getSourceDataPath
 * Purpose : Look up the real filesystem path of the specified file
 * Input   : $name - the file name
 * Output  : the filesystem path for the file
 */
function getSourceDataPath ( $name ) {
	$h = wfFindFile($name);
	return $h->exists() ? $h->getImagePath() : null;
}
