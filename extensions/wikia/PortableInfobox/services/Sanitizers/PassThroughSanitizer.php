<?php

class PassThroughSanitizer extends NodeSanitizer implements NodeTypeSanitizerInterface {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		return $data;
	}
}
