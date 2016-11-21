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
	 * Render the preview of wiki navigation menu
	 *
	 * @param Title $title Title of the page preview is generated for
	 * @param string $html preview content to modify
	 * @param string $html current wikitext from the editor
	 * @return bool return true
	 */
	public static function onEditPageLayoutModifyPreview(Title $title, &$html, $wikitext) {
		if (NavigationModel::isWikiNavMessage($title)) {
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

	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		$title = $article->getTitle();
		if (NavigationModel::isWikiNavMessage($title)) {
			global $wgCityId;

			$localNav = (new NavigationModel())->getWiki(NavigationModel::WIKI_LOCAL_MESSAGE, $text);

			(new SiteAttributeService())
				->getAuthenticatedInternalApiClient()
				->internallySaveAttribute($wgCityId, 'localNavigation', null, $localNav['wiki']);

			return true;
		}
	}
}
