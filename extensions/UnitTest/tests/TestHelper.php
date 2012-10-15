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
 * TESTS_UNITTEST_EXTENSION_ROOT
 *
 * This is the root of the extension UnitTest
 */
define( 'TESTS_UNITTEST_EXTENSION_ROOT', dirname( dirname( __FILE__ ) ) );

//$IP = TESTS_WEB_ROOT;

/*
 * Unit tests are run from the command line.
 *
 * It should be confirmed that this will not affect other tests such as Selenium.
 */
$wgCommandLineMode = true;
//$wgCanonicalServer = true;

/**
 * Initializing the global $_SERVER for unit testing. This array does not exist
 * on the CLI.
 *
 * You may customize this variable in TestConfiguration.php.
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

/**
 * Constants used by the debugging statements.
 */
require_once dirname( dirname( __FILE__ ) ) . '/Debug.php';

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
//$_SERVER['SERVER_NAME'] = TESTS_WEB_ROOT;
$_SERVER['SERVER_ADMIN'] = TESTS_EMAIL;

