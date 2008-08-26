<?php

/**
 * Wikia Partners, a Wikia Widget for displaying links to affiliates
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia.com>
 * @author Maciej Brencz (code rewrite for new widget framework)
 * @copyright Copyright (C) 2007 Lucas 'TOR' Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * To enable this widget set $wgWikiaPartners. This should be an array holding three parameters
 * for each partner:
 * 1) the name of the partner;
 * 2) the URL the link will point to;
 * 3) either the name of an image file (uploaded to MediaWiki via Special:Upload) or the string 'text',
 *    in the latter case the link will display the name of the partner (1) instead of an image.
 *
 * All of the above are mandatory.
 *
 * Example:
 *  $wgWikiaPartners[] = "eBay";
 *  $wgWikiaPartners[] = "http://ebay.com/";
 *  $wgWikiaPartners[] = "eBay.jpg";
 *
 */

if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWikiaPartners'] = array(
	'callback' => 'WidgetWikiaPartners',
	'title' => array(
		'en' => 'Our partners',
		'pl' => 'Nasi partnerzy'
	),
	'desc' => array(
		'en' => 'Our partners',
		'pl' => 'Nasi partnerzy'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

function WidgetWikiaPartners($id, $params) {

    global $wgWikiaPartners;

    if ( !isset( $wgWikiaPartners ) ) {
	return '';
    }

    wfProfileIn( __METHOD__ );
    
    $output = "\n<table style='margin: 0 auto; border: 0; background: none'><tr>\n";

    for ($i = 0; $i < count($wgWikiaPartners); $i += 3 ) {
	$wgWikiaPartners[$i] = htmlspecialchars($wgWikiaPartners[$i]);
	$wgWikiaPartners[$i+1] = htmlspecialchars($wgWikiaPartners[$i+1]);

	if ( ($i != 0) && ($i % 6) == 0 ) {
    	    $output .= "</tr>\n<tr>\n";
	}

        $output .= "<td><a href='". $wgWikiaPartners[$i+1]. "' title='". $wgWikiaPartners[$i]. "'>\n";

        if ($wgWikiaPartners[$i+2] != 'text') {
	    $img = Image::newFromName( $wgWikiaPartners[$i+2] );
	    if (is_object($img)) {
		$thumb = $img->createThumb( 75, -1 );
		$output .= "<img src='$thumb' alt='". $wgWikiaPartners[$i]. "' />\n";
	    } else {
		$output .= $wgWikiaPartners[$i];
            }
	} else {
	    $output .= $wgWikiaPartners[$i];
	}
	$output .= "</a></td>\n";
    }

    $output .= "</tr></table>\n";
    
    wfProfileOut( __METHOD__ );
    
    return $output;

}
