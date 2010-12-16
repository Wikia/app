<?php

/*
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Query module to list pages with outdated review flag.
 *
 * @ingroup FlaggedRevs
 */
class ApiQueryOldreviewedpages extends ApiQueryGeneratorBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'or' );
	}

	public function execute() {
		$this->run();
	}

	public function executeGenerator( $resultPageSet ) {
		$this->run( $resultPageSet );
	}

	private function run( $resultPageSet = null ) {
		global $wgUser;
		$params = $this->extractRequestParams();

		// Construct SQL Query
		$this->addTables( array( 'page', 'flaggedpages', 'revision' ) );
		$this->addWhereFld( 'page_namespace', $params['namespace'] );
		$useIndex = array( 'flaggedpages' => 'fp_pending_since' );
		if( $params['filterredir'] == 'redirects' )
			$this->addWhereFld( 'page_is_redirect', 1 );
		if( $params['filterredir'] == 'nonredirects' )
			$this->addWhereFld( 'page_is_redirect', 0 );
		if( $params['maxsize'] !== null )
			# Get absolute difference for comparison. ABS(x-y)
			# is broken due to mysql unsigned int design.
			$this->addWhere( 'GREATEST(page_len,rev_len)-LEAST(page_len,rev_len) <= '.
				intval($params['maxsize']) );
		if( $params['filterwatched'] == 'watched' ) {
			if( !($uid = $wgUser->getId()) ) {
				$this->dieUsage('You must be logged-in to have a watchlist', 'notloggedin');
			}
			$this->addTables( 'watchlist' );
			$this->addWhereFld( 'wl_user', $uid );
			$this->addWhere( 'page_namespace = wl_namespace' );
			$this->addWhere( 'page_title = wl_title' );
		}
		if( $params['category'] != '' ) {
			$this->addTables( 'categorylinks' );
			$this->addWhere( 'cl_from = fp_page_id' );
			$this->addWhereFld( 'cl_to', $params['category'] );
			$useIndex['categorylinks'] = 'cl_from';
		}
		$this->addWhereRange(
			'fp_pending_since',
			$params['dir'],
			$params['start'],
			$params['end']
		);
		$this->addWhere( 'page_id=fp_page_id' );
		$this->addWhere( 'rev_id=fp_stable' );
		if ( !isset( $params['start'] ) && !isset( $params['end'] ) )
			$this->addWhere( 'fp_pending_since IS NOT NULL' );
			
		$this->addOption( 'USE INDEX', $useIndex );

		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array (
				'page_id',
				'page_namespace',
				'page_title',
				'page_latest',
				'page_len',
				'rev_len',
				'fp_stable',
				'fp_pending_since',
				'fp_quality'
			) );
		} else {
			$this->addFields( $resultPageSet->getPageTableFields() );
			$this->addFields ( 'fp_pending_since' );
		}

		$limit = $params['limit'];
		$this->addOption( 'LIMIT', $limit+1 );
		$res = $this->select( __METHOD__ );

		$data = array ();
		$count = 0;
		$db = $this->getDB();
		while ( $row = $db->fetchObject( $res ) ) {
			if ( ++$count > $limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->setContinueEnumParameter(
					'start',
					wfTimestamp( TS_ISO_8601, $row->fp_pending_since )
				);
				break;
			}

			if ( is_null( $resultPageSet ) ) {
				$title = Title::newFromRow( $row );
				$data[] = array(
					'pageid' => intval( $row->page_id ),
					'ns' => intval( $title->getNamespace() ),
					'title' => $title->getPrefixedText(),
					'revid' => intval( $row->page_latest ),
					'stable_revid' => intval( $row->fp_stable ),
					'pending_since' => wfTimestamp( TS_ISO_8601, $row->fp_pending_since ),
					'flagged_level' => intval( $row->fp_quality ),
					'flagged_level_text' => FlaggedRevs::getQualityLevelText( $row->fp_quality ),
					'diff_size' => (int)$row->page_len - (int)$row->rev_len
				);
			} else {
				$resultPageSet->processDbRow( $row );
			}
		}
		$db->freeResult( $res );

		if ( is_null(  $resultPageSet ) ) {
			$result = $this->getResult();
			$result->setIndexedTagName( $data, 'p' );
			$result->addValue( 'query', $this->getModuleName(), $data );
		}
	}

	public function getCacheMode( $params ) {
		if ( $params['filterwatched'] == 'watched' ) {
			// Private data
			return 'private';
		} else {
			return 'public';
		}
	}

	public function getAllowedParams() {
		$namespaces = FlaggedRevs::getReviewNamespaces();
		return array (
			'start' => array (
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'end' => array (
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'dir' => array (
				ApiBase::PARAM_DFLT => 'newer',
				ApiBase::PARAM_TYPE => array( 'newer', 'older' )
			),
			'maxsize' => array (
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_DFLT => null,
				ApiBase::PARAM_MIN 	=> 0
			),
			'filterwatched' => array (
				ApiBase::PARAM_DFLT => 'all',
				ApiBase::PARAM_TYPE => array( 'watched', 'all' )
			),
			'namespace' => array (
				ApiBase::PARAM_DFLT => !$namespaces ?
					NS_MAIN : $namespaces[0],
				ApiBase::PARAM_TYPE => 'namespace',
				ApiBase::PARAM_ISMULTI => true,
			),
			'category' => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			'filterredir' => array (
				ApiBase::PARAM_DFLT => 'all',
				ApiBase::PARAM_TYPE => array( 'redirects', 'nonredirects', 'all' )
			),
			'limit' => array (
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			)
		);
	}

	public function getParamDescription() {
		return array (
			'start' 	  	=> 'Start listing at this timestamp.',
			'end'			=> 'Stop listing at this timestamp.',
			'namespace' 	=> 'The namespaces to enumerate.',
			'filterredir'	=> 'How to filter for redirects.',
			'maxsize' 		=> 'Maximum character count change size.',
			'category'      => 'Show pages only in the given category.',
			'filterwatched' => 'How to filter for pages on your watchlist.',
			'limit' 		=> 'How many total pages to return.',
			'dir' 			=> array(
				'In which direction to list.',
				'*newer: list the longest waiting pages first',
				'*older: list the newest items first'
			)				
		);
	}

	public function getDescription() {
		return array(
			'Returns a list of pages, that have an outdated review flag,',
			'sorted by timestamp of the first unreviewed edit of that page.'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'notloggedin', 'info' => 'You must be logged-in to have a watchlist' ),
		) );
	}

	protected function getExamples() {
		return array (
			'Show a list of pages with pending unreviewed changes',
			' api.php?action=query&list=oldreviewedpages&ornamespace=0',
			'Show info about some old reviewed pages',
			' api.php?action=query&generator=oldreviewedpages&gorlimit=4&prop=info',
		);
	}
	
	public function getVersion() {
		return __CLASS__.': $Id: ApiQueryOldreviewedpages.php 69932 2010-07-26 08:03:21Z tstarling $';
	}
}
