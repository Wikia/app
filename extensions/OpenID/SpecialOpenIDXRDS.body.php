<?php
/**
 * SpecialOpenIDXRDS.body.php -- Server side of OpenID site
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @file
 * @author Evan Prodromou <evan@prodromou.name>
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) )
	exit( 1 );

# Outputs a Yadis (http://yadis.org/) XRDS file, saying that this server
# supports OpenID and lots of other jazz.

class SpecialOpenIDXRDS extends SpecialOpenID {

	function __construct() {
		parent::__construct( 'OpenIDXRDS', '', false );
	}

	# $par is a user name

	function execute( $par ) {
		global $wgOut, $wgOpenIDClientOnly;

		# No server functionality if this site is only a client
		# Note: special page is un-registered if this flag is set,
		# so it'd be unusual to get here.

		if ( $wgOpenIDClientOnly ) {
			wfHttpError( 404, "Not Found", wfMsg( 'openidclientonlytext' ) );
			return;
		}

		// XRDS preamble XML.
		$xml_template = array( '<?xml version="1.0" encoding="UTF-8"?' . '>',
			'<xrds:XRDS',
			'  xmlns:xrds="xri://\$xrds"',
			'  xmlns:openid="http://openid.net/xmlns/1.0"',
			'  xmlns="xri://$xrd*($v*2.0)">',
			'<XRD>' );

		# Check to see if the parameter is really a user name

		if ( !$par ) {
			wfHttpError( 404, "Not Found", wfMsg( 'openidnousername' ) );
			return;
		}

		$user = User::newFromName( $par );

		if ( !$user || $user->getID() == 0 ) {
			wfHttpError( 404, "Not Found", wfMsg( 'openidbadusername' ) );
			return;
		}

		// Generate the user page URL.

		$user_title = $user->getUserPage();
		$user_url = $user_title->getFullURL();

		// Generate the OpenID server endpoint URL.
		$server_title = SpecialPage::getTitleFor( 'OpenIDServer' );
		$server_url = $server_title->getFullURL();

		// Define array of Yadis services to be included in
		// the XRDS output.
		$services = array(
						  array( 'uri' => $server_url,
								'priority' => '0',
								'types' => array( 'http://openid.net/signon/1.0',
												 'http://openid.net/sreg/1.0',
												 'http://specs.openid.net/auth/2.0/signon' ),
								'delegate' => $user_url ),
						  );

		// Generate <Service> elements into $service_text.
		$service_text = "\n";
		foreach ( $services as $service ) {
			$types = array();
			foreach ( $service['types'] as $type_uri ) {
				$types[] = '    <Type>' . $type_uri . '</Type>';
			}
			$service_text .= implode( "\n",
				 array( '  <Service priority="' . $service['priority'] . '">',
				'    <URI>' . $server_url . '</URI>',
				implode( "\n", $types ),
				'  </Service>' ) );
		}

		$wgOut->disable();

		// Print content-type and XRDS XML.
		header( "Content-Type: application/xrds+xml" );

		print implode( "\n", $xml_template );
		print $service_text;
		print implode( "\n", array( "</XRD>", "</xrds:XRDS>" ) );
	}
}