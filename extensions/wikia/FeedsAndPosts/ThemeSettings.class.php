<?php
/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 13/11/2018
 * Time: 14:44
 */

namespace Wikia\FeedsAndPosts;

use SassUtil;

class ThemeSettings {
	public function get() {
		return SassUtil::convertColorsToRgb(SassUtil::getOasisSettings());
	}
}
