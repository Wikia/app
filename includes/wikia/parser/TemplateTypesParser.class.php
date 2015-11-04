<?php

class TemplateTypesParser {
	/**
	 * @desc removes navbox template text from parser output
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 * @return bool
	 */
	public static function onFetchTemplateAndTitle( &$text, &$finalTitle ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson, $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( $wgArticleAsJson && $wgEnableTemplateTypesParsing ) {
			$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )->getTemplateTypeFromTitle(
				$wgCityId, $finalTitle );

			$text = $type === TemplateClassificationService::TEMPLATE_NAVBOX ? '' : $text;
		}

		wfProfileOut( __METHOD__ );

		return true;
	}
}
