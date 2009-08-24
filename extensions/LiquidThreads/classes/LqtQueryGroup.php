<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class QueryGroup {
	protected $queries;

	function __construct() {
		$this->queries = array();
	}

	function addQuery( $name, $where, $options = array(), $extra_tables = array() ) {
		$this->queries[$name] = array( $where, $options, $extra_tables );
	}

	function extendQuery( $original, $newname, $where, $options = array(), $extra_tables = array() ) {
		if ( !array_key_exists( $original, $this->queries ) ) return;
		$q = $this->queries[$original];
		$this->queries[$newname] = array( array_merge( $q[0], $where ),
						  array_merge( $q[1], $options ),
						  array_merge( $q[2], $extra_tables ) );
	}

	function deleteQuery( $name ) {
		unset ( $this->queries[$name] );
	}

	function query( $name ) {
		if ( !array_key_exists( $name, $this->queries ) ) return array();
		list( $where, $options, $extra_tables ) = $this->queries[$name];
		return Threads::where( $where, $options, $extra_tables );
	}
}
