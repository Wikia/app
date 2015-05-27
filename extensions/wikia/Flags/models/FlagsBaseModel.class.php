<?php

/**
 * A base model for the extension with the data and methods necessary to handle database connections
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class FlagsBaseModel extends \WikiaModel {
	protected
		$status,
		$error;

	/**
	 * Names of tables used by the extension
	 */
	const FLAGS_TO_PAGES_TABLE = 'flags_to_pages';
	const FLAGS_TYPES_TABLE = 'flags_types';
	const FLAGS_PARAMS_TABLE = 'flags_params';

	/**
	 * Connects to a database with an intent of performing SELECT queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForRead() {
		return wfGetDB( DB_SLAVE, [], $this->wg->FlagsDB );
	}

	/**
	 * Connects to a database with an intent of performing INSERT, UPDATE and DELETE queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForWrite() {
		return wfGetDB( DB_MASTER, [], $this->wg->FlagsDB );
	}

	public function debug( $a ) {
		wfDebug( "Flags: " . json_encode( $a ) . "\n" );
	}
}
