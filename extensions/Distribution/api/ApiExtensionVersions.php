<?php

/**
 * API extension for Distribution that provides information about extension versions.
 * 
 * @file ApiExtensionVersions.php
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
 * Provides information about extension versions.
 * 
 * @since 0.1
 *
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Jeroen De Dauw
 */
class ApiExtensionVersions extends ApiBase {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param $main
	 * @param $action
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 */
	public function execute() {
		$params = $this->extractRequestParams();
		
		// TODO
	}	
	
	/**
	 * @see ApiBase::getAllowedParams
	 * 
	 * @since 0.1
	 */	
	public function getAllowedParams() {
		return array(
		);
	}
	
	/**
	 * @see ApiBase::getParamDescription
	 * 
	 * @since 0.1
	 */	
	public function getParamDescription() {
		return array(
		);
	}
	
	/**
	 * @see ApiBase::getDescription
	 * 
	 * @since 0.1
	 */	
	public function getDescription() {
		return array(
			'Provides information about extension versions'
		);
	}
		
	/**
	 * @see ApiBase::getPossibleErrors
	 * 
	 * @since 0.1
	 */	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}

	/**
	 * @see ApiBase::getExamples
	 * 
	 * @since 0.1
	 */
	public function getExamples() {
		return array(
		);
	}	
	
	/**
	 * @see ApiBase::getVersion
	 * 
	 * @since 0.1
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiExtensionVersions.php 71103 2010-08-15 08:49:35Z jeroendedauw $';
	}
	
}