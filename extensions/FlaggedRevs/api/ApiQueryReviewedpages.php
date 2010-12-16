<?php

/*
 * Created on June 29, 2009
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
 * Query module to list pages reviewed pages
 *
 * @ingroup FlaggedRevs
 */
class ApiQueryReviewedpages extends ApiQueryGeneratorBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'rp' );
	}

	public function execute() {
		$this->run();
	}

	public function executeGenerator( $resultPageSet ) {
		$this->run( $resultPageSet );
	}

	private function run( $resultPageSet = null ) {
		$params = $this->extractRequestParams();

		// Construct SQL Query
		$this->addTables( array( 'page', 'flaggedpages' ) );
		$this->addWhereFld( 'page_namespace', $params['namespace'] );
		if( $params['filterredir'] == 'redirects' )
			$this->addWhereFld( 'page_is_redirect', 1 );
		if( $params['filterredir'] == 'nonredirects' )
			$this->addWhereFld( 'page_is_redirect', 0 );
		if( $params['filterlevel'] !== null )
			$this->addWhereFld( 'fp_quality', $params['filterlevel'] );
		$this->addWhereRange(
			'fp_page_id',
			$params['dir'],
			$params['start'],
			$params['end']
		);
		$this->addWhere( 'page_id=fp_page_id' );
		$this->addOption(
			'USE INDEX',
			array( 'flaggedpages' => 'PRIMARY' )
		);

		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array (
				'page_id',
				'page_namespace',
				'page_title',
				'page_len',
				'page_latest',
				'fp_page_id',
				'fp_quality',
				'fp_stable'
			) );
		} else {
			$this->addFields( $resultPageSet->getPageTableFields() );
			$this->addFields ( 'fp_page_id' );
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
				$this->setContinueEnumParameter( 'start', $row->fp_page_id );
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
					'flagged_level' => intval( $row->fp_quality ),
					'flagged_level_text' => FlaggedRevs::getQualityLevelText( $row->fp_quality )
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
		return 'public';
	}

	public function getAllowedParams() {
		$namespaces = FlaggedRevs::getReviewNamespaces();
		return array (
			'start' => array (
				ApiBase::PARAM_TYPE => 'integer'
			),
			'end' => array (
				ApiBase::PARAM_TYPE => 'integer'
			),
			'dir' => array (
				ApiBase::PARAM_DFLT => 'newer',
				ApiBase::PARAM_TYPE => array (
					'newer',
					'older'
				)
			),
			'namespace' => array (
				ApiBase::PARAM_DFLT => !$namespaces ?
					NS_MAIN : $namespaces[0],
				ApiBase::PARAM_TYPE => 'namespace',
				ApiBase::PARAM_ISMULTI => true,
			),
			'filterredir' => array (
				ApiBase::PARAM_DFLT => 'all',
				ApiBase::PARAM_TYPE => array (
					'redirects',
					'nonredirects',
					'all'
				)
			),
			'filterlevel' =>  array (
				ApiBase::PARAM_DFLT => null,
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN  => 0,
				ApiBase::PARAM_MAX  => 2,
			),
			'limit' => array (
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN  => 1,
				ApiBase::PARAM_MAX  => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			)
		);
	}

	public function getParamDescription() {
		return array (
			'start' => 'Start listing at this page id.',
			'end' => 'Stop listing at this page id.',
			'namespace' => 'The namespaces to enumerate.',
			'filterredir' => 'How to filter for redirects',
			'filterlevel' => 'How to filter by quality (0=sighted,1=quality)',
			'limit' => 'How many total pages to return.',
			'dir' => array(
				'In which direction to list.',
				'*newer: list the newest pages first',
				'*older: list the oldest pages first'
			)				
		);
	}

	public function getDescription() {
		return array(
			'Returns a list of pages, that have been reviewed,',
			'sorted by page id.'
		);
	}

	protected function getExamples() {
		return array (
			'Show a list of reviewed pages',
			' api.php?action=query&list=reviewedpages&rpnamespace=0&rpfilterlevel=0',
			'Show info about some reviewed pages',
			' api.php?action=query&generator=reviewedpages&grplimit=4&prop=info',
		);
	}
	
	public function getVersion() {
		return __CLASS__.': $Id: ApiQueryReviewedpages.php 69932 2010-07-26 08:03:21Z tstarling $';
	}
}
