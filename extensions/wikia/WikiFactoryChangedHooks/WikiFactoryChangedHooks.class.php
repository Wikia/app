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
			$dbr = &wfGetDB(DB_MASTER, 'wikifactory', $dbName);
			$queryString = "SHOW COLUMNS FROM watchlist";
			$res = $dbr->query($queryString, __METHOD__);
			foreach( $res as $row ) {
				if($row->Field == "wl_wikia_addedtimestamp"){
					$isAlreadyRecipes = true;
				}
			}

			if(!$isAlreadyRecipes){
				$numErrors = 0;
				// Perform database alterations. - For the moment, these will throw exceptions if they don't work.  To change that, pass 'true' as third parameter.
				if(!$dbr->query("ALTER TABLE `watchlist` ADD `wl_wikia_addedtimestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP", __METHOD__)){
					$numErrors++;
				}
				if(!$dbr->query("ALTER TABLE `watchlist` ADD INDEX ( `wl_wikia_addedtimestamp` )", __METHOD__)){
					$numErrors++;
				}

				// Change certain messages.
				$numErrors += self::setMessage("MediaWiki:Watch", "Save this page");
				$numErrors += self::setMessage("MediaWiki:Unwatch", "Remove");
				$numErrors += self::setMessage("MediaWiki:watching", "Saving");
				$numErrors += self::setMessage("MediaWiki:unwatching", "Removing");
				$numErrors += self::setMessage("MediaWiki:addedwatchtext", "The page \"[[$1]]\" has been added to your Saved Pages");
				$numErrors += self::setMessage("MediaWiki:removedwatchtext", "The page \"[[$1]]\" has been removed from your Saved Pages");
				$numErrors += self::setMessage("MediaWiki:sf-link", "Share this page");
				$numErrors += self::setMessage("MediaWiki:Talkpage", "Messages");
				$numErrors += self::setMessage("MediaWiki:Article-comments-comments", "Add a Tip or Comment");
				$numErrors += self::setMessage("MediaWiki:Article-comments-post", "Post");
				$numErrors += self::setMessage("MediaWiki:Widget-title-community", "New recipes");

				// Success xor error message.
				//if($numErrors == 0){
				//} else {
				//}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Given the name of the message (with preceding "MediaWiki:"), updates it's contents
	 * to be the content passed in.  This happens as an edit from the currently logged in user.
	 *
	 * Returns an integer that is the number of errors (so 0 on success and one on failure).
	 */
	private static function setMessage($msgName, $content){
		global $wgOut;
		$numErrors = 0;
		$wgTitle = Title::newFromText( $msgName );
		if ( !$wgTitle ) {
			$wgOut->addHTML("ERROR: Invalid title: \"$msgName\"<br/>\n");
			$numErrors++;
		} else {
			$wgArticle = new Article( $wgTitle );

			# Do the edit
			$flags = 0;
			$summary = "Switching to Recipes messaging.";
			$success = $wgArticle->doEdit( $text, $summary, $flags);
			if ( $success ) {
				$wgOut->addHTML("Sucessfully updated \"$msgName\".<br/>\n");
			} else {
				$wgOut->addHTML("ERROR: Unable to update \"$msgName\".<br/>\n");
				$numErrors++;
			}
		}

		return $numErrors;
	} // end setMessage()

}
