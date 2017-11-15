<?php

/**
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2006 Yuri Astrakhan <Firstname><Lastname>@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * This file is the entry point for all API queries. It begins by checking
 * whether the API is enabled on this wiki; if not, it informs the user that
 * s/he should set $wgEnableAPI to true and exits. Otherwise, it constructs
 * a new ApiMain using the parameter passed to it as an argument in the URL
 * ('?action=') and with write-enabled set to the value of $wgEnableWriteAPI
 * as specified in LocalSettings.php. It then invokes "execute()" on the
 * ApiMain object instance, which produces output in the format sepecified
 * in the URL.
 */

// So extensions (and other code) can check whether they're running in API mode
define( 'MW_API', true );

// Bail if PHP is too low
if ( !function_exists( 'version_compare' ) || version_compare( phpversion(), '5.2.3' ) < 0 ) {
	require( dirname( __FILE__ ) . '/includes/PHPVersionError.php' );
	wfPHPVersionError( 'api.php' );
}

// Initialise common code.
if ( isset( $_SERVER['MW_COMPILED'] ) ) {
	require ( 'phase3/includes/WebStart.php' );
} else {
	require ( dirname( __FILE__ ) . '/includes/WebStart.php' );
}

Transaction::setEntryPoint(Transaction::ENTRY_POINT_API);
Transaction::setAttribute(Transaction::PARAM_API_ACTION, $wgRequest->getVal('action',null));
Transaction::setAttribute(Transaction::PARAM_API_LIST, $wgRequest->getVal('list',null));

wfProfileIn( 'api.php' );
$starttime = microtime( true );

// URL safety checks
if ( !$wgRequest->checkUrlExtension() ) {
	wfProfileOut( 'api.php' );
	return;
}

// Pathinfo can be used for stupid things. We don't support it for api.php at
// all, so error out if it's present.
if ( isset( $_SERVER['PATH_INFO'] ) && $_SERVER['PATH_INFO'] != '' ) {
	$correctUrl = wfAppendQuery( wfScript( 'api' ), $wgRequest->getQueryValues() );
	$correctUrl = wfExpandUrl( $correctUrl, PROTO_CANONICAL );
	header( "Location: $correctUrl", true, 301 );
	echo 'This endpoint does not support "path info", i.e. extra text between "api.php"'
		. 'and the "?". Remove any such text and try again.';
	die( 1 );
}

// Verify that the API has not been disabled
if ( !$wgEnableAPI ) {
	header( $_SERVER['SERVER_PROTOCOL'] . ' 500 MediaWiki configuration Error', true, 500 );
	echo( 'MediaWiki API is not enabled for this site. Add the following line to your LocalSettings.php'
		. '<pre><b>$wgEnableAPI=true;</b></pre>' );
	die(1);
}

wfHandleCrossSiteAJAXdomain(); // Wikia change

// Wikia change
if( function_exists( 'newrelic_background_job' ) ) {
	newrelic_background_job(true);
}

// Set a dummy $wgTitle, because $wgTitle == null breaks various things
// In a perfect world this wouldn't be necessary
$wgTitle = Title::makeTitle( NS_MAIN, 'API' );

/* Construct an ApiMain with the arguments passed via the URL. What we get back
 * is some form of an ApiMain, possibly even one that produces an error message,
 * but we don't care here, as that is handled by the ctor.
 */
if ( !empty( $wgVisualEditorSyncval ) && !empty( $_GET['syncval'] ) && $wgVisualEditorSyncval === $_GET['syncval'] ) {
	$wgGroupPermissions['*']['read'] = true;
}
$processor = new ApiMain( $wgRequest, $wgEnableWriteAPI );

// Process data & print results
$processor->execute();

// Execute any deferred updates
DeferredUpdates::doUpdates();

// Log what the user did, for book-keeping purposes.
$endtime = microtime( true );
wfProfileOut( 'api.php' );
wfLogProfilingData();

// Log the request
if ( $wgAPIRequestLog ) {
	$items = array(
			wfTimestamp( TS_MW ),
			$endtime - $starttime,
			$wgRequest->getIP(),
			$_SERVER['HTTP_USER_AGENT']
	);
	$items[] = $wgRequest->wasPosted() ? 'POST' : 'GET';
	$module = $processor->getModule();
	if ( $module->mustBePosted() ) {
		$items[] = "action=" . $wgRequest->getVal( 'action' );
	} else {
		$items[] = wfArrayToCGI( $wgRequest->getValues() );
	}
	wfErrorLog( implode( ',', $items ) . "\n", $wgAPIRequestLog );
	wfDebug( "Logged API request to $wgAPIRequestLog\n" );
}

Hooks::run( 'RestInPeace' ); // Wikia change - @author macbre

// Shut down the database.  foo()->bar() syntax is not supported in PHP4: we won't ever actually
// get here to worry about whether this should be = or =&, but the file has to parse properly.
$lb = wfGetLBFactory();
$lb->shutdown();

