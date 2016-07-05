<?php

class TemplateTypesParser {
	private static $cachedTemplateTitles = [ ];

	/**
	 * @desc alters template raw text parser output based on template type
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 *
	 * @return bool
	 */
	public static function onFetchTemplateAndTitle( &$text, &$finalTitle ) {
		global $wgEnableReferencesTemplateParsing,
			   $wgEnableNavboxTemplateParsing,
			   $wgEnableNoticeTemplateParsing,
			   $wgEnableNavigationTemplateParsing;

		wfProfileIn( __METHOD__ );

		if ( self::shouldTemplateBeParsed() ) {
			$type = self::getTemplateType( $finalTitle );

			switch ( $type ) {
				case TemplateClassificationService::TEMPLATE_NAVBOX:
					if ( $wgEnableNavboxTemplateParsing ) {
						$text = NavboxTemplate::handle();
					}
					break;
				case TemplateClassificationService::TEMPLATE_FLAG:
					if ( $wgEnableNoticeTemplateParsing ) {
						$text = NoticeTemplate::handle();
					}
					break;
				case TemplateClassificationService::TEMPLATE_REFERENCES:
					if ( $wgEnableReferencesTemplateParsing ) {
						$text = ReferencesTemplate::handle( $text );
					}
					break;
				case TemplateClassificationService::TEMPLATE_NAV:
					if ( $wgEnableNavigationTemplateParsing ) {
						$text = NavigationTemplate::handle( $text );
					}
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}


	/**
	 * @desc run resolve methods after whole article was parsed
	 *
	 * @param $parser
	 * @param $html
	 * @return bool
	 */
	public static function onParserAfterTidy( $parser, &$html ) {
		global $wgEnableNavigationTemplateParsing;
		wfProfileIn( __METHOD__ );

		if ( self::shouldTemplateBeParsed() ) {
			if ( $wgEnableNavigationTemplateParsing ) {
				NavigationTemplate::resolve( $html );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc alters template parser output based on its arguments and template type
	 *
	 * @param Title $title
	 * @param PPNode_DOM $args
	 * @param PPFrame_DOM $frame
	 * @param string $outputText
	 *
	 * @return bool
	 */
	public static function onGetTemplateDom( $title, $args, $frame, &$outputText ) {
		global $wgEnableScrollboxTemplateParsing, $wgEnableQuoteTemplateParsing;
		wfProfileIn( __METHOD__ );

		if ( self::shouldTemplateBeParsed() && !is_null( $args ) ) {
			$type = self::getTemplateType( $title );

			if ( $type === TemplateClassificationService::TEMPLATE_SCROLLBOX && $wgEnableScrollboxTemplateParsing ) {
				$templateArgs = TemplateArgsHelper::getTemplateArgs( $args, $frame );
				$outputText = ScrollboxTemplate::getLongestElement( $templateArgs );
			}

			if ( $type === TemplateClassificationService::TEMPLATE_QUOTE && $wgEnableQuoteTemplateParsing ) {
				$templateArgs = TemplateArgsHelper::getTemplateArgs( $args, $frame );
				$outputText = QuoteTemplate::execute( $templateArgs );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc change template wikitext according to template type
	 *
	 * @param string $templateTitle
	 * @param string $templateWikitext
	 *
	 * @return bool
	 */
	public static function onEndBraceSubstitution( $templateTitle, &$templateWikitext, &$parser ) {
		global $wgEnableContextLinkTemplateParsing, $wgEnableInfoIconTemplateParsing, $wgEnableNavigationTemplateParsing;
		wfProfileIn( __METHOD__ );

		if ( self::isSuitableForProcessing( $templateWikitext ) &&
			 ( $wgEnableContextLinkTemplateParsing ||
			   $wgEnableInfoIconTemplateParsing ||
			   $wgEnableNavigationTemplateParsing )
		) {
			$title = self::getValidTemplateTitle( $templateTitle );

			if ( $title ) {
				$type = self::getTemplateType( $title );
				if ( $wgEnableContextLinkTemplateParsing && $type == TemplateClassificationService::TEMPLATE_CONTEXT_LINK ) {
					$templateWikitext = ContextLinkTemplate::handle( $templateWikitext );
				} elseif ( $wgEnableInfoIconTemplateParsing && $type == TemplateClassificationService::TEMPLATE_INFOICON ) {
					$templateWikitext = InfoIconTemplate::handle( $templateWikitext, $parser );
				} else {
					if ( $wgEnableNavigationTemplateParsing && $type == TemplateClassificationService::TEMPLATE_NAV ) {
						$templateWikitext = NavigationTemplate::removeInnerMarks( $templateWikitext );
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc return template type for a given template title object
	 *
	 * @param Title $title
	 *
	 * @return string
	 */
	private static function getTemplateType( $title ) {
		global $wgCityId;

		$type = ExternalTemplateTypesProvider::getInstance()
			->setTCS( new \TemplateClassificationService )
			->getTemplateTypeFromTitle( $wgCityId, $title );

		return $type;
	}

	/**
	 * @desc checks if template can be parsed
	 *
	 * @return bool
	 */
	private static function shouldTemplateBeParsed() {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		return $wgEnableTemplateTypesParsing && $wgArticleAsJson;
	}

	/**
	 * @desc check if template content is worth processing
	 *
	 * @param $wikitext
	 * @return bool
	 */
	private static function isSuitableForProcessing( $wikitext ) {
		return self::shouldTemplateBeParsed()
			   && !empty( $wikitext )
			   && !TemplateArgsHelper::containsUnexpandedArgs( $wikitext );
	}

	/**
	 * @desc return a valid cached Title object for a given template title string
	 * or if not in cache yet check it's correctness and save there valid Title
	 * object or false if templateTitle invalid
	 *
	 * @param string $templateTitle
	 *
	 * @return Title | bool
	 * @throws \MWException
	 */
	private static function getValidTemplateTitle( $templateTitle ) {
		if ( !isset( self::$cachedTemplateTitles[ $templateTitle ] ) ) {
			$title = Title::newFromText( $templateTitle, NS_TEMPLATE );
			self::$cachedTemplateTitles[ $templateTitle ] = ( $title && $title->exists() ) ? $title : false;
		}

		return self::$cachedTemplateTitles[ $templateTitle ];
	}
}
