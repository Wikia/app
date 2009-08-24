<?php
/**
 * Search Page Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterControllerSearch extends DataCenterController {

	/* Functions */

	public function __construct(
		array $path
	) {
		// Actions
	}

	public function search(
		array $data,
		$type
	) {
		DataCenterWidgetSearch::redirect( $data );
		return null;
	}
}