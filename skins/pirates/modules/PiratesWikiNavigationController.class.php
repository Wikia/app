<?php

class PiratesWikiNavigationController extends WikiaController {

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
	 * Render the preview of wiki navigation menu
	 *
	 * @param Title $title Title of the page preview is generated for
	 * @param string $html preview content to modify
	 * @param string $html current wikitext from the editor
	 * @return bool return true
	 */
	public static function onEditPageLayoutModifyPreview(Title $title, &$html, $wikitext) {
		if (self::isWikiNavMessage($title)) {
			// render a preview
			$html = F::app()->renderView('WikiNavigation', 'Index', array(
				'msgName' => $title->getText(),
				'wikitext' => $wikitext,
			));

			// open links in new tab
			$html = str_replace('<a ', '<a target="_blank" ', $html);

			// wrap it inside header wrapper and run JS to make the preview interactive
			$html = <<<HEADER
				<header id="WikiHeader" class="WikiHeader WikiHeaderPreview">
					<nav>
					$html
					</nav>
				</header>
HEADER;
		}

		return true;
	}

	/**
	 * Add global JS variable indicating that we're editing wiki nav message
	 *
	 * @param Array $vars list of global JS variables
	 * @return bool return true
	 */
	public static function onEditPageMakeGlobalVariablesScript(Array &$vars) {
		global $wgTitle;

		if (self::isWikiNavMessage($wgTitle)) {
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
		if ( self::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			$model = new NavigationModel();

			$model->clearMemc( $title );

			wfDebug(__METHOD__ . ": '{$title}' cache cleared\n");
		}

		return true;
	}

	/**
	 * Clear local wikinav cache when local version of global menu
	 * is modified using WikiFactory
	 *
	 * @param string $cv_name WF variable name
	 * @param int $city_id wiki ID
	 * @param mixed $value new variable value
	 * @return bool return true
	 */
	public static function onWikiFactoryChanged($cv_name , $city_id, $value) {
		if ( $cv_name == NavigationModel::WIKIA_GLOBAL_VARIABLE ) {
			$model = new NavigationModel();

			$model->clearMemc(
				NavigationModel::WIKIA_GLOBAL_VARIABLE,
				$city_id
			);

			wfDebug(__METHOD__ . ": purging the cache for wiki #{$city_id}\n");
		}

		return true;
	}

	/**
	 * Check if given title refers to wiki nav messages
	 */
	private static function isWikiNavMessage(Title $title) {
		return ($title->getNamespace() == NS_MEDIAWIKI) && ($title->getText() == NavigationModel::WIKI_LOCAL_MESSAGE);
	}
}
