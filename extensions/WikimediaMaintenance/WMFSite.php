<?php
/**
 * A simple little class referring to a specific WMF site.
 * @ingroup Maintenance
 */
class WMFSite {
	var $suffix, $lateral, $url;

	function __construct( $s, $l, $u ) {
		$this->suffix = $s;
		$this->lateral = $l;
		$this->url = $u;
	}

	function getURL( $lang, $urlprotocol ) {
		$xlang = str_replace( '_', '-', $lang );
		return "$urlprotocol//$xlang.{$this->url}/wiki/\$1";
	}
}
