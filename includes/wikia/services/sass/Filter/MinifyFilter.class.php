<?php

namespace Wikia\Sass\Filter;
use CSSMin;


class MinifyFilter extends Filter {

	public function process( $contents ) {
		wfProfileIn(__METHOD__);
		$contents = CSSMin::minify($contents);
		wfProfileOut(__METHOD__);
		return $contents;
	}

}