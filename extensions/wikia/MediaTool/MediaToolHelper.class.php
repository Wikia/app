<?php

/**
 * MediaTool Helper
 * @author mech
 */
class MediaToolHelper extends WikiaModel {

	public function secToMMSS($seconds) {
		$min = floor($seconds / 60);
		$sec = $seconds - ($min * 60);

		return ( $min . ':' . (( strlen($sec) < 2 ) ? '0' : '') . $sec );
	}
}