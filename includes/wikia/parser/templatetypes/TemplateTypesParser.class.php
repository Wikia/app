<?php

class TemplateTypesParser {
	/**
	 * @desc alters template raw text for mercury parser output based on template type
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

	/**
	 * @desc alters template parser output based on its arguments and template type
	 *
	 * @param array $piece
	 * @param PPFrame_DOM $frame
	 * @param string $outputText
	 * @return bool
	 */
	public static function onStartBraceSubstitution( $piece, $frame, &$outputText ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson, $wgCityId;
		wfProfileIn( __METHOD__ );

		$title = Title::newFromText( $frame->expand( $piece['title'] ), NS_TEMPLATE );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson && $title ) {
			$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
				->getTemplateType( $wgCityId, $title->getArticleID() );

			if ( $type === AutomaticTemplateTypes::TEMPLATE_SCROLBOX ) {
				$outputText = trim( self::getTemplateArgsLongestVal( self::getTemplateArgs( $piece, $frame ) ) );
				return false;
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

	/**
	 * @desc gets array of template arguments values
	 *
	 * @param array $piece
	 * @param PPFrame_DOM $frame
	 * @return array
	 */
	private static function getTemplateArgs( $piece, $frame ) {
		$templateArgs = [];

		for ($i = 0; $i < count( $piece['parts'] ); $i++ ) {
			$bits = $piece['parts']->item( $i )->splitArg();
			$templateArgs[] = $frame->expand( $bits['value'] );
		}

		return $templateArgs;
	}

	/**
	 * @desc gets the longest value from template arguments
	 *
	 * @param array $templateArgs
	 * @return string
	 */
	private static function getTemplateArgsLongestVal( $templateArgs ) {
		$lengths = array_map( 'strlen', $templateArgs );
		$maxLength = max($lengths);
		$index = array_search( $maxLength, $lengths );

		return $templateArgs[$index];
	}

}
