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

	/**
	 * Performs an INSERT query that adds rows to store parameters of a given instance of a flag.
	 * @param int $flagId
	 * @param int $flagTypeId
	 * @param array $params `paramName` => `paramValue`
	 * @return bool
	 */
	public function createParametersForFlag( \DatabaseBase $db, $flagId, $flagTypeId, $params ) {
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

		$status = $db->affectedRows() > 0;

		return $status;
	}

	/**
	 * Performs an UPDATE query on parameters of a given flag.
	 * @param int $flagId
	 * @param array $params `paramName` => `paramValue`
	 * @return bool
	 */
	public function updateParametersForFlag( \DatabaseBase $db, $flagId, $params ) {
		foreach ( $params as $paramName => $paramValue ) {
			( new \WikiaSQL )
				->UPDATE( self::FLAGS_PARAMS_TABLE )
				->SET( 'param_value', $paramValue )
				->WHERE( 'flag_id' )->EQUAL_TO( $flagId )
				->AND_( 'param_name' )->EQUAL_TO( $paramName )
				->run( $db );
		}

		$affectedRows = $db->affectedRows();
		$allParams = count( $params );

		if ( $affectedRows < $allParams ) {
			$flagParams = $this->getParametersForFlag( $db, $flagId );
			$paramsDiff = array_diff_key( $params, $flagParams[$flagId]['params'] );

			if ( !empty( $paramsDiff ) ) {
				$this->createParametersForFlag( $db, $flagId, $flagParams[$flagId]['flag_type_id'], $paramsDiff );
				$affectedRows += count( $paramsDiff );
			}
		}

		$status = $affectedRows === $allParams;

		return $status;
	}

	/**
	 * Fetch all parameters for given flag instance
	 *
	 * @param \DatabaseBase $db
	 * @param $flagId
	 * @return bool|mixed
	 */
	public function getParametersForFlag( \DatabaseBase $db, $flagId ) {
		$flagsParams = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( 'flags_params' )
			->WHERE( 'flag_id' )->IN( $flagId )
			->runLoop( $db, function( &$flagsParams, $row ) {
				if ( !isset( $flagsParams[$row->flag_id] ) ) {
					$flagsParams[$row->flag_id] = [
						'flag_id' => $row->flag_id,
						'flag_type_id' => $row->flag_type_id
					];
				}
				$flagsParams[$row->flag_id]['params'][$row->param_name] = $row->param_value;
			} );

		return $flagsParams;
	}

	/**
	 * Update parameter name for given flag type
	 *
	 * @param int $flagTypeId
	 * @param int|string $paramName
	 * @param int|string $newParamName
	 * @return bool
	 */
	public function updateParameterNameForFlag( $flagTypeId, $paramName, $newParamName ) {
		$db = $this->getDatabase( DB_MASTER );

		( new \WikiaSQL )
			->UPDATE( self::FLAGS_PARAMS_TABLE )
			->SET( 'param_name', $newParamName )
			->WHERE( 'flag_type_id' )->EQUAL_TO( $flagTypeId )
			->AND_( 'param_name' )->EQUAL_TO( $paramName )
			->run( $db );

		$status = $db->affectedRows() > 0;

		$db->commit();

		return $status;
	}

	/**
	 * Remove parameter for given flat type
	 *
	 * @param int $flagTypeId
	 * @param int|string $paramName
	 * @return bool
	 */
	public function removeParameterFromFlag( $flagTypeId, $paramName ) {
		$db = $this->getDatabase( DB_MASTER );

		( new \WikiaSQL )
			->DELETE( self::FLAGS_PARAMS_TABLE )
			->WHERE( 'flag_type_id' )->EQUAL_TO( $flagTypeId )
			->AND_( 'param_name' )->EQUAL_TO( $paramName )
			->run( $db );

		$status = $db->affectedRows() > 0;

		$db->commit();

		return $status;
	}

	/**
	 * Checks if a parameter can be use as a name HTML attribute value.
	 * @param $paramName
	 * @return bool
	 */
	public static function isValidParameterName( $paramName ) {
		return preg_match( self::FLAG_PARAMETER_REGEXP, $paramName ) === 0;
	}
}
