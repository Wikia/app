<?php

/**
 * API extension for Distribution that provides information about MediaWiki and extension updates.
 * 
 * @file ApiUpdates.php
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
 * Provides information about MediaWiki and extension updates.
 * Poviding invalid extension names will not raise any errors.
 * 
 * @since 0.1
 *
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Jeroen De Dauw
 */
class ApiUpdates extends ApiBase {
	
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
		
		foreach( $params['state'] as &$state ) {
			$state = DistributionRelease::mapState( $state );
		}
		
		if ( array_key_exists( 'mediawiki', $params ) ) {
			$this->checkForCoreUpdates( $params['mediawiki'], $params['state'] );
		}
		
		if ( array_key_exists( 'extensions', $params ) ) {
			$this->checkForAllExtensionUpdates( $params['extensions'], $params['state'] );
		}		
	}
	
	/**
	 * Checks if there are any updates for MediaWiki core.
	 * Found updates are added to the API call result.
	 * 
	 * @since 0.1
	 * 
	 * @param $mwVersion String
	 * @param $states Array: a list of allowed release states.
	 */
	protected function checkForCoreUpdates( $mwVersion, array $states ) {
		$latestRelease = ReleaseRepo::singleton()->getLatestStableRelease();

		if ( $latestRelease !== false && version_compare( $latestRelease->getNumber(), $mwVersion, '>' ) ) {
			$this->getResult()->addValue( null, 'mediawiki', $latestRelease->getNumber() );	
		}
	}
	
	/**
	 * Checks if there are any updates for the provided extensions.
	 * Found updates are added to the API call result.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensions String: list of extensions, |-seperated, each element being extensionName;versionNumber.
	 * @param $states Array: a list of allowed release states.
	 */	
	protected function checkForAllExtensionUpdates( $extensions, array $states ) {
		$extensions = explode( '|', $extensions );
		
		foreach( $extensions as $extension ) {
			 $parts = explode( ';', $extension, 2 );
			 
			 if ( count( $parts ) == 2 ) {
			 	$this->checkForExtensionUpdates( $parts[0], $parts[1], $states );
			 }
		}
	}
	
	/**
	 * Checks if there are any updates for the provided extensions.
	 * Found updates are added to the API call result.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensionName String
	 * @param $extensionVersion String
	 * @param $states Array: a list of allowed release states.
	 */
	protected function checkForExtensionUpdates( $extensionName, $extensionVersion, array $states ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$extension = $dbr->selectRow(
			'distribution_units',
			array(
				'unit_id'
			),
			array( 'unit_name' => $extensionName )
		);

		if ( $extension !== false ) {
			$version = $dbr->selectRow(
				'distribution_unit_versions',
				array(
					'version_id',
					'version_nr',
					'version_status'
				),
				array(
					'version_unit_id' => $extension->unit_id,
					'version_status' => $states
				),
				'Database::selectRow',
				array( 'ORDER BY version_release_date DESC' )
			);

			if ( $version !== false && version_compare( $version->version_nr, $extensionVersion, '>' ) ) {
				$version->version_status = DistributionRelease::unmapState( $version->version_status );
				$this->getResult()->addValue( 'extensions', $extensionName, $version );				
			}
		}
	}
	
	/**
	 * @see ApiBase::getAllowedParams
	 * 
	 * @since 0.1
	 */	
	public function getAllowedParams() {
		return array(
			'mediawiki' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'extensions' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'state' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => DistributionRelease::getStates(),
				ApiBase::PARAM_DFLT => DistributionRelease::getDefaultState(),
			),
		);
	}
	
	/**
	 * @see ApiBase::getParamDescription
	 * 
	 * @since 0.1
	 */	
	public function getParamDescription() {
		return array(
			'mediawiki'  => 'The installed version of MediaWiki',
			'extensions' => 'A |-seperated list of extensions and their version, seperated by a semicolon',
			'state'      => 'A list of allowed release states'
		);
	}
	
	/**
	 * @see ApiBase::getDescription
	 * 
	 * @since 0.1
	 */	
	public function getDescription() {
		return array(
			'Provides information about MediaWiki and extension updates'
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
			'api.php?action=updates&mediawiki=1.16',
			'api.php?action=updates&extensions=Maps;0.6',
			'api.php?action=updates&mediawiki=1.16&extensions=Maps;0.6|Validator;0.3',
			'api.php?action=updates&mediawiki=1.16&extensions=Maps;0.6|Validator;0.3&state=stable|beta|rc',
		);
	}	
	
	/**
	 * @see ApiBase::getVersion
	 * 
	 * @since 0.1
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiUpdates.php 71123 2010-08-15 15:11:58Z jeroendedauw $';
	}
	
}