<?php

/**
 * A model that reflects parameters of a Flag and provides an interface for managing them.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class FlagParameter extends FlagsBaseModel {

	const FLAG_PARAMETER_REGEXP = "/[^A-Za-z0-9-_:.]/"; // See W3C documentation for the name and id HTML attributes

	private
		$status;

	/**
	 * Performs an INSERT query that adds rows to store parameters of a given instance of a flag.
	 * @param int $flagId
	 * @param int $flagTypeId
	 * @param array $params `paramName` => `paramValue`
	 * @return bool
	 */
	public function createParametersForFlag( $flagId, $flagTypeId, $params ) {
		$db = $this->getDatabaseForWrite();

		$values = [];
		foreach ( $params as $paramName => $paramValue ) {
			$values[] = [ $flagId, $flagTypeId, $paramName, $paramValue ];
		}

		( new \WikiaSQL )
			->INSERT()->INTO( self::FLAGS_PARAMS_TABLE, [
				'flag_id',
				'flag_type_id',
				'param_name',
				'param_value',
			] )
			->VALUES( $values )
			->run( $db );

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
	}

	/**
	 * Performs an UPDATE query on parameters of a given flag.
	 * @param int $flagId
	 * @param array $params `paramName` => `paramValue`
	 * @return bool
	 */
	public function updateParametersForFlag( $flagId, $params ) {
		$db = $this->getDatabaseForWrite();

		foreach ( $params as $paramName => $paramValue ) {
			( new \WikiaSQL )
				->UPDATE( self::FLAGS_PARAMS_TABLE )
				->SET( 'param_value', $paramValue )
				->WHERE( 'flag_id' )->EQUAL_TO( $flagId )
				->AND_( 'param_name' )->EQUAL_TO( $paramName )
				->run( $db );
		}

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
	}

	public static function isValidParameterName( $paramName ) {
		return preg_match( self::FLAG_PARAMETER_REGEXP, $paramName ) === 0;
	}
}
