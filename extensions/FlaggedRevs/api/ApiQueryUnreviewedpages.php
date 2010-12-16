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
 * Query module to list pages unreviewed pages
 *
 * @ingroup FlaggedRevs
 */
class ApiQueryUnreviewedpages extends ApiQueryGeneratorBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ur' );
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
		$this->addWhereRange(
			'page_title',
			'newer',
			$params['start'],
			$params['end']
		);
		$this->addJoinConds(
			array('flaggedpages' => array ('LEFT JOIN','fp_page_id=page_id') )
		);
		$this->addWhere( 'fp_page_id IS NULL OR
			fp_quality < '.intval($params['filterlevel']) );
		$this->addOption(
			'USE INDEX',
			array( 'page' => 'name_title', 'flaggedpages' => 'PRIMARY' )
		);

		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array (
				'page_id',
				'page_namespace',
				'page_title',
				'page_len',
				'page_latest',
			) );
		} else {
			$this->addFields( $resultPageSet->getPageTableFields() );
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
				$this->setContinueEnumParameter( 'start', $row->page_title );
				break;
			}

			if ( is_null( $resultPageSet ) ) {
				$title = Title::newFromRow( $row );
				$data[] = array(
					'pageid' => intval( $row->page_id ),
					'ns'     => intval( $title->getNamespace() ),
					'title'  => $title->getPrefixedText(),
					'revid'  => intval( $row->page_latest ),
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
				ApiBase::PARAM_TYPE => 'string'
			),
			'end' => array (
				ApiBase::PARAM_TYPE => 'string'
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
				ApiBase::PARAM_DFLT => 0,
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN  => 0,
				ApiBase::PARAM_MAX  => 2,
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
			'start' => 'Start listing at this page title.',
			'end' => 'Stop listing at this page title.',
			'namespace' => 'The namespaces to enumerate.',
			'filterredir' => 'How to filter for redirects',
			'filterlevel' => 'How to filter by quality (0=sighted,1=quality)',
			'limit' => 'How many total pages to return.',			
		);
	}

	public function getDescription() {
		return array(
			'Returns a list of pages, that have not been reviewed (to "filterlevel"),',
			'sorted by page title.'
		);
	}

	protected function getExamples() {
		return array (
			'Show a list of unreviewed pages',
			' api.php?action=query&list=unreviewedpages&urnamespace=0&urfilterlevel=0',
			'Show info about some unreviewed pages',
			' api.php?action=query&generator=unreviewedpages&urnamespace=0&gurlimit=4&prop=info',
		);
	}
	
	public function getVersion() {
		return __CLASS__.': $Id: ApiQueryUnreviewedpages.php 69932 2010-07-26 08:03:21Z tstarling $';
	}
}
