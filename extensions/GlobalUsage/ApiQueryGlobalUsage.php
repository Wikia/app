<?php
/**
 * Created on November 8, 2009
 *
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2009 Bryan Tong Minh <bryan.tongminh@gmail.com>
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

class ApiQueryGlobalUsage extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName, 'gu' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$prop = array_flip( $params['prop'] );

		$pageIds = $this->getPageSet()->getAllTitlesByNamespace();
		if ( !empty( $pageIds[NS_FILE] ) ) {
			# Create a query and set parameters
			$pageIds = $pageIds[NS_FILE];
			$query = new GlobalUsageQuery( array_keys( $pageIds ) );
			if ( !is_null( $params['continue'] ) ) {
				if ( !$query->setOffset( $params['continue'] ) )
					$this->dieUsage( 'Invalid continue parameter', 'badcontinue' );
			}
			$query->setLimit( $params['limit'] );
			$query->filterLocal( $params['filterlocal'] );

			# Execute the query
			$query->execute();

			# Create the result
			$apiResult = $this->getResult();
			foreach ( $query->getResult() as $image => $wikis ) {
				$pageId = intval( $pageIds[$image] );
				foreach ( $wikis as $wiki => $result ) {
					foreach ( $result as $item ) {
						if ( $item['namespace'] ) {
							$title = "{$item['namespace']}:{$item['title']}";
						} else {
							$title = $item['title'];
						}
						$result = array(
							'title' => $title,
							'wiki' => WikiMap::getWikiName( $wiki )
						);
						if ( isset( $prop['url'] ) ) {
							$result['url'] = WikiMap::getForeignUrl( $item['wiki'], $title );
						}
						if ( isset( $prop['pageid'] ) ) {
							$result['pageid'] = $item['id'];
						}
						if ( isset( $prop['namespace'] ) ) {
							$result['ns'] = $item['namespace_id'];
						}

						$fit = $apiResult->addValue( array(
								'query', 'pages', $pageId, 'globalusage'
							), null, $result );

						if ( !$fit ) {
							$continue = "{$item['image']}|{$item['wiki']}|{$item['id']}";
							$this->setIndexedTagName();
							$this->setContinueEnumParameter( 'continue',  $continue );
							return;
						}
					}
				}
			}
			$this->setIndexedTagName();

			if ( $query->hasMore() ) {
				$this->setContinueEnumParameter( 'continue', $query->getContinueString() );
			}
		}
	}

	private function setIndexedTagName() {
		$result = $this->getResult();
		$pageIds = $this->getPageSet()->getAllTitlesByNamespace();
		foreach ( $pageIds[NS_FILE] as $id ) {
			$result->setIndexedTagName_internal(
					array( 'query', 'pages', $id, 'globalusage' ),
					'gu'
			);
		}
	}

	public function getAllowedParams() {
		return array(
				'prop' => array(
					ApiBase::PARAM_DFLT => 'url',
					ApiBase::PARAM_TYPE => array(
						'url',
						'pageid',
						'namespace',
					),
					ApiBase::PARAM_ISMULTI => true,
				),
				'limit' => array(
					ApiBase :: PARAM_DFLT => 10,
					ApiBase :: PARAM_TYPE => 'limit',
					ApiBase :: PARAM_MIN => 1,
					ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
					ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
				),
				'continue' => null,
				'filterlocal' => false,
		);
	}

	public function getParamDescription() {
		return array(
			'prop' => array(
				'What properties to return',
				' url        - Adds url ',
				' pageid     - Adds page id',
				' namespace  - Adds namespace id',
			),
			'limit' => 'How many links to return',
			'continue' => 'When more results are available, use this to continue',
			'filterlocal' => 'Filter local usage of the file',
		);
	}

	public function getDescription() {
		return 'Returns global image usage for a certain image';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array ( 'code' => 'badcontinue', 'info' => 'Invalid continue parameter' ),
		) );
	}

	public function getExamples() {
		return array (
				"Get usage of File:Example.jpg:",
				"  api.php?action=query&prop=globalusage&titles=File:Example.jpg",
			);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryGlobalUsage.php 96092 2011-09-02 11:37:52Z reedy $';
	}
}
