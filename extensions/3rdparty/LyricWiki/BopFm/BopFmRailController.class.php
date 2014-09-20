<?php

class BopFmRailController extends WikiaController {

	/**
	 * Hooks into GetRailModuleList and adds the bop.fm module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// Move BopFm module above the TOP_RIGHT_BOXAD (side effect: this module will not be lazy-loaded). - LYR-113
		$modules[1495] = array('BopFmRail', 'bop', null);

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render bop.fm widget in the rail module.
	 */
	public function bop() {
		global $wgTitle;
		wfProfileIn(__METHOD__);

		// Only show the widget on the main namespace.
		if($wgTitle->getNamespace() == NS_MAIN){
			// Set variables to pass to the rail module.
			$title = $wgTitle->getText();
			$colonIndex = strpos($title, ":"); // this doesn't work for artists with colons in their name (eg: Sixx:A.M.).
			if($colonIndex === false){
				// no colon... we must be on an artist page.
				$artist = $title;
				$songName = "";
			} else {
				$artist = substr($title, 0, $colonIndex);
				$songName = substr($title, $colonIndex+1);
			}
			//$pageUrl = urlencode($wg->Title->getFullURL()); // don't pass this to the bop.fm widget

			$this->setVal( 'artist', $artist );
			$this->setVal( 'songName', $songName );
		}

		// If this is a song page (in the right namespace(s)), render the module, otherwise render nothing w/a small html comment.
		if(empty($songName)){
			$this->response->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/BopFmRail_Empty.php' );
		} else {
			$this->response->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/BopFmRail_Contents.php' );
		}

		wfProfileOut(__METHOD__);
	}

}
