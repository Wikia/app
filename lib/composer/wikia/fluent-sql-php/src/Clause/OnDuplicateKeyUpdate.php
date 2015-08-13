<?php

/**
 * OnDuplicateKeyUpdate
 *
 * @author Armon Rabiyan <armon@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class OnDuplicateKeyUpdate implements ClauseInterface {
	protected $columns;

	public function __construct( $columns ) {
		$this->columns = [];
		foreach ( $columns as $column => $value ) {
			$this->columns[] = new Set( $column, $value );
		}
	}

	public function build( Breakdown $bk, $tabs ) {
		$bk->line( $tabs + 1 );
		$bk->append( ' ON DUPLICATE KEY UPDATE ' );
		$columnCount = count( $this->columns );
		$columnIndex = 1;
		/** @var Set $columnSet */
		foreach ( $this->columns as $columnSet ) {

			$columnSet->build( $bk, $tabs );
			if ( $columnIndex++ < $columnCount ) {
				$bk->append( ',' );
			}
		}
	}
}
