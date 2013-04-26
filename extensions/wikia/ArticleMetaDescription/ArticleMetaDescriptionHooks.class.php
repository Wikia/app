<?php

class ArticleMetaDescriptionHooks {
	/**
	 * @param OutputPage $out
	 * @param string $text
	 * @return bool
	 */
	function onOutputPageBeforeHTML(&$out, &$text) {
		global $wgTitle, $wgPPSEOCustomKeywords, $wgPPSEOCustomDescriptions;
		wfProfileIn( __METHOD__ );

		$pagename = $out->getTitle()->getPrefixedText();

		if ( !empty( $wgPPSEOCustomKeywords[$pagename] ) ) {
			$out->addKeyword( $wgPPSEOCustomKeywords[$pagename] );
		}

		$description = null;
		if ( !empty( $wgPPSEOCustomDescriptions[$pagename] ) ) $description = $wgPPSEOCustomDescriptions[$pagename];
		if( $description == null ) $description = ArticleMetaDescriptionHelpers::descriptionFromMessage( $wgTitle );
		if( $description == null ) $description = ArticleMetaDescriptionHelpers::descriptionFromSnippet( $wgTitle );

		if( !empty($description) ) {
			$out->addMeta('description', htmlspecialchars($description));
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
