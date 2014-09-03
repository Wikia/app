<?php

class NjordModel {

	protected $db;

	public function __construct( $db = null ) {
		$this->db = $db !== null ? $db : wfGetDB( DB_SLAVE );
	}
}
