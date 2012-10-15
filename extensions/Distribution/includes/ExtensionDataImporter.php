<?php

/**
 * File holding the ExtensionDataImporter class.
 * 
 * @file DistributionRelease.php
 * @ingroup Distribution
 * 
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Static class for importing extension data via maintenance scripts.
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Jeroen De Dauw
 */
class ExtensionDataImporter {
	
	/**
	 * Saves the metadata of a single extension version into the db.
	 * 
	 * @since 0.1
	 * 
	 * @param $metaData Array
	 */
	public static function saveExtensionMetadata( array $metaData ) {
		// Get the database connections.
		$dbr = wfGetDB( DB_SLAVE );

		// Query for existing units with the same name.
		$unit = $dbr->selectRow(
			'distribution_units',
			array( 'unit_id' ),
			array( 'unit_name' => $metaData['name'] )
		);		
		
		// Map the unit values to the db schema.
		$unitValues = array(
			'unit_name' => $metaData['name'],
			'unit_url' => $metaData['url'],		
			'current_version_nr' => $metaData['version'],
			'current_desc' => $metaData['description'],
			'current_authors' => $metaData['authors'],
		);
		
		// Map the version values to the db schema.
		$versionValues = array(
			'version_status' => DistributionRelease::mapState( DistributionRelease::getDefaultState() ), // TODO
			'version_desc' => $metaData['description'],
			'version_authors' => $metaData['authors'],
			'version_directory' => $metaData['directory'],
			'version_entrypoint' => $metaData['entrypoint'],
			'version_release_date' => $metaData['date']
		);		
		
		// Insert or update the unit.
		if ( $unit == false ) {
			self::insertUnit( $unitValues, $versionValues );
		}
		else {
			self::updateUnit( $unit, $unitValues, $versionValues, $dbr );
		}
	}
	
	/**
	 * Inserts a new unit and creates a new version for this unit.
	 * 
	 * @since 0.1
	 * 
	 * @param $unitValues Array
	 * @param $versionValues Array
	 */
	protected static function insertUnit( array $unitValues, array $versionValues ) {
		$dbw = wfGetDB( DB_MASTER );
		
		// Create the unit.
		$dbw->insert(
			'distribution_units',
			$unitValues
		);
		
		$versionValues['version_nr'] = $unitValues['current_version_nr'];
		$versionValues['version_unit_id'] = $dbw->insertId();
		
		// Create the version for the unit.
		$dbw->insert(
			'distribution_unit_versions',
			$versionValues
		);
		
		// Update the unit to point to the just created version.
		$dbw->update(
			'distribution_units',
			array( 'unit_current' => $dbw->insertId() ),
			array( 'unit_id' => $versionValues['version_unit_id'] )
		);
	}
	
	/**
	 * Updates an existing unit. If the unit already had a version for the current number,
	 * it will be updated, otherwise a new one will be created.
	 * 
	 * @since 0.1
	 * 
	 * @param $unit
	 * @param $unitValues Array
	 * @param $versionValues Array
	 * @param $dbr DatabaseBase
	 */
	protected static function updateUnit( $unit, array $unitValues, array $versionValues, DatabaseBase $dbr ) {
		$dbw = wfGetDB( DB_MASTER );
		
		$versionValues['version_unit_id'] = $unit->unit_id;
		
		// Query for existing versions of this unit with the same version number.
		$version = $dbr->selectRow(
			'distribution_unit_versions',
			array( 'version_id' ),
			array( 
				'unit_id' => $unit->unit_id,
				'version_nr' => $unitValues['current_version_nr']
			)
		);
		
		// If this version does not exist yet, create it.
		if ( $version == false ) {
			$versionValues['version_nr'] = $unitValues['current_version_nr'];
			
			$dbw->insert(
				'distribution_unit_versions',
				$versionValues
			);
			
			$unitValues['unit_current'] = $dbw->insertId();			
		}
		else {
			// If the version already exists, update it.
			$dbw->update(
				'distribution_unit_versions',
				$versionValues,
				array( 'version_id' => $version->version_id )
			);	

			$unitValues['unit_current'] = $version->version_id;
		}
		
		// Update the unit so it points to the correct version.
		$dbw->update(
			'distribution_units',
			$unitValues,
			array( 'unit_id' => $unit->unit_id )
		);		
	}		
	
}