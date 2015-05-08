<?php

namespace Flags\Models;

class FlagsModel extends \WikiaModel {

	const FLAGS_TO_PAGES_TABLE = 'flags_to_pages';
	const FLAGS_TYPES_TABLE = 'flags_types';
	const FLAGS_PARAMS_TABLE = 'flags_params';

	protected function getDatabaseForRead() {
		return wfGetDB( DB_SLAVE, [], $this->wg->ExternalSharedDB );
	}

	protected function getDatabaseForWrite() {
		return wfGetDB( DB_MASTER, [], $this->wg->ExternalSharedDB );
	}

	public function debug( $a ) {
		wfDebug( "Flags: " . json_encode( $a ) . "\n" );
	}
}
