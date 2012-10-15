<?php

/**
 * API extension for Distribution that allows for the querieng of extensions in the repository.
 * 
 * @file ApiQueryExtensions.php
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
 * API class for the querieng of extensions in the repository.
 *
 * @since 0.1
 *
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Jeroen De Dauw
 */
class ApiQueryExtensions extends ApiQueryBase {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param $main
	 * @param $action
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'dst' );
	}

	/**
	 * Main method.
	 * 
	 * @since 0.1
	 */
	public function execute() {
		global $wgDistributionDownloads;
		
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		$this->addTables( 'distribution_units' );
		$this->addTables( 'distribution_unit_versions', 'unit_versions' );
		
		$this->addJoinConds( array(
			'distribution_units' => array(
				'INNER JOIN',
				'unit_id=unit_versions.version_unit_id'
			)
		) );
		
		$this->addFields( array(
			'unit_id',
			'unit_name',
			'unit_url',
			'version_nr',
			'version_status',
			'version_release_date',
			'version_directory',
			'version_entrypoint',
			'version_desc',
			'version_authors'
		) );
		
		foreach( $params['state'] as &$state ) {
			$state = DistributionRelease::mapState( $state );
		}
		
		$this->addWhereFld( 'version_status', $params['state'] );		
		
		switch ( $params['filter'] ) {
			case 'term' :
				// TODO
				$this->addWhere( "unit_name LIKE '%$params[value]%' OR current_desc LIKE '%$params[value]%'" );
				break;
			case 'author' :
				// TODO
				$this->addWhereFld( 'current_authors', $params['value'] );
				break;
			case 'tag' :
				// TODO
				break;
		}
		
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'unit_id' );				
		
		// Handle the continue parameter when it's provided.
		if ( !is_null( $params['continue'] ) ) {
			// TODO
		}	

		$count = 0;
		$extensions = $this->select( __METHOD__ );
		
		while ( $extension = $extensions->fetchObject() ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				// TODO
				//$this->setContinueEnumParameter( 'continue', '' );
				break;
			}

			// This is based on
			// http://search.cpan.org/~dagolden/CPAN-Meta-2.101670/lib/CPAN/Meta/Spec.pm
			$result = array(
				'name' => $extension->unit_name,
				'url' => $extension->unit_url,
				'download' => $wgDistributionDownloads . '/' . $extension->unit_name,			
				'description' => $extension->version_desc,
				'version' => $extension->version_nr,
				'authors' => $extension->version_authors,
				//'licence' => $extension->current_licence
			);
			
			$this->getResult()->addValue( array( 'query', $this->getModuleName() ), null, $result );			
		}
		
		$this->getResult()->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'extension' );
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
		);
	}

	/**
	 * @see includes/api/ApiBase#getParamDescription()
	 * 
	 * @since 0.1
	 */
	public function getParamDescription() {
		return array (
			'continue' => 'Number of the first extension to return',
			'limit'    => 'Amount of extensions to return',	
			'filter'   => 'What information should be filtered on',
			'value'    => 'The value to filter on',
			'state'    => 'A list of allowed release states'
		);
	}

	/**
	 * @see includes/api/ApiBase#getDescription()
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return 'Provides release information about MediaWiki extensions and packages.';
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
			'api.php?action=query&list=extensions&dstvalue=semantic',
			'api.php?action=query&list=extensions&dstfilter=tag&dstvalue=semantic&dstlimit=42',
		);
	}

	/**
	 * @since 0.1
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryExtensions.php 71103 2010-08-15 08:49:35Z jeroendedauw $';
	}
	
}