<?php

namespace Flags\Models;

class FlagParameter extends FlagsBaseModel {
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
}
