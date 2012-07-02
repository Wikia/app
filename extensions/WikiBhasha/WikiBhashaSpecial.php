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
* We need to overload the special page constructor to initialize our own data also if we want to change the behavior of the SpecialPage class itself. 
* it will execute when called from the child class
* 
*/

class WikiBhasha extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'WikiBhasha', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgOut;
		$this->setHeaders();
		$wgOut->addHTML( '<h2>Application to create multilingual content leveraging the English Wikipedia content</h2>' );
	}
}
