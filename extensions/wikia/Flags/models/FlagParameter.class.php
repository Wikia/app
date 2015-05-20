<?php

namespace Flags\Models;

class FlagParameter extends FlagsBaseModel {

	const FLAG_PARAMETER_REGEXP = "/[^A-Za-z0-9-_:.]/"; // See W3C documentation for the name and id HTML attributes

	private
		$status;

	public function createParametersForFlag( $flagId, $flagTypeId, $wikiId, $pageId, $params ) {
		$db = $this->getDatabaseForWrite();

		$values = [];
		foreach ( $params as $paramName => $paramValue ) {
			$values[] = [ $flagId, $flagTypeId, $wikiId, $pageId, $paramName, $paramValue ];
		}

		$sql = ( new \WikiaSQL )
			->INSERT()->INTO( self::FLAGS_PARAMS_TABLE, [
				'flag_id',
				'flag_type_id',
				'wiki_id',
				'page_id',
				'param_name',
				'param_value',
			] )
			->VALUES( $values )
			->run( $db );

		$this->status = $db->affectedRows() > 0;

		$db->commit();

		return $this->status;
	}

	public function updateParametersForFlag( $flagId, $params ) {
		$db = $this->getDatabaseForWrite();

		foreach ( $params as $paramName => $paramValue ) {
			$sql = ( new \WikiaSQL )
				->UPDATE( self::FLAGS_PARAMS_TABLE )
				->SET( $paramName, $paramValue )
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
