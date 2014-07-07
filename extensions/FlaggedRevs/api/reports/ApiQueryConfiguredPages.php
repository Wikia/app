<?php

/**
 * Created on April 8, 2011
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
 * Query module to list pages with custom review configurations
 *
 * @ingroup FlaggedRevs
 */
class ApiQueryConfiguredpages extends ApiQueryGeneratorBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cp' );
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
		$this->addTables( array( 'page', 'flaggedpage_config', 'flaggedpages' ) );
		if ( isset( $params['namespace'] ) ) {
			$this->addWhereFld( 'page_namespace', $params['namespace'] );
		}
		if ( isset( $params['default'] ) ) {
			// Convert readable 'stable'/'latest' to 0/1 (DB format)
			$override = ( $params['default'] === 'stable' ) ? 1 : 0;
			$this->addWhereFld( 'fpc_override', $override );
		}
		if ( isset( $params['autoreview'] ) ) {
			// Convert readable 'none' to '' (DB format)
			$level = ( $params['autoreview'] === 'none' ) ? '' : $params['autoreview'];
			$this->addWhereFld( 'fpc_level', $level );
		}

		$this->addWhereRange(
			'fpc_page_id',
			$params['dir'],
			$params['start'],
			$params['end']
		);
		$this->addJoinConds( array(
			'flaggedpage_config' => array( 'INNER JOIN', 'page_id=fpc_page_id' ),
			'flaggedpages' 		 => array( 'LEFT JOIN', 'page_id=fp_page_id' )
		) );
		$this->addOption(
			'USE INDEX',
			array( 'flaggedpage_config' => 'PRIMARY' )
		);

		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array(
				'page_id',
				'page_namespace',
				'page_title',
				'page_len',
				'page_latest',
				'fpc_page_id',
				'fpc_override',
				'fpc_level',
				'fpc_expiry',
				'fp_stable'
			) );
		} else {
			$this->addFields( $resultPageSet->getPageTableFields() );
			$this->addFields( 'fpc_page_id' );
		}

		$limit = $params['limit'];
		$this->addOption( 'LIMIT', $limit + 1 );
		$res = $this->select( __METHOD__ );

		$data = array();
		$count = 0;
		foreach( $res as $row ) {
			if ( ++$count > $limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'start', $row->fpc_page_id );
				break;
			}

			if ( is_null( $resultPageSet ) ) {
				$title = Title::newFromRow( $row );
				$data[] = array(
					'pageid' 			 => intval( $row->page_id ),
					'ns' 				 => intval( $row->page_namespace ),
					'title' 			 => $title->getPrefixedText(),
					'last_revid' 		 => intval( $row->page_latest ),
					'stable_revid' 		 => intval( $row->fp_stable ),
					'stable_is_default'	 => intval( $row->fpc_override ),
					'autoreview'		 => $row->fpc_level,
					'expiry'			 => ( $row->fpc_expiry === 'infinity' ) ?
						'infinity' : wfTimestamp( TS_ISO_8601, $row->fpc_expiry ),
				);
			} else {
				$resultPageSet->processDbRow( $row );
			}
		}

		if ( is_null( $resultPageSet ) ) {
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
		// Replace '' with more readable 'none' in autoreview restiction levels
		$autoreviewLevels = FlaggedRevs::getRestrictionLevels();
		$autoreviewLevels[] = 'none';
		return array(
			'start' => array(
				ApiBase::PARAM_TYPE 	=> 'integer'
			),
			'end' => array(
				ApiBase::PARAM_TYPE 	=> 'integer'
			),
			'dir' => array(
				ApiBase::PARAM_DFLT 	=> 'newer',
				ApiBase::PARAM_TYPE 	=> array( 'newer', 'older' )
			),
			'namespace' => array(
				ApiBase::PARAM_DFLT 	=> null,
				ApiBase::PARAM_TYPE 	=> 'namespace',
				ApiBase::PARAM_ISMULTI 	=> true,
			),
			'default' => array(
				ApiBase :: PARAM_DFLT 	=> null,
				ApiBase :: PARAM_TYPE 	=> array( 'latest', 'stable' ),
			),
			'autoreview' => array(
				ApiBase :: PARAM_DFLT 	=> null,
				ApiBase :: PARAM_TYPE 	=> $autoreviewLevels,
			),
			'limit' => array(
				ApiBase::PARAM_DFLT 	=> 10,
				ApiBase::PARAM_TYPE 	=> 'limit',
				ApiBase::PARAM_MIN  	=> 1,
				ApiBase::PARAM_MAX  	=> ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 	=> ApiBase::LIMIT_BIG2
			)
		);
	}

	public function getParamDescription() {
		return array(
			'start' 		=> 'Start listing at this page id.',
			'end' 			=> 'Stop listing at this page id.',
			'namespace' 	=> 'The namespaces to enumerate.',
			'default'   	=> 'The default page view version.',
			'autoreview'	=> 'Review/autoreview restriction level.',
			'limit' 		=> 'How many total pages to return.',
			'dir' 			=> array(
				'In which direction to list.',
				'*newer: list the newest pages first',
				'*older: list the oldest pages first'
			)
		);
	}

	public function getDescription() {
		return 'Enumerate all pages that have custom review configurations';
	}

	public function getExamples() {
		return array(
			'Show a list of pages with custom review configurations',
			' api.php?action=query&list=configuredpages&cpnamespace=0',
			'Get some info about pages with custom review configurations',
			' api.php?action=query&generator=configuredpages&gcplimit=4&prop=info',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryConfiguredPages.php 99814 2011-10-14 21:28:59Z reedy $';
	}
}
