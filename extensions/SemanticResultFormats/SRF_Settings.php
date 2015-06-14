<?php

/**
 * File for backward compatibility with pre SRF 1.8.
 *
 * @file
 * @ingroup SRF
 *
 * @author mwjames
 */

if ( !defined( 'MEDIAWIKI' ) ) {
  die( "This file is part of the Semantic MediaWiki extension. It is not a valid entry point.\n" );
}

// Could be promoted to Warning one version before really removing this file
trigger_error( 'Outdated SRF entry point. Use SemanticResultFormats/SemanticResultFormats.php instead of SemanticResultFormats/SRF_Settings.php', E_USER_NOTICE );

require_once dirname( __FILE__ ) . '/SemanticResultFormats.settings.php';