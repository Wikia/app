<?php

class WikiNavigationModule extends Module {

	var $showMenu;
	var $wgBlankImgUrl;

	private $service;

	const WIKIA_GLOBAL_MESSAGE = 'Wikia-navigation-global';
	const WIKIA_LOCAL_MESSAGE = 'Wikia-navigation-local';
	const WIKI_LOCAL_MESSAGE = 'Wiki-navigation';

	const MESSAGING_WIKI_ID = 4036;

	const CACHE_TTL = 10800; // 3 hours

	public function executeIndex($data) {
		global $wgCityId, $wgUser, $wgIsPrivateWiki;

		//fb#1090
		$isInternalWiki = empty($wgCityId);
		$this->showMenu = !(($isInternalWiki || $wgIsPrivateWiki) && $wgUser->isAnon());

		$this->service = new NavigationService();

		// handle requests from preview mode
		$request = $this->getRequest();
		$this->previewMessage = $request->getVal('msgName', false);
		$this->previewWikitext = $request->getVal('wikitext');

		// render global wikia navigation
		$this->wikiaMenuNodes =
			$this->parseMenu(
				self::WIKIA_GLOBAL_MESSAGE,
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

		// render local wikia navigation
		if ( $nodesCount > 0 && $nodesCount < $this->wg->maxLevelThreeNavElements ){
			$this->wikiaMenuLocalNodes =
				$this->parseMenu(
					self::WIKIA_LOCAL_MESSAGE,
					array(
						$this->wg->maxLevelTwoNavElements - $nodesCount,
						$this->wg->maxLevelThreeNavElements,
						0
					),
					true
				);
		} else {
			$this->wikiaMenuLocalNodes = array();
		}

		// render local navigation
		$this->wikiMenuNodes =
			$this->parseMenu(
				self::WIKI_LOCAL_MESSAGE,
				array(
					$this->wg->maxLevelOneNavElements,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				)
			);
	}

	/**
	 * Parse given menu message
	 *
	 * Use either MW message or wikitext from preview mode
	 *
	 * @param string $menuName name of the message to be used
	 * @param array $maxChildrenAtLevel maximum nesting information
	 * @param bool $filterInactiveSpecialPages filter inactive special pages?
	 * @return array menu nodes
	 */
	private function parseMenu($menuName, $maxChildrenAtLevel, $filterInactiveSpecialPages = false) {
		$inPreviewMode = ($this->previewMessage === $menuName);

		if ($inPreviewMode) {
			// get menu content from the wikitext (preview mode)
			$nodes = $this->service->parseText(
				$this->previewWikitext,
				$maxChildrenAtLevel,
				$filterInactiveSpecialPages
			);
		}
		else {
			// get menu content from the message
			$nodes = $this->service->parseMessage(
				$menuName,
				$maxChildrenAtLevel,
				self::CACHE_TTL,
				true /* $forContent */,
				$filterInactiveSpecialPages
			);
		}

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
	public static function onEditPageLayoutModifyPreview(Title $title, $html, $wikitext) {
		global $wgOasisNavV2;

		if (self::isWikiNavMessage($title) && !empty($wgOasisNavV2)) {
			// render a preview
			$html = wfRenderModule('WikiNavigation', 'Index', array(
				'msgName' => $title->getText(),
				'wikitext' => $wikitext,
			));

			// open links in new tab
			$html = str_replace('<a ', '<a target="_blank" ', $html);

			// wrap it inside header wrapper and run JS to make the preview interactive
			$html = <<<HEADER
				<header id="WikiHeader" class="WikiHeaderRestyle WikiHeaderPreview">
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
	public static function onEditPageMakeGlobalVariablesScript($vars) {
		global $wgTitle;

		if (self::isWikiNavMessage($wgTitle)) {
			$vars['wgIsWikiNavMessage'] = true;
		}

		return true;
	}

	/**
	 * Check edit permission for wiki nav messages (edit, move and delete)
	 *
	 * @param Title $title page to check permission for
	 * @param User $user current user
	 * @param string $action action to be performed
	 * @param bool $result permission
	 * @return bool return true
	 */
	public static function onUserCan(Title $title, User $user, $action, &$result ) {
		if (!self::isWikiNavMessage($title) || !in_array($action, array('move', 'move-target', 'edit', 'delete'))) {
			return true;
		}

		// get the right name to edit a given wiki nav message
		// TODO: consider allowing an edit of global one only on messaging and disabling edit of local one on messaging
		switch($title->getText()) {
			case self::WIKIA_GLOBAL_MESSAGE:
				$rightName = 'wikianavglobal';
				break;

			case self::WIKIA_LOCAL_MESSAGE:
				$rightName = 'wikianavlocal';
				break;

			default:
				$rightName = 'editinterface';
				break;
		}

		return $user->isAllowed($rightName);
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
	 * Check if given title refers to one of three wiki nav messages
	 */
	private static function isWikiNavMessage(Title $title) {
		return ($title->getNamespace() == NS_MEDIAWIKI) && in_array($title->getText(), array(self::WIKIA_GLOBAL_MESSAGE, self::WIKIA_LOCAL_MESSAGE, self::WIKI_LOCAL_MESSAGE));
	}
}
