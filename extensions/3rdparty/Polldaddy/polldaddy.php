<?php

/**
 * An extension that allows embedding of polldaddy.com flash polls into Mediawiki
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Jabberwock @ Lostpedia
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * Version 1.2
 *
 * Changes:  re-written to use parameters from tag instead of delimited $input
 *
 * Tag:  <polldaddy pollid="12345" width="260" height="400" />
 */
# Confirm MW environment
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionFunctions[] = 'wfPolldaddy';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Polldaddy',
        'description' => 'Display flash polls from polldaddy.com',
        'author' => '[http://lostpedia.com/wiki/User:jabrwocky7 Jabberwock]',
        'url' => 'http://en.lostpedia.com/wiki/User:jabrwocky7/polldaddy'
);

function wfPolldaddy() {
        global $wgParser;
        $wgParser->setHook('polldaddy', 'renderPolldaddy');
}

# The callback function for converting the input text to HTML output
function renderPolldaddy($input, $params) {
        //$v = htmlspecialchars($params['v']);
        $pollid = htmlspecialchars($params['pollid']);
        $width = htmlspecialchars($params['width']);
        $height = htmlspecialchars($params['height']);

        if ($pollid==null) {
          $output = '<i>Poll Error:  no poll specified!</i>';
          return $output;
        }

        //initialize default size for poll if nothing was specified
        if ($width==null) {
          $width = 260;
        }
        if ($height==null) {
          $height = 400;
        }

        //$output =    '<embed allowScriptAccess="never"  saveEmbedTags="true" src="http://www.polldaddy.com/poll.swf" FlashVars="p='.$pollid.'" width="'.$width.'"  height="'.$height.'" quality="high" wmode="transparent"  bgcolor="#ffffff" name="beta3" salign="tl" scale="autoscale" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" ></embed>';

		$output ='<script language="javascript" src="http://www.polldaddy.com/p/'.$pollid.'.js"> </script> <noscript> <a href ="http://www.polldaddy.com" >PollDaddy.com</a> - <a href ="http://www.polldaddy.com/poll.asp?p=52352" >Nimm an unserer Umfrage teil!</a> </noscript>';
		return $output;
}

?>
