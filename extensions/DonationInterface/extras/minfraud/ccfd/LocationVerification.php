<?php

/* LocationVerification.php
 *
 * Copyright (C) 2005 MaxMind LLC
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once ( "HTTPBase.php" );

class LocationVerification extends HTTPBase {

	var $server;
	var $numservers;
	var $API_VERSION;

	function __construct( &$gateway_adapter ) {
		parent::__construct( &$gateway_adapter );
		$this->isSecure = 1;	// use HTTPS by default
		// set the allowed_fields hash
		$this->allowed_fields["i"] = 1;
		$this->allowed_fields["city"] = 1;
		$this->allowed_fields["region"] = 1;
		$this->allowed_fields["postal"] = 1;
		$this->allowed_fields["country"] = 1;
		$this->allowed_fields["license_key"] = 1;
		$this->num_allowed_fields = count( $this->allowed_fields );

		// set the url of the web service
		$this->url = "app/locvr";
		$this->check_field = "distance";

		$this->server = array( "www.maxmind.com", "www2.maxmind.com" );
		$this->numservers = count( $this->server );
		$this->API_VERSION = 'PHP/1.4';
	}

}

?>
