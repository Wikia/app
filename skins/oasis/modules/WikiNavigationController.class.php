<?php

class WikiNavigationController extends WikiaController {

	public function executeIndex() {
		//fb#1090
		$this->response->setVal( 'showMenu', ( $this->wg->User->isAllowed( 'read' ) && !( $this->wg->IsPrivateWiki && $this->wg->User->isAnon() ) ) );

		$model = new NavigationModel();

		$this->response->setVal( 'wikiMenuNodes', $model->getWiki(
			$this->request->getVal( 'msgName', false ),
			$this->request->getVal( 'wikitext', '' )
		) );

		// report wiki nav parse errors (BugId:15240)
		$this->response->setVal( 'parseErrors', $model->getErrors() );
	}

	/**
	 * Add global JS variable indicating that we're editing wiki nav message
	 *
	 * @param Array $vars list of global JS variables
	 * @return bool return true
	 */
	public static function onEditPageMakeGlobalVariablesScript(Array &$vars) {
		global $wgTitle;

		if (NavigationModel::isWikiNavMessage($wgTitle)) {
			$vars['wgIsWikiNavMessage'] = true;
		}

		return true;
	}

	/**
	 * Clear the navigation service cache every time a message is edited
	 *
	 * @param string $title name of the page changed.
	 * @param string $text new contents of the page
	 * @return bool return true
	 */
	public static function onMessageCacheReplace($title, $text) {
		if ( NavigationModel::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			$model = new NavigationModel();

			$model->clearMemc( $title );

			wfDebug(__METHOD__ . ": '{$title}' cache cleared\n");
		}

		return true;
	}
}
