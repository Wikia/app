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
	protected static $instance = NULL;
	
	public static function getInstance() {
		if (self::$instance === NULL) {
			$class = get_called_class();
			self::$instance = new $class();
		}
		return self::$instance;
	}
	
	public function getDB( $db_type = DB_SLAVE ) {
	   return $this->wf->GetDB( $db_type );
	}

	public function getSharedDB( $db_type = DB_SLAVE ) {
	   return $this->wf->GetDB( $db_type, array(), $this->wg->ExternalSharedDB );
	}
	
	public function getDatawareDB( $db_type = DB_SLAVE ) {
		return $this->wf->GetDB( $db_type, array(), $this->wg->ExternalDatawareDB );
	}
	
	public function getStatsDB( $db_type = DB_SLAVE ) {
		return $this->wf->GetDB( $db_type, array(), $this->wg->StatsDB );
	}
}
