<?php

/**
 * This script approves the current revision of all pages that are in an
 * approvable namespace, and do not already have an approved revision.
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
 * @author Jeroen De Dauw
 * @author Yaron Koren
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../maintenance/Maintenance.php' );

class ApproveAllPages extends Maintenance {
	
	public function __construct() {
		parent::__construct();
		
		$this->mDescription = "Approve the current revision of all pages that do not yet have an approved revision.";
	}
	
	public function execute() {
		global $wgTitle;
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$pages = $dbr->select(
			'page',
			array(
				'page_id',
				'page_latest'
			)
		); 
		
		while ( $page = $pages->fetchObject() ) {
			$title = Title::newFromID( $page->page_id );
			// some extensions, like Semantic Forms, need $wgTitle
			// set as well
			$wgTitle = $title;
			if ( ApprovedRevs::pageIsApprovable( $title ) &&
				! ApprovedRevs::hasApprovedRevision( $title ) ) {
				ApprovedRevs::setApprovedRevID( $title, $page->page_latest, true );
				$this->output( wfTimestamp( TS_DB ) . ' Approved the last revision of page "' . $title->getFullText() . '".' );
			}
		}
		
		
		$this->output( "\n Finished setting all current revisions to approved. \n" );
	}
	
}

$maintClass = "ApproveAllPages";
require_once( DO_MAINTENANCE );
