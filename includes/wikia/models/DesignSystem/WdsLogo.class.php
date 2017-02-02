<?php

class WdsLogo {
	/**
	 * @deprecated
	 */
	public $header;
	public $module;

	/**
	 * @param WdsLinkImage $header
	 * @return WdsLogo
	 */
	public function setHeader( WdsLinkImage $header ) {
		$this->header = $header;

		return $this;
	}

	/**
	 * @param WdsLogoModule $module
	 * @return WdsLogo
	 */
	public function setModule( WdsLogoModule $module ) {
		$this->module = $module;

		return $this;
	}
}
