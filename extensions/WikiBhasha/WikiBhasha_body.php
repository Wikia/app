<?php
/*
*
*   WikiBhasha
*   Copyright (C) 2010, Microsoft
*   
*   This program is free software; you can redistribute it and/or
*   modify it under the terms of the GNU General Public License version 2
*   as published by the Free Software Foundation.
*   
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*   
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*
*/

/*
*
*	The body file will contain a subclass of SpecialPage. It will be loaded automatically when the special page is requested
*	this file contains the functions to populate the content to the special page
*
*/
class WikiBhasha extends SpecialPage {
	function __construct() {
		parent::__construct( 'WikiBhasha' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data from, e.g.
		$param = $wgRequest->getText( 'param' );

		# Do stuff
		# ...
		$output = "WikiBhasha";
		$wgOut->addWikiText( $output );
	}
}
