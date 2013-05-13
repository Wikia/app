<?php

namespace Wikia\Sass\Filter;
use Minify_CSS_Compressor;


class MinifyFilter extends Filter {

	public function process( $contents ) {
		wfProfileIn(__METHOD__);
		$contents = Minify_CSS_Compressor::process($contents);
		wfProfileOut(__METHOD__);
		return $contents;
	}

}