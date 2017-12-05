<?php

namespace Wikia\Sass\Filter;

/**
 * CdnRewrite filter handles rewriting local paths to CDN paths
 * when URLs are marked to be processed that way.
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class CdnRewriteFilter extends Filter {

	protected $cdnUrl;
	public function __construct( $cdnUrl ) {
		$this->cdnUrl = $cdnUrl;
	}

	public function process( $contents ) {
		wfProfileIn(__METHOD__);

		if (strpos($contents, "wgResourceBasePath") !== false) { // faster to skip the regex in most cases
			// Because of fonts in CSS, we have to allow for lines with multiple url()s in them.
			// This will rewrite all but the last URL on the line (the last regex will fix the final URL and remove the special comment).
			$wasChanged = true;

			// TODO: refactor?
			while($wasChanged) {
				$changedCss = preg_replace("/([\(][\"']?)(\/[^\/][^\n]*?)([, ]url[^\n]*?)(\s*\/\*\s*[\\\$]?wgResourceBasePath\s*\*\/)/is", '\\1'.$this->cdnUrl.'\\2\\3\\4', $contents);
				if($changedCss != $contents) {
					$wasChanged = true;
					$contents = $changedCss;
				} else {
					$wasChanged = false;
				}
			}

			$contents = preg_replace("/([\(][\"']?)(\/[^\/][^\n]*?)\s*\/\*\s*[\\\$]?wgResourceBasePath\s*\*\//is", '\\1'.$this->cdnUrl.'\\2', $contents);
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

}