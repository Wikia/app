<?php

require_once dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) .
	'/maintenance/commandLine.inc';

if ( isset( $options['help'] ) ) {
	echo "Imports data into DataCenter tables.\n";
	echo "Usage:\n";
	echo "\tphp extensions/DataCenter/CLI/Import.php --dummy \n";
	echo "\tImports dummy data into tables, useful for testing.\n";
} else {
	if ( isset( $options['dummy'] ) ) {
		echo "Importing dummy data into DataCenter tables...\n";
		require_once dirname( dirname( __FILE__ ) ) . '/DataCenter.db.php';
		function randAlphaNum() {
			return strtoupper( substr( md5( rand() ), 0, 10 ) );
		}
		function randNum() {
			return rand( 1111111111, 9999999999 );
		}
		$data = array(
			array(
				'function' => array( 'DataCenterDBLocation', 'newFromValues' ),
				'fields' => array(
					'tense', 'name', 'region', 'latitude', 'longitude'
				),
				'values' => array(
					array( 'present', 'PMTPA', 'Tampa, FL', 27.98141, -82.451141 ),
					array( 'present', 'SFO', 'San Francisco, CA', 37.775196, -122.419204 ),
				)
			),
			array(
				'function' => array( 'DataCenterDBSpace', 'newFromValues' ),
				'fields' => array(
					'tense', 'name', 'location', 'width', 'height', 'depth', 'power'
				),
				'values' => array(
					array( 'present', 'Server Room', 1, 3, 3, 7, 1000 ),
					array( 'present', 'Data Closet', 2, 3, 3, 5, 200 ),
				)
			),
			array(
				'function' => array( 'DataCenterDBAsset', 'newFromType' ),
				'parameter' => 'rack',
				'fields' => array(
					'tense', 'model', 'location', 'asset', 'serial'
			    ),
				'values' => array(
			        array( 'present', 2, 1, randAlphaNum(), randNum() ),
			        array( 'present', 2, 1, randAlphaNum(), randNum() ),
			        array( 'present', 2, 1, randAlphaNum(), randNum() ),
			        array( 'present', 2, 1, randAlphaNum(), randNum() ),
			        array( 'present', 2, 1, randAlphaNum(), randNum() ),
			        array( 'present', 2, 2, randAlphaNum(), randNum() ),
				),
			),
			array(
				'function' => array( 'DataCenterDBAsset', 'newFromType' ),
				'parameter' => 'object',
				'fields' => array(
					'tense', 'model', 'location', 'asset', 'serial'
			    ),
				'values' => array(
			        array( 'present', 1, 2, randAlphaNum(), randNum() ),
			        array( 'present', 1, 2, randAlphaNum(), randNum() ),
			        array( 'present', 1, 2, randAlphaNum(), randNum() ),
			        array( 'present', 1, 2, randAlphaNum(), randNum() ),
			        array( 'present', 2, 2, randAlphaNum(), randNum() ),
			        array( 'present', 3, 2, randAlphaNum(), randNum() ),
				),
			),
			array(
				'function' => array( 'DataCenterDBModel', 'newFromType' ),
				'parameter' => 'rack',
				'fields' => array(
					'manufacturer', 'name', 'kind', 'units'
			    ),
				'values' => array(
			        array( 'Rittal', 'TS-42', 'Rack', 42 ),
			        array( 'Rittal', 'TS-44', 'Rack', 44 ),
			        array( 'Rittal', 'TS-47', 'Rack', 47 ),
				),
			),
			array(
				'function' => array( 'DataCenterDBModel', 'newFromType' ),
				'parameter' => 'object',
				'fields' => array(
					'manufacturer', 'name', 'kind', 'form_factor', 'units', 'depth', 'power'
			    ),
				'values' => array(
			        array( 'Sun', 'Cobalt RaQ XTR', 'Web Server', 'rackunit', 2, 3, 400 ),
			        array( 'Cisco', 'Catalyst 2950', 'Switch', 'rackunit', 1, 1, 100 ),
			        array( 'APC', 'Smart-UPS 3000VA', 'UPS', 'rackunit', 5, 2, 20 ),
				),
			),
			array(
				'function' => array( 'DataCenterDBModel', 'newFromType' ),
				'parameter' => 'port',
				'fields' => array(
					'name', 'kind', 'category', 'format'
			    ),
				'values' => array(
			        array( '1000Base-ZX', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-CX4', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-ER', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-Kx', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-LR', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-LRM', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-LX4', 'Ethernet', 'network', 'digital' ),
			        array( '10GBase-ZR', 'Ethernet', 'network', 'digital' ),
			        array( 'LC/1000Base-LX', 'Ethernet', 'network', 'digital' ),
			        array( 'LC/1000Base-SX', 'Ethernet', 'network', 'digital' ),
			        array( 'LC/100Base-FX', 'Ethernet', 'network', 'digital' ),
			        array( 'LC/100Base-SX', 'Ethernet', 'network', 'digital' ),
			        array( 'LC/10GBase-SR', 'Ethernet', 'network', 'digital' ),
			        array( 'RJ-45/1000Base-T', 'Ethernet', 'network', 'digital' ),
			        array( 'RJ-45/100Base-TX', 'Ethernet', 'network', 'digital' ),
			        array( 'RJ-45/10Base-T', 'Ethernet', 'network', 'digital' ),
			        array( 'SC/1000Base-LX', 'Ethernet', 'network', 'digital' ),
			        array( 'SC/1000Base-SX', 'Ethernet', 'network', 'digital' ),
			        array( 'SC/100Base-FX', 'Ethernet', 'network', 'digital' ),
			        array( 'SC/100Base-SX', 'Ethernet', 'network', 'digital' ),
			        array( 'BNC/10Base2', 'Token Ring', 'network', 'digital' ),
			        array( 'RS-232', 'Serial', 'serial', 'digital' ),
			        array( 'RS-442', 'Serial', 'serial', 'digital' ),
			        array( 'IEC 120v', 'Power', 'power', 'none' ),
			        array( 'IEC 240v', 'Power', 'power', 'none' ),
			        array( 'Type A 120v', 'Power', 'power', 'none' ),
			        array( 'Type B 120v', 'Power', 'power', 'none' ),
			        array( 'Type C 240v', 'Power', 'power', 'none' ),
			        array( 'Type F 240v', 'Power', 'power', 'none' ),
			        array( 'PS2', 'User Input', 'serial', 'digital' ),
			        array( 'USB 1.0', 'USB', 'serial', 'digital' ),
			        array( 'USB 2.0', 'USB', 'serial', 'digital' ),
			        array( 'IEEE 1394a', 'FireWire', 'serial', 'digital' ),
			        array( 'IEEE 1394b', 'FireWire', 'serial', 'digital' ),
			        array( 'IEEE 1394c', 'FireWire', 'serial', 'digital' ),
			        array( 'VGA', 'Video', 'video', 'analog' ),
			        array( 'DVI', 'Video', 'video', 'digital' ),
			        array( 'MiniDVI', 'Video', 'video', 'digital' ),
			        array( 'MicroDVI', 'Video', 'video', 'digital' ),
			        array( 'Optical Audio', 'Audio', 'audio', 'digital' ),
			        array( 'Analog Audio', 'Audio', 'audio', 'analog' ),
			        array( 'Hybrid Audio', 'Audio', 'audio', 'mixed' ),
			        array( 'Other', 'Port', 'other', 'none' ),
				),
			),
			array(
				'function' => array( 'DataCenterDBMetaField', 'newFromValues' ),
				'fields' => array(
					'name', 'format'
			    ),
				'values' => array(
			        array( 'WikiMedia Owned', 'boolean' ),
			        array( 'Notes', 'text' ),
			        array( 'Weight (LBS)', 'number' ),
			        array( 'Assigned User', 'string' ),
				),
			),
			array(
				'function' => array( 'DataCenterDBMetaValue', 'newFromValues' ),
				'fields' => array(
					'component_category', 'component_type', 'component_id', 'field', 'value'
			    ),
				'values' => array(
			        array( 'facility', 'location', 2, 1, true ),
			        array( 'facility', 'location', 2, 2, 'The best place to be!' ),
				),
			),
			array(
				'function' => array( 'DataCenterDBPlan', 'newFromValues' ),
				'fields' => array(
					'tense', 'space', 'name', 'note'
			    ),
				'values' => array(
			        array( 'present', 1, 'PMTA 1.0', 'Current configuration' ),
			        array( 'present', 2, 'SFO 1.0', 'Incomplete but current' ),
			        array( 'future', 1, 'PMTA 1.1', 'Upcoming configuration' ),
				),
			),
			array(
				'function' => array( 'DataCenterDBAssetLink', 'newFromValues' ),
				'fields' => array(
					'name', 'plan', 'tense', 'parent_link', 'asset_type', 'asset_id', 'x', 'y', 'z', 'orientation'
			    ),
				'values' => array(
			        array( 'Rack 1A', 1, 'present', null, 'rack', 1, 2, 1, null, 1 ),
			        array( 'Rack 1B', 1, 'present', null, 'rack', 2, 2, 2, null, 1 ),
			        array( 'Rack 1C', 1, 'present', null, 'rack', 3, 2, 3, null, 1 ),
			        array( 'Rack 1D', 1, 'present', null, 'rack', 4, 2, 4, null, 1 ),
			        array( 'Rack 1E', 1, 'present', null, 'rack', 5, 2, 5, null, 1 ),
			        array( 'Rack 1A', 2, 'present', null, 'rack', 6, 3, 4, null, 1 ),
			        array( 'Web Server A', 2, 'present', 6, 'object', 1, null, null, 1, 0 ),
			        array( 'Web Server B', 2, 'present', 6, 'object', 2, null, null, 3, 0 ),
			        array( 'Web Server C', 2, 'present', 6, 'object', 3, null, null, 5, 0 ),
			        array( 'Web Server D', 2, 'present', 6, 'object', 4, null, null, 7, 0 ),
			        array( 'Switch', 2, 'present', 6, 'object', 5, null, null, 9, 0 ),
			        array( 'UPS', 2, 'present', 6, 'object', 6, null, null, 10, 0 ),
				),
			),
			array(
				'function' => array( 'DataCenterDBModelLink', 'newFromValues' ),
				'fields' => array(
					'name', 'quantity', 'parent_type', 'parent_id', 'child_type', 'child_id'
			    ),
				'values' => array(
			        array( 'Ethernet', 2, 'object', 1, 'port', 14 ),
			        array( 'Ethernet', 24, 'object', 2, 'port', 14 ),
			        array( 'Power In', 1, 'object', 3, 'port', 27 ),
			        array( 'Power Out', 8, 'object', 3, 'port', 24 ),
				),
			),
			array(
				'function' => array( 'DataCenterDBMetaFieldLink', 'newFromValues' ),
				'fields' => array(
					'field', 'component_category', 'component_type'
			    ),
				'values' => array(
			        array( 1, 'facility', 'location' ),
			        array( 1, 'facility', 'space' ),
			        array( 1, 'asset', 'rack' ),
			        array( 1, 'asset', 'object' ),
			        array( 2, 'facility', 'location' ),
			        array( 2, 'facility', 'space' ),
			        array( 2, 'asset', 'rack' ),
			        array( 2, 'asset', 'object' ),
			        array( 2, 'model', 'rack' ),
			        array( 2, 'model', 'object' ),
			        array( 2, 'model', 'port' ),
			        array( 3, 'asset', 'object' ),
			        array( 4, 'asset', 'object' ),
				),
			),
		);
		foreach ( $data as $type ) {
			// Checks if fields, values and function exist
			if (
				isset( $type['fields'] ) &&
				isset( $type['values'] ) &&
				isset( $type['function'] )
			) {
				$values = array();
				foreach ( $type['values'] as $row ) {
					// Correlates data
					$values = array();
					if ( count( $row ) == count( $type['fields'] ) ) {
						foreach ( $type['fields'] as $index => $field ) {
							$values[$field] = $row[$index];
						}
					} else {
						throw new MWException(
							'Mismatch of fields and values lengths!'
						);
					}
					// Checks if call and parameter exist
					if ( isset( $type['parameter'] ) ) {
						// Builds row object
						$row = call_user_func(
							$type['function'], $type['parameter'], $values
						);
					// Alernatively checks if only call exists
					} else {
						// Builds row object
						$row = call_user_func( $type['function'], $values );
					}
					// Inserts row
					$row->insert();
					if ( $row instanceof DataCenterDBComponent ) {
						$row->insertChange(
							array(
								'type' => 'import',
								'note' => 'Initial import'
							)
						);
					}
				}
			} else {
				throw new MWException(
					'Incomplete data!'
				);
			}
		}
	} else {
		echo "Run with --help for usage information.\n";
	}
}