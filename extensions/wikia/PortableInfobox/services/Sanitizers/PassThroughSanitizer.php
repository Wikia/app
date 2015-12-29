<?php

class PassThroughSanitizer extends NodeSanitizer {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		return $data;
	}
}
