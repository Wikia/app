<?php

namespace Wikia\Sass\Filter;

/**
 * CssImports filter handles embedding external CSS files referenced in @import directives.
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class CssImportsFilter extends Filter {

	protected $rootDir;

	public function __construct( $rootDir ) {
		$this->rootDir = $rootDir;
	}

	public function process( $contents ) {
		wfProfileIn(__METHOD__);

		// since this is stored in a string, remember to escape quotes, slashes, etc.
		$importRegexOne = "/@import ['\\\"]([^\\n]*?\\.css)['\\\"]([^;\\n]*)(;|\\n|$)/is";
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*?\\.css)['\\\"]?[ \\)]([^;\\n]*)(;|\\n|$)/is";

		$matches = array();
		while ((0 < preg_match_all($importRegexOne, $contents, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $contents, $matches, PREG_SET_ORDER))) {
			foreach($matches as $match) {
				$lineMatched = $match[0];
				$fileName = trim($match[1]);
				$fileContents = file_get_contents($this->rootDir . $fileName);
				$contents = str_replace($lineMatched, $fileContents, $contents);
			}
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

}