<?php

/**
 * An extension that allows embedding of Sponsored ListSpinner Widgets into Mediawiki
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Kevin Croy @ Lostpedia
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * Version 1.3
 *
 * Changes:  	
 *
 * Tag:  <listspinner/>
 */
# Confirm MW environment
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionFunctions[] = 'wfListspinner';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Listspinner (version 1)',
        'description' => 'Display Lost Listspinner Widget',
        'author' => '[http://lostpedia.com/wiki/User:Admin Admin]',
        'url' => 'http://en.lostpedia.com/wiki/User:Admin'
);

function wfListspinner() {
        global $wgParser;
        $wgParser->setHook('listspinner', 'renderList');
}

# The callback function for converting the input text to HTML output
function renderList($input, $params) {
        // $pollid = htmlspecialchars($params['pollid']);
        
 	$output = "<iframe id='ab9b6940' name='ab9b6940' src='http://ads.countster.com/www/delivery/afr.php?zoneid=5&amp;target=_blank' framespacing='0' frameborder='no' scrolling='no' width='315' height='590' allowtransparency='true'><a href='http://ads.countster.com/www/delivery/ck.php?n=a119be2f' target='_blank'><img src='http://ads.countster.com/www/delivery/avw.php?zoneid=5&amp;n=a119be2f' border='0' alt='' /></a></iframe>";

        return $output;
}

?>
