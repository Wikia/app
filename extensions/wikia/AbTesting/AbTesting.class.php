<?php
/**
 * @author Sean Colombo
 * @date 20120501
 *
 * 
 */

class AbTesting {

	/**
	 * Add inline JS in <head> section
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true to tell other functions on the same hook to continue executing
	 */
	public static function onSkinGetHeadScripts($scripts) {

		// TODO: EMBED THE EXPERIMENT CONFIG IN HERE (use memcached for the generated json string).
		$scripts .= "\n\n<!-- A/B TESTING! -->\n";
//		$scripts .= Html::inlineScript("var wgNow = new Date();");

		return true;
	}
}
