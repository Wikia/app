<?php

interface NodeTypeSanitizerInterface {
	/**
	 * @desc sanitize infobox data element
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data );
}
