<?php
/**
 * Created on May 05, 2011
 *
 * Categorize extension
 *
 * Copyright (C) 2011 faure dot thomas at gmail dot com
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
 * Query module to get the list of the Categories beginning by a given string.
 *
 * @ingroup API
 * @ingroup Extensions
 */
class ApiQueryCategorize extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cat' );
	}
	public function execute() {
		$params = $this->extractRequestParams();
		$strquery = $params['strquery'];
		$result = $this->getResult();

		if ( isset( $strquery ) && $strquery != NULL ) {
			$searchString = str_replace( '%' , '\%' , $strquery );
			$searchString = str_replace( '_' , '\_' , $searchString );
			$searchString = str_replace( '|' , '%'  , $searchString );
			$dbr = $this->getDB(); ;

			$suggestStrings = array();

			$this->addTables( 'categorylinks' );
			$this->addFields( 'DISTINCT cl_to' );
			$this->addWhere ( " UPPER(CONVERT(cl_to using latin1)) LIKE UPPER(CONVERT('$searchString%' using latin1)) " );
			$res = $this->select( __METHOD__ );
			while ( $row = $res->fetchObject() ) {
				array_push( $suggestStrings, $row->cl_to );
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $row->cl_to );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->afl_timestamp ) );
					break;
				}
			}
			$dbr->freeResult( $res );
		}
	$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'category' );
	}

	public function getAllowedParams() {
		return array(
			'strquery' => array(
				ApiBase::PARAM_TYPE => 'string'
			)
		);
	}

	public function getParamDescription() {
		return array(
			'strquery' => 'The string to search'
			);
	}

	public function getDescription() {
		return 'Show categories beginning by "strquery" string.';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			// to fill
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=categorize&catstrquery=helloworld'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: Categorize.api.php xxxxx 2010-05-09 10:04:00Z Faure.thomas $';
	}
}