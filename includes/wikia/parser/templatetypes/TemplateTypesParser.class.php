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

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson ) {
			$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
					->getTemplateTypeFromTitle( $wgCityId, $finalTitle );

			switch ( $type ) {
				case AutomaticTemplateTypes::TEMPLATE_NAVBOX:
				case TemplateClassificationService::TEMPLATE_NAVBOX:
					$text = self::handleNavboxTemplate();
					break;
				case AutomaticTemplateTypes::TEMPLATE_REFERENCES:
				case TemplateClassificationService::TEMPLATE_REF:
					$text = self::handleReferencesTemplate();
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

    public static function onArgSubstitution( &$text, $templateId, $numArgs, $namedArgs) {
        global $wgEnableTemplateTypesParsing, $wgArticleAsJson, $wgCityId;
        wfProfileIn( __METHOD__ );

        if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson ) {
            $type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
                ->getTemplateType( $wgCityId, $templateId );
            switch ( $type ) {
                case 'scrollbox':
                    $text = self::handleScrollboxTemplate(array_merge($numArgs, $namedArgs));
                    break;
            }
        }
        wfProfileOut( __METHOD__ );
        return true;
    }

	/**
	 * @desc return skip rendering navbox template
	 *
	 * @return string
	 */
	private static function handleNavboxTemplate() {
		return '';
	}

	/**
	 * @desc return simple <references /> parser tag
	 *
	 * @return string
	 */
	private static function handleReferencesTemplate() {
		return '<references />';
	}

    private static function handleScrollboxTemplate($templateArgs) {
        $lengths = array_map('strlen', $templateArgs);
        $maxLength = max($lengths);
        $index = array_search($maxLength, $lengths);
        return $templateArgs[$index];
    }

}
