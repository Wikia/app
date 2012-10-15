<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Base class of poll views
 */
abstract class qp_AbstractPollView extends qp_AbstractView {

	# polls may have their questions displayed in a table
	# where $perRow specifies amount of questions in table row
	var $perRow;
	var $currCol;

	function setPerRow( $perRow ) {
		$this->perRow = $this->currCol = $perRow;
	}

} /* end of qp_AbstractPollView class */
