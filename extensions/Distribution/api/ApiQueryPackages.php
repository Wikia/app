<?php

/**
 * API extension for Distribution that allows the querieng of packages in the repository.
 * 
 * @file ApiQueryPackages.php
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Jeroen De Dauw
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

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * API class for the querieng of packages in the repository.
 * 
 * @since 0.1
 *
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Jeroen De Dauw
 */
class ApiQueryPackages extends ApiQueryBase {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param $main
	 * @param $action
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'pck' );
	}	
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 */
	public function execute() {
		
	}	
	
	/**
	 * @see includes/api/ApiBase#getAllowedParams()
	 * 
	 * @since 0.1
	 */
	public function getAllowedParams() {
		return array (
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'continue' => null,
			'filter' => array(
				ApiBase::PARAM_TYPE => array( 'term', 'author', 'tag' ),
				ApiBase::PARAM_DFLT => 'term',
			),
			'value' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),	
			'state' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => DistributionRelease::getStates(),
				ApiBase::PARAM_DFLT => DistributionRelease::getDefaultState(),
			),
			'mediawiki' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'extensions' => array(
				ApiBase::PARAM_TYPE => 'string',
			),			
		);
	}

	/**
	 * @see includes/api/ApiBase#getParamDescription()
	 * 
	 * @since 0.1
	 */
	public function getParamDescription() {
		return array (
			'continue'   => 'Number of the first package to return',
			'limit'      => 'Amount of packages to return',	
			'filter'     => 'What information should be filtered on',
			'value'      => 'The value to filter on',
			'state'      => 'A list of allowed release states',
			'mediawiki'  => 'MediaWiki version to filter on',
			'extensions' => 'Extensions to filter on' 
		);
	}

	/**
	 * @see includes/api/ApiBase#getDescription()
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return 'Provides release information about MediaWiki packages.';
	}
	
	/**
	 * @see includes/api/ApiBase#getPossibleErrors()
	 * 
	 * @since 0.1
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}	
	
	/**
	 * @see includes/api/ApiBase#getExamples()
	 * 
	 * @since 0.1
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=packages&pckvalue=semantic',
			'api.php?action=query&list=packages&pckfilter=tag&pckvalue=semantic&pcklimit=42',
		);
	}	
	
	/**
	 * @see ApiBase::getVersion
	 * 
	 * @since 0.1
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryPackages.php 71103 2010-08-15 08:49:35Z jeroendedauw $';
	}	
	
}