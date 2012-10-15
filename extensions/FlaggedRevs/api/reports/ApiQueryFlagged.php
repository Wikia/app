<?php

/**
 * Created on Sep 17, 2008
 *
 * API module for MediaWiki's FlaggedRevs extension
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
 */

/**
 * Query module to get flagging information about pages via 'prop=flagged'
 *
 * @ingroup FlaggedRevs
 */
class ApiQueryFlagged extends ApiQueryBase {

	public function execute() {
		$pageSet = $this->getPageSet();
		$pageids = array_keys( $pageSet->getGoodTitles() );
		if ( !$pageids ) {
			return true;
		}

		// Construct SQL Query
		$this->addTables( 'flaggedpages' );
		$this->addFields( array(
			'fp_page_id', 'fp_stable', 'fp_quality', 'fp_pending_since'
		) );
		$this->addWhereFld( 'fp_page_id', $pageids );
		$res = $this->select( __METHOD__ );

		$result = $this->getResult();
		foreach( $res as $row ) {
			$data = array(
				'stable_revid' 	=> intval( $row->fp_stable ),
				'level' 		=> intval( $row->fp_quality ),
				'level_text' 	=> FlaggedRevs::getQualityLevelText( $row->fp_quality )
			);
			if ( $row->fp_pending_since ) {
				$data['pending_since'] = wfTimestamp( TS_ISO_8601, $row->fp_pending_since );
			}
			$result->addValue( array( 'query', 'pages', $row->fp_page_id ), 'flagged', $data );
		}
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function getAllowedParams() {
		return array();
	}

	public function getDescription() {
		return array(
			'Get information about the flagging status of the given pages.',
			'If a page is flagged, the following parameters are returned:',
			'* stable_revid      : The revision id of the latest stable revision',
			'* level, level_text : The highest flagging level of the page',
			'* pending_since     : If there are any current unreviewed revisions'
			. ' for that page, holds the timestamp of the first of them'
		);
	}

	public function getExamples() {
		return array (
			'api.php?action=query&prop=info|flagged&titles=Main%20Page',
			'api.php?action=query&generator=allpages&gapfrom=K&prop=flagged'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryFlagged.php 99814 2011-10-14 21:28:59Z reedy $';
	}
}
