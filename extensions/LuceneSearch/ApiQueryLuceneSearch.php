<?php

/*
 * Created on July 30, 2007
 *
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2008 Bryan Tong Minh Bryan.TongMinh@gmail.com
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

require_once('LuceneSearch_body.php');

/**
 * Query module to perform full text search within wiki titles and content
 * 
 * @addtogroup API
 */
class ApiQueryLuceneSearch extends ApiQueryGeneratorBase {

	public function __construct($query, $moduleName) {
		// Keep the prefix compatible with list=search
		parent :: __construct($query, $moduleName, 'sr');
	}

	public function execute() {
		$this->run();
	}

	public function executeGenerator($resultPageSet) {
		$this->run($resultPageSet);
	}

	private function run($resultPageSet = null) {

		$params = $this->extractRequestParams();

		$limit = $params['limit'];
		$offset = $params['offset'];
		$query = $params['search'];	
		$namespaces = $params['namespace'];
		
		if (is_null($query) || empty($query))
			$this->dieUsage("empty search string is not allowed", 'param-search');

		$results = LuceneSearchSet::newFromQuery( 'search', $query, $namespaces, $limit, $offset, 'ignore' );
		
		if ($results === false) {
			$this->dieUsage( 'There was a problem with Lucene backend', 'lucene-backend' );
		}

		$data = array_values( $results->iterateResults( 
			array( 'ApiQueryLuceneSearch', 'formatItem'), 
			is_null($resultPageSet) ) );
		
		if ( $results->getTotalHits() >= ($params['offset'] + $params['limit']) )
			$this->setContinueEnumParameter('offset', $params['offset'] + $params['limit']);
		
		if (is_null($resultPageSet)) {
			$result = $this->getResult();
			$result->setIndexedTagName($data, 'p');
			$result->addValue('query', $this->getModuleName(), $data);
		} else {
			$resultPageSet->populateFromTitles($data);
		}
	}
	
	public static function formatItem( $result, $asArray ) {
		$title = $result->getTitle();
		// Broken title
		if ( is_null( $title ) ) return null;
		if ( $asArray ) {
			return array(
				'ns' => intval($title->getNamespace()),
				'title' => $title->getPrefixedText());
		} else {
			return $title;
		}
	}

	public function getAllowedParams() {
		return array (
			'search' => null,
			'namespace' => array (
				ApiBase :: PARAM_DFLT => 0,
				ApiBase :: PARAM_TYPE => 'namespace',
				ApiBase :: PARAM_ISMULTI => true, 
			),
			'offset' => 0,
			'limit' => array (
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			)
		);
	}

	public function getParamDescription() {
		return array (
			'search' => 'Search for all page titles (or content) that has this value.',
			'namespace' => 'The namespace(s) to enumerate.',
			'offset' => 'Use this value to continue paging (return by query)',
			'limit' => 'How many total pages to return.'
		);
	}

	public function getDescription() {
		return 'Perform a full text search';
	}

	protected function getExamples() {
		return array (
			'api.php?action=query&list=search&srsearch=meaning',
			'api.php?action=query&generator=search&prop=info',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryLuceneSearch.php 31522 2008-03-03 21:27:18Z btongminh $';
	}
}

