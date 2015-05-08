<?php

namespace Flags\Models;

class FlagParameter extends FlagsModel {
	private
		$status;

	public function createParametersForFlag( $flagId, $flagTypeId, $wikiId, $pageId, $params ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL )
			->INSERT( self::FLAGS_PARAMS_TABLE );

		foreach ( $params as $paramName => $paramValue ) {
			$sql->VALUES( $flagId, $wikiId, $pageId, $flagTypeId, $paramName, $paramValue );
		}

		$sql->run( $db );

		$db->commit();

		$this->status = $db->affectedRows() > 0;

		return $this->status;
	}

	public function deleteParametersForFlag( $flagId ) {
		$db = $this->getDatabaseForWrite();

		$sql = ( new \WikiaSQL() )
			->DELETE( self::FLAGS_PARAMS_TABLE )
			->WHERE( 'flag_id' )->EQUAL_TO( $flagId )
			->run( $db );

		$this->status = $db->commit();

		return $this->status;
	}
}
