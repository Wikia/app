<?php
/**
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
 * @ingroup Extensions
 * @version 1.0
 * @author David Strauss <david@fourkitchens.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Alert the user that this is not a valid entry point to MediaWiki if they try to access this file directly.
if ( !defined ( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install GeoIP extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/GeoIP/GeoIP.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GeoIP',
	'version' => '1.0',
	'author' => 'David Strauss',
	'description' => "[[Special:GeoIP|Shows user's geographical location, based on their IP address]]",
	'url' => 'https://www.mediawiki.org/wiki/Extension:GeoIP'
);

$wgHooks['LoadExtensionSchemaUpdates'][] = 'fnGeoIPSchema';
$wgSpecialPages['GeoIP'] = 'GeoIP';

function fnGeoIPSchema( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'geoip', dirname( __FILE__ ) . '/GeoIP.sql' );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'geoip',
			dirname( __FILE__ ) . '/GeoIP.sql', true ) );
	}
	return true;
}

class UnsupportedGeoIP extends Exception { }
class NotFoundGeoIP extends Exception { }

function fnGetGeoIP( $ip_address = null ) {
	if ( !isset( $ip_address ) ) {
		$ip_address = IP::sanitizeIP( wfGetIP() );
	}

	if ( isset( $_GET['ip'] ) ) {
		$ip_address = IP::sanitizeIP( $_GET['ip'] );
	}

	if ( !IP::isIPv4( $ip_address ) ) {
		throw new UnsupportedGeoIP( 'Only IPv4 addresses are supported.' );
	}

	$dbr = wfGetDB( DB_SLAVE );
	$long_ip = IP::toUnsigned( $ip_address );
	$conditions = array(
		'begin_ip_long <= ' . $long_ip,
		$long_ip . ' <= end_ip_long',
	);

	$country_code = $dbr->selectField( 'geoip', 'country_code', $conditions, __METHOD__ );

	if ( !$country_code ) {
		throw new NotFoundGeoIP( 'Could not identify the country for the provided IP address.' );
	}

	return $country_code;
}

class GeoIP extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'GeoIP' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut;

		$this->setHeaders();

		try {
			$wgOut->addHTML( '<p>' . fnGetGeoIP() . '</p>' );
		} catch ( Exception $e ) {
			$wgOut->addHTML( '<p>Unknown</p>' );
		}
	}
}