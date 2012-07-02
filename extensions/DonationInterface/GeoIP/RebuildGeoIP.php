<?php
/**
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
 *
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../maintenance/Maintenance.php' );

class RebuildGeoIP extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Rebuild GeoIP data from a CSV file.';
		$this->addArg( 'csv-file', 'CSV-formatted file with geographic IP data.', true );
	}

	public function memoryLimit() {
		return '200M';
	}

	public function execute() {
		$dbw = wfGetDB( DB_MASTER );

		// Perform this in a transaction so an failed load doesn't erase current data.
		$dbw->begin();

		// Clear existing GeoIP data.
		try {
			$dbw->delete( 'geoip', '*', __METHOD__ );
		} catch ( DBQueryError $e ) {
			$this->error( 'ERROR: Could not delete existing geographic data. Is the GeoIP schema loaded?', true );
		}

		// Load fresh data from the first (and only) argument.
		$filename = $this->getArg( 0 );
		$lines = exec( 'wc -l ' . $filename );
		$handle = fopen( $filename, 'r' );

		$count = 0;
		while ( ( $data = fgetcsv( $handle, 256, ',' ) ) !== false ) {
			// Output a nice progress bar.
			if ( $count % 1000 == 0 ) {
				$progress = ceil( ( $count / $lines ) * 50 );
				$this->output( '[' . str_repeat( '=', $progress ) .
					str_repeat( ' ', 50 - $progress ) . '] ' .
					ceil( ( $count / $lines ) * 100 ) . '%' . "\r"
				);
			}
			++$count;

			$record = array(
				'begin_ip_long' => IP::toUnsigned( $data[0] ),
				'end_ip_long'   => IP::toUnsigned( $data[1] ),
				'country_code'  => $data[4],
			);
			$dbw->insert( 'geoip', $record, __METHOD__ );
		}
		$this->output( "\n" );

		$dbw->commit();
		$this->output( 'Successfully loaded ' . $count . ' geographic IP ranges.' . "\n" );
	}
}

$maintClass = 'RebuildGeoIP';
require_once( DO_MAINTENANCE );