<?php
/**
 * @author Sean Colombo
 *
 * Since these hooks need to be available on any wiki where WikiFactory is enabled (even
 * when the extensions that they pertain to aren't available) they have all been aggregated here.
 */


Class WikiFactoryChangedHooks {

	/**
	 * Hook handler - will install the datbase and messaging changes for recipes sites with RecipesTweaks.
	 *
	 * @access public
	 * @static
	 */
	static public function recipesTweaks( $cv_name, $city_id, $value ) {
		wfProfileIn( __METHOD__ );
		Wikia::log( __METHOD__, $city_id, "{$cv_name} = {$value}" );
		if( $cv_name == "wgEnableRecipesTweaksExt" && $value == true ) {

			// Detect if this is a recipes site...
			$isAlreadyRecipes = false;
			$dbName = WikiFactory::IDtoDB($city_id);
			$dbr = wfGetDB(DB_MASTER, array(), $dbName);
			$queryString = "SHOW COLUMNS FROM watchlist";
			$result = $dbr->query($queryString, __METHOD__);
			if (!$result) {
				print 'Could not run query: ' . mysql_error() . "<br/>\nQuery: $queryString";
			} else if (mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_assoc($result)) {
					if($row['Field'] == "wl_wikia_addedtimestamp"){
						$isAlreadyRecipes = true;
					}
				}
			}

			if($isAlreadyRecipes){
				$wgOut->addHTML("<div style='border:#0f0 solid 1px;background-color:#cfc'>This database is already set up as a recipes site.  You're good to go!</div>");
			} else {


// TODO: Once this part is tested, start merging in the changes from SpecialBecomeRecipes.
$wgOut->addHTML("Not a recipes site yet... would perform upgrades here.");


			}

		}
		wfProfileOut( __METHOD__ );
		return true;
	}

}
