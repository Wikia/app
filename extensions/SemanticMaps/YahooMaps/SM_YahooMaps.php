<?php

/**
 * This groupe contains all Yahoo! Maps related files of the Semantic Maps extension.
 * 
 * @defgroup SMYahooMaps Yahoo! Maps
 * @ingroup SemanticMaps
 */

/**
 * This file holds the general information for the Yahoo! Maps service.
 *
 * @file SM_YahooMaps.php
 * @ingroup SMYahooMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$egMapsServices['yahoomaps']['qp'] = array('class' => 'SMYahooMapsQP', 'file' => 'YahooMaps/SM_YahooMapsQP.php', 'local' => true);
$egMapsServices['yahoomaps']['fi'] = array('class' => 'SMYahooMapsFormInput', 'file' => 'YahooMaps/SM_YahooMapsFormInput.php', 'local' => true);