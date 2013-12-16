<?php

class BopFmRailController extends WikiaController {

	/**
	 * Hooks into GetRailModuleList and adds the bop.fm module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// 1395 is a bit below the Wikia Game Helper (1400) in case there is a game, but above most other things.
		$modules[1395] = array('BopFmRail', 'bop', null);

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render bop.fm widget in the rail module.
	 */
	public function bop() {
		// TODO: SET ANY VARIABLES HERE THAT THE RAIL MODULE WILL NEED.
		//$this->setVal( $name, $value );

		// Basic template.
		$this->response->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/BopFmRail_Contents.php' );
	}

}
