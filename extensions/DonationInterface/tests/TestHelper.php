<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
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
 *
 * @category	UnitTesting
 * @package		Fundraising_QueueHandling
 * @license		http://www.gnu.org/copyleft/gpl.html GNU GENERAL PUBLIC LICENSE
 * @since		r462
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/*
 * Set error reporting to the level to which code must comply.
 */
error_reporting( E_ALL | E_STRICT );

if ( !defined( 'MEDIAWIKI' ) ) {
	define( 'MEDIAWIKI', 1 );
}

/**
 * TESTS_WEB_ROOT
 *
 * This is similar to $IP, the installation path in Mediawiki.
 */
define( 'TESTS_WEB_ROOT', dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );

$IP = TESTS_WEB_ROOT;

/*
 * Required files for unit testing. 
 */
require_once( TESTS_WEB_ROOT . '/includes/Defines.php' );
require_once( TESTS_WEB_ROOT . '/includes/DefaultSettings.php' );
require_once( TESTS_WEB_ROOT . '/LocalSettings.php' );
require_once( TESTS_WEB_ROOT . '/includes/SpecialPage.php' );
require_once( TESTS_WEB_ROOT . '/includes/Title.php' );
require_once( TESTS_WEB_ROOT . '/includes/Exception.php' );

/**
 * @see DonationData
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'gateway_common/DonationData.php';

/**
 * @see GatewayAdapter
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'gateway_common/gateway.adapter.php';

/**
 * @see GatewayForm
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'gateway_common/GatewayForm.php';

/**
 * @see extras/extras.body.php
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'extras/extras.body.php';

/**
 * @see GlobalCollectAdapter
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'globalcollect_gateway/globalcollect.adapter.php';

/**
 * @see GlobalCollectTestAdapter
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'Adapter/GlobalCollect/GlobalCollectTestAdapter.php';

/**
 * @see ContributionTrackingProcessor
 */
require_once dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'ContributionTracking/ContributionTracking.processor.php';


/*
 * Unit tests are run from the command line.
 *
 * It should be confirmed that this will not affect other tests such as Selenium.
 */
//$wgCommandLineMode = true;
//$wgCanonicalServer = true;

/**
 * Initializing the global $_SERVER for unit testing. This array does not exist
 * on the CLI.
 *
 * You may customize this variable in TestConfiguration.php.
 *
 * @todo
 * - make this default more general and customizable.
 *
 * @var array $_SERVER
 */
$_SERVER = array ( 'HTTP_HOST' => 'localhost', 'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', 'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', 'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5', 'HTTP_ACCEPT_ENCODING' => 'gzip, deflate', 'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7', 'HTTP_CONNECTION' => 'keep-alive', 'HTTP_COOKIE' => 'mediawiki_fundraising_117_session=f2rc8vv6av1o324qodvinqlpi1', 'HTTP_IF_MODIFIED_SINCE' => 'Fri, 14 Oct 2011 20:18:45 GMT', 'PATH' => '/usr/bin:/bin:/usr/sbin:/sbin', 'SERVER_SIGNATURE' => '
Apache/2.2.19 (Unix) DAV/2 PHP/5.3.7 Server at localhost Port 80
', 'SERVER_SOFTWARE' => 'Apache/2.2.19 (Unix) DAV/2 PHP/5.3.7', 'SERVER_NAME' => 'localhost', 'SERVER_ADDR' => '127.0.0.1', 'SERVER_PORT' => '80', 'REMOTE_ADDR' => '127.0.0.1', 'DOCUMENT_ROOT' => '/dev/null', 'SERVER_ADMIN' => 'no-reply@example.org', 'SCRIPT_FILENAME' => '/dev/null/index.php', 'REMOTE_PORT' => '62747', 'GATEWAY_INTERFACE' => 'CGI/1.1', 'SERVER_PROTOCOL' => 'HTTP/1.1', 'REQUEST_METHOD' => 'GET', 'QUERY_STRING' => '', 'REQUEST_URI' => '/', 'SCRIPT_NAME' => '/index.php', 'PHP_SELF' => '/index.php', 'REQUEST_TIME' => 1318890010, );

// Initialize session for unit testing
$_SESSION = isset( $_SESSION ) ? $_SESSION : array();

/*
 * Required files for unit testing. 
 *
 * These files need to be required after the above code. Do not move.
 */
require_once( TESTS_WEB_ROOT . '/includes/WebRequest.php' );
require_once( TESTS_WEB_ROOT . '/includes/GlobalFunctions.php' );
require_once( TESTS_WEB_ROOT . '/includes/HttpFunctions.php' );
require_once( TESTS_WEB_ROOT . '/includes/db/Database.php' );
require_once( TESTS_WEB_ROOT . '/includes/db/DatabaseMysql.php' );
require_once( TESTS_WEB_ROOT . '/includes/Profiler.php' );
require_once( TESTS_WEB_ROOT . '/includes/Sanitizer.php' );
$request = $_SERVER;
$wgRequest = new FauxRequest( $request );

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if ( is_file( 'TestConfiguration.php' ) ) {
   require_once 'TestConfiguration.php';
} else {
	require_once 'TestConfiguration.php.dist';
}

/*
 * Customize the server variable options.
 */
$_SERVER['HTTP_HOST'] = TESTS_HOSTNAME;
$_SERVER['SERVER_NAME'] = TESTS_HOSTNAME;
$_SERVER['SERVER_NAME'] = TESTS_WEB_ROOT;
$_SERVER['SERVER_ADMIN'] = TESTS_EMAIL;

