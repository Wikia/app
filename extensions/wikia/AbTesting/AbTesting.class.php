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
		wfProfileIn( __METHOD__ );

		// TODO: EMBED THE EXPERIMENT CONFIG IN HERE (use memcached for the generated json string).
		$scripts .= "\n\n<!-- A/B TESTING! -->\n";
//		$scripts .= Html::inlineScript("var wgNow = new Date();");

		// NOTE: This is embedded instead of being an extra request because it needs to be done this early on the page (and external blocking-requests are time-consuming).
		$scripts .= "\n\n<!-- A/B Testing getTestGroup() -->\n";
		$scripts .= Html::inlineScript( AbTesting::getJsFunction() )."\n";

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * Returns the javascript for the getTestGroup() function as a string.
	 */
	public static function getJsFunction(){
		ob_start();
		
// TODO: WRITE THE BODY OF THE FUNCTION!
		?>function getTestGroup(){
			
		}
		<?php
		$jsString = ob_get_clean();

		// We're embedding this in every page, so minify it.
		$jsString = AssetsManagerBaseBuilder::minifyJs( $jsString );
		
		return $jsString;
	} // end getJsFunction()

}
