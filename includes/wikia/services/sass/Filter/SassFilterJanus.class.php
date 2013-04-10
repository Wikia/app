<?php

/**
 * Janus filter performs LTR to RTL conversion if language is RTL.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class SassFilterJanus {

	protected $rootDir;
	protected $rtl;

	public function __construct( $rootDir, $rtl ) {
		$this->rootDir = $rootDir;
		$this->rtl = $rtl;
	}

	public function process( $contents ) {
		wfProfileIn(__METHOD__);

		if ($this->rtl) {
			$contents = CSSJanus::transform($contents);
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

}