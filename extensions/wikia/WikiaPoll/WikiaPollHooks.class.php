<?php

class WikiaPollHooks {

	private static $pollMarkers = array();

	/**
	 * Use WikiaPollArticle class to render Poll namespace pages
	 */
	public static function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);

		if ($title->getNamespace() == NS_WIKIA_POLL) {
			$article = new WikiaPollArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 *  Override the edit button behavior in the menu for Poll pages
	 *  only allow the Poll creator or an admin to edit
	 */
	 public static function onMenuButtonAfterExecute (&$moduleObject, &$params) {
		global $wgTitle, $wgUser;

		if( $wgTitle->getNamespace() == NS_WIKIA_POLL ) {
			$rev = $wgTitle->getFirstRevision();
			$isAdmin = $wgUser->isAllowed('editinterface');
			if ($isAdmin || !$wgTitle->exists() || $wgUser->getId() == $rev->getRawUser()) {
				// okay to edit, do nothing
			} else {
				// remove button
				$moduleObject->action = array();
			}
		}
		return true;
	 }

	/**
	 * Override the edit button to point to the special page instead of the normal editor
	 */

	public static function onAlternateEdit( $editPage ) {
		global $wgOut;

		$title = $editPage->getArticle()->getTitle();

		if( $title->getNamespace() == NS_WIKIA_POLL ) {

			$specialPageTitle = Title::newFromText( 'CreatePoll', NS_SPECIAL );
			$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . $title->getDBkey() );
		}

		return true;
	}

	/**
	 * Return HTML to be used when embedding polls using {{Poll:foo}} wikisyntax
	 */
	public static function onFetchTemplateAndTitle(&$text, &$finalTitle) {
		global $wgParser;
		wfProfileIn(__METHOD__);

		if ($finalTitle instanceof Title) {
			if ($finalTitle->exists() && $finalTitle->getNamespace() == NS_WIKIA_POLL) {
				wfLoadExtensionMessages('WikiaPoll');

				$poll = WikiaPoll::newFromTitle($finalTitle);
				$html = $poll->renderEmbedded();

				// wrap marker inside <pre> tag - parser will close pararaphs and lists which are before poll inclusion
				$marker = '<pre>' .$wgParser->uniqPrefix() . '-WIKIA-POLL-' . $poll->getId() . '</pre>';
				self::$pollMarkers[$marker] = $html;

				// return marker instead of poll's HTML to bypass MW sanitizer
				$text = $marker;
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Replace markers added by onFetchTemplateAndTitle() method when embedding polls and load CSS / JS for polls
	 */
	public static function onParserAfterTidy(&$parser, &$text) {
		global $wgJsMimeType;
		wfProfileIn(__METHOD__);

		if (!empty(self::$pollMarkers)) {
			$text = strtr($text, self::$pollMarkers);

			// remove markers to aboid multiple CSS/JS requests
			self::$pollMarkers = array();

			// add CSS & JS
			$sassUrl = wfGetSassUrl('/extensions/wikia/WikiaPoll/css/WikiaPoll.scss');
			$css = '<link rel="stylesheet" type="text/css" href="' . htmlspecialchars($sassUrl) . ' " />';

			$js = <<<JS
<!-- Wikia Polls -->
<script type="$wgJsMimeType">
wgAfterContentAndJS.push(function() {
	$.getScript(wgExtensionsPath + '/wikia/WikiaPoll/js/WikiaPoll.js', function() {
		WikiaPoll.init();
	});
});
</script>
JS;

			// CSS at the bottom, JS at the bottom
			$text = "{$css}\n{$text}\n{$js}\n";
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Purge poll after an edit
	 */
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . "\n");

		$title = $article->getTitle();

		if (!empty($title) && $title->getNamespace() == NS_WIKIA_POLL) {
			$poll = WikiaPoll::newFromArticle($article);
			$poll->purge();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 *  transform [[Poll:name]] into {{Poll:name}} in parser before template expansion
	 */

	public static function onInternalParseBeforeLinks(&$parser, &$text, &$stripState) {
		global $wgContLang;
		$pollNamespace = $wgContLang->getNsText( NS_WIKIA_POLL );
		$newtext = preg_replace_callback( "/\[\[Poll|$pollNamespace\:([^\]]*)\]\]/", "WikiaPollHooks::parseLinkCallback", $text, -1, $count );
		if ($count > 0)
			$text = $parser->recursiveTagParse($newtext);
		return true;
	}

	/**
	 * Helper callback for onInternalParseBeforeLinks
	 */
	public static function parseLinkCallback ($link) {
		return str_replace(array("[[", "]]"), array("{{", "}}"), $link[0]);
	}

}
