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

		// Config for experiments and treatment groups.
		$scripts .= "\n\n<!-- A/B Testing code -->\n";

		// NOTE: This is embedded instead of being an extra request because it needs to be done this early on the page (and external blocking-requests are time-consuming).
		$js = AbTesting::getJsExperimentConfig() . "\n" . AbTesting::getJsFunction();

		$scripts .= Html::inlineScript( $js )."\n";

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Returns a string containing javascript for the configuration of experiments and test
	 * groups.
	 */
	public static function getJsExperimentConfig(){
		$js = "";

		// TODO: Generate config JS from the experiments and treatment_groups tables in the datamart.
		// TODO: Generate config JS from the experiments and treatment_groups tables in the datamart.

		return $js;
	} // end getJsExperimentConfig()
	
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
