<?php

namespace Wikia\Sass\Filter;
use CSSJanus;

/**
 * Janus filter performs LTR to RTL conversion if language is RTL.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class JanusFilter extends Filter {

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