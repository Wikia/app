<?php
/**
 * This model implements Query result models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMQueryResult extends WikiObjectModelCollection {

	public function __construct() {
		parent::__construct( 'q_result' );
	}
}
