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
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, &$watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
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

	public static function parseLinkCallback ($link) {
		$str = $link[0];
		$str = str_replace(array("[[", "]]"), array("{{", "}}"), $str);
		return $str;
	}

	/**
	 *  transform [[Poll:name]] into {{Poll:name}} in parser before template expansion
	 */

	public static function onInternalParseBeforeLinks(&$parser, &$text, &$stripState) {
		global $wgContLang;
		$pollNamespace = $wgContLang->getNsText( NS_WIKIA_POLL );
		$newtext = preg_replace_callback( "/\[\[$pollNamespace\:([^\]]*)\]\]/", "WikiaPollHooks::parseLinkCallback", $text, -1, $count );
		if ($count > 0)
			$text = $parser->recursiveTagParse($newtext);
		return true;
	}
}
