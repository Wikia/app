<?php

/**
 * This script uses the API on mediawiki.org to go through all extension
 * documentation pages and parse the usefull extension metadata from them
 * so it can be queried via the local API.
 *
 * Usage:
 *  no parameters
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
 * @since 0.1
 *
 * @author Jeroen De Dauw
 * 
 * @ingroup Distribution
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../maintenance/Maintenance.php' );

class GetDocsMetadata extends Maintenance {
	
	/**
	 * @see Maintenance::execute
	 * 
	 * @since 0.1
	 */	
	public function __construct() {
		parent::__construct();
		
		$this->mDescription = 'This script uses the API on mediawiki.org to go through all extension documentation' .
			'pages and parse the usefull extension metadata from them so it can be queried via the local API.';
	}	
	
	/**
	 * @see Maintenance::execute
	 * 
	 * @since 0.1
	 */
	public function execute() {
		
	}	
	
}

$maintClass = "GetDocsMetadata";
require_once( DO_MAINTENANCE );