<?php

class WikiNavigationController extends WikiaController {

	private $service;

	public function executeIndex($data) {
		global $wgCityId, $wgUser, $wgIsPrivateWiki;

		//fb#1090
		$isInternalWiki = empty($wgCityId);
		$this->showMenu = !(($isInternalWiki || $wgIsPrivateWiki) && $wgUser->isAnon());

		$this->service = new WikiNavigationService();

		// handle requests from preview mode
		$request = $this->getRequest();
		$this->previewMessage = $request->getVal('msgName', false);
		$this->previewWikitext = $request->getVal('wikitext');

		// render global wikia navigation ("On the Wiki" menu)
		$this->wikiaMenuNodes =
			$this->parseMenu(
				WikiNavigationService::WIKIA_GLOBAL_VARIABLE,
				array(
					1,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				),
				true
			);

		$nodesCount = 0;
		foreach( $this->wikiaMenuNodes as $node ){
			if ( isset( $node['depth'] ) && ( $node['depth'] == 2 ) ){
				$nodesCount++;
			}
		}

		// render local navigation (more tabs)
		$this->wikiMenuNodes = ( $this->wg->User->isAllowed( 'read' ) ? // Only show menu items if user is allowed to view wiki content (BugId:44632)
			$this->parseMenu(
				WikiNavigationService::WIKI_LOCAL_MESSAGE,
				array(
					$this->wg->maxLevelOneNavElements,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				)
			) : array() );

		// report wiki nav parse errors (BugId:15240)
		$this->parseErrors = $this->service->getErrors();
	}

	/**
	 * Parse given menu
	 *
	 * Use either MediaWiki message / WikiFactory variable or wikitext from preview mode
	 *
	 * @param string $menuName name of the message / variable to be used
	 * @param array $maxChildrenAtLevel maximum nesting information
	 * @param bool $filterInactiveSpecialPages filter inactive special pages?
	 * @return array menu nodes
	 */
	private function parseMenu($menuName, Array $maxChildrenAtLevel, $filterInactiveSpecialPages = false) {
		wfProfileIn(__METHOD__);

		$inPreviewMode = ($this->previewMessage === $menuName);

		if ($inPreviewMode) {
			// get menu content from the wikitext (preview mode)
			$nodes = $this->service->parseText(
				$this->previewWikitext,
				$maxChildrenAtLevel,
				true /* $forContent */,
				$filterInactiveSpecialPages
			);
		} else {
			$nodes = $this->service->parseMenu( $menuName, $maxChildrenAtLevel, $filterInactiveSpecialPages );
		}

		wfProfileOut(__METHOD__);
		return $nodes;
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
	 * Clear the navigation service cache every time a message in edited
	 *
	 * @param string $title name of the page changed.
	 * @param string $text new contents of the page
	 * @return bool return true
	 */
	public static function onMessageCacheReplace($title, $text) {
		global $wgMemc;

		if (self::isWikiNavMessage(Title::newFromText($title, NS_MEDIAWIKI))) {
			$service = new NavigationService();

			$memcKey = $service->getMemcKey($title);
			$wgMemc->delete($memcKey);

			wfDebug(__METHOD__ . ": '{$memcKey}' cache cleared\n");
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
		global $wgMemc;

		if ($cv_name == WikiNavigationService::WIKIA_GLOBAL_VARIABLE) {
			$service = new NavigationService();
			$memcKey = $service->getMemcKey(WikiNavigationService::WIKIA_GLOBAL_VARIABLE, $city_id);

			wfDebug(__METHOD__ . ": purging the cache for wiki #{$city_id}\n");

			$wgMemc->delete($memcKey);
		}

		return true;
	}

	/**
	 * Check if given title refers to wiki nav messages
	 */
	private static function isWikiNavMessage(Title $title) {
		return ($title->getNamespace() == NS_MEDIAWIKI) && ($title->getText() == WikiNavigationService::WIKI_LOCAL_MESSAGE);
	}
}
