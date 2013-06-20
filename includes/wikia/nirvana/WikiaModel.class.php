<?php

/**
 * Nirvana Framework - Model class
 * 
 * This is a minimalist class which defines $app $wf and $wg plus some DB helpers
 * Use this for anything that is NOT a controller but still needs framework vars
 * If you do NOT need DB access consider extending WikiaObject instead
 *
 * @ingroup nirvana
 *
 * @author Owen Davis <owen(at)wikia-inc.com>
 */
abstract class WikiaModel extends WikiaObject {
	/* Handy helper functions for getting a database connection */

	public function getDB( $db_type = DB_SLAVE ) {
		return wfGetDB( $db_type );
	}

	public function getWikiDB( $db_type = DB_SLAVE, $db_name = false ) {
		return wfGetDB( $db_type, array(), $db_name );
	}

	public function getSharedDB( $db_type = DB_SLAVE ) {
	   return wfGetDB( $db_type, array(), $this->wg->ExternalSharedDB );
	}
	
	public function getDatawareDB( $db_type = DB_SLAVE ) {
		return wfGetDB( $db_type, array(), $this->wg->ExternalDatawareDB );
	}
	
	public function getStatsDB( $db_type = DB_SLAVE ) {
		return wfGetDB( $db_type, array(), $this->wg->StatsDB );
	}
}
