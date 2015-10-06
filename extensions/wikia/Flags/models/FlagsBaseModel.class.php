<?php

/**
 * A base model for the extension with the data and methods necessary to handle database connections
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

use Wikia\Util\GlobalStateWrapper;

class FlagsBaseModel extends \WikiaModel {
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
		return $this->getDatabase( DB_SLAVE );
	}

	/**
	 * Connects to a database with an intent of performing INSERT, UPDATE and DELETE queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForWrite() {
		return $this->getDatabase( DB_MASTER );
	}

	/**
	 * Get connection to flags database
	 *
	 * Flags database is encoded in utf-8, while in most cases MW communicate with
	 * databases using latin1, so sometimes we get strings in wrong encoding.
	 * The only way to force utf-8 communication (adding SET NAMES utf8) is setting
	 * global variable wgDBmysql5.
	 *
	 * @see https://github.com/Wikia/app/blob/dev/includes/db/DatabaseMysqlBase.php#L113
	 *
	 * @param int $dbType master or slave
	 * @return \DatabaseBase
	 */
	protected function getDatabase( $dbType ) {
		$wrapper = new GlobalStateWrapper( [
			'wgDBmysql5' => true
		] );

		$db = $wrapper->wrap( function () use ( $dbType ) {
			return wfGetDB( $dbType, [], $this->wg->FlagsDB );
		} );

		return $db;
	}

	/**
	 * Checks if values of $paramsToCheck are keys in $originalParams.
	 * @param array $originalParams An array to check the keys in
	 * @param mixed $paramsToCheck An array of required fields or a string with a name
	 * @return bool
	 * @throws \MissingParameterApiException
	 */
	protected function areParamsSet( Array $originalParams, $paramsToCheck ) {
		if ( !is_array( $paramsToCheck ) ) {
			$paramsToCheck = [ $paramsToCheck ];
		}
		foreach ( $paramsToCheck as $paramName ) {
			if ( !isset( $originalParams[$paramName] ) ) {
				throw new \MissingParameterApiException( $paramName );
			}
		}
		return true;
	}

	/**
	 * Checks if the $paramsToCheck consists only of positive numbers.
	 * @param mixed $paramsToCheck An array of numbers, a numeric string or an integer
	 * @return bool
	 * @throws \InvalidParameterApiException
	 */
	protected function arePositiveNumbers( $paramsToCheck ) {
		if ( !is_array( $paramsToCheck ) ) {
			$paramsToCheck = [ $paramsToCheck ];
		}
		foreach ( $paramsToCheck as $param ) {
			if ( !is_numeric( $param ) || $param <= 0 )	{
				throw new \InvalidParameterApiException( $param );
			}
		}
		return true;
	}

	/**
	 * Checks if all elements of $paramsToCheck are arrays
	 * @param Array $paramsToCheck An array of arrays
	 * @return bool
	 * @throws \InvalidParameterApiException
	 */
	protected function areArrays( Array $paramsToCheck ) {
		foreach ( $paramsToCheck as $param ) {
			if ( !is_array( $param ) ) {
				throw new \InvalidParameterApiException( $param );
			}
		}
		return true;
	}

	public function debug( $a ) {
		wfDebug( "Flags: " . json_encode( $a ) . "\n" );
	}
}
