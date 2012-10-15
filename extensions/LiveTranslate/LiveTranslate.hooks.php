<?php

/**
 * Static class for hooks handled by the Live Translate extension.
 *
 * @since 0.1
 *
 * @file LiveTranslate.hooks.php
 * @ingroup LiveTranslate
 *
 * @author Jeroen De Dauw
 */
final class LiveTranslateHooks {

	/**
	 * Hook to insert things into article headers.
	 *
	 * @since 0.1
	 *
	 * @param Article &$article
	 * @param boolean $outputDone
	 * @param boolean $useParserCache
	 *
	 * @return true
	 */
	public static function onArticleViewHeader( Article &$article, &$outputDone, &$useParserCache ) {
		global $egLiveTranslateLanguages;
		$egLiveTranslateLanguages = array_unique( $egLiveTranslateLanguages );
		
		$title = $article->getTitle();

		$currentLang = LiveTranslateFunctions::getCurrentLang( $title );

		if ( in_array( $title->getFullText(), LiveTranslateFunctions::getLocalMemoryNames() ) ) {
			self::displayDictionaryPage( $article, $title );
			$outputDone = true; // The translations themselves should not be shown.
		}
		elseif (
			LiveTranslateFunctions::hasTranslationService()
			&& $article->exists()
			&& ( count( $egLiveTranslateLanguages ) > 1 || ( count( $egLiveTranslateLanguages ) == 1 && $egLiveTranslateLanguages[0] != $currentLang ) ) ) {

			global $wgParser;
			$po = $wgParser->getOutput();
			$magicWords = isset( $po->mLTMagicWords ) ? $po->mLTMagicWords : array();

			if ( !in_array( 'LT_NOTRANSLATIONCONTROL', $magicWords ) ) {
				global $egLTNSWithTranslationControl, $egLTUnknownNSShowControl;
				$ns =  $title->getNamespace();

				if ( in_array( 'LT_SHOWTRANSLATIONCONTROL', $magicWords )
					||	( array_key_exists( $ns, $egLTNSWithTranslationControl ) && $egLTNSWithTranslationControl[$ns] )
					|| ( !array_key_exists( $ns, $egLTNSWithTranslationControl ) && $egLTUnknownNSShowControl )
				 ) {
					self::displayTranslationControl( $currentLang );
				}
			}
		}

		return true;
	}

	/**
	 * Displays some shorts statistics about the dictionary page.
	 *
	 * @since 0.4
	 *
	 * @param Article $article
	 * @param Title $title
	 */
	protected static function displayDictionaryPage( Article &$article, Title $title ) {
		global $wgOut, $wgLang, $wgUser, $egLiveTranslateLanguages;

		$dbr = wfGetDb( DB_SLAVE );

		$res = $dbr->select(
			'live_translate_memories',
			array(
				'memory_lang_count',
				'memory_tu_count'
			),
			array( 'memory_location' => $title->getFullText() ),
			array( 'LIMIT' => 1 )
		);

		foreach ( $res as $tm ) {
			break;
		}

		if ( $tm->memory_tu_count == 0 ) {
			$wgOut->addWikiMsg( 'livetranslate-dictionary-empty' );
		}
		else {
			$wgOut->addWikiMsg(
				'livetranslate-dictionary-count',
				$wgLang->formatNum( $tm->memory_tu_count ) ,
				$wgLang->formatNum( $tm->memory_lang_count )
			);

			/*
			$notAllowedLanguages = array();

			foreach ( $tus[0]->getVariants() as $languageCode => $translations ) {
				$languageCode = strtolower( $languageCode );
				$mappings = LiveTranslateFunctions::getInputLangMapping();

				if ( array_key_exists( $languageCode, $mappings ) ) {
					$languageCode = $mappings[$languageCode];
				}

				if ( !in_array( $languageCode, $egLiveTranslateLanguages ) ) {
					$notAllowedLanguages[] = $languageCode;
				}
			}

			if ( count( $notAllowedLanguages ) > 0 ) {
				$languages = Language::getLanguageNames( false );

				foreach ( $notAllowedLanguages as &$notAllowedLang ) {
					if ( array_key_exists( $notAllowedLang, $languages ) ) {
						$notAllowedLang = $languages[$notAllowedLang];
					}
				}

				$wgOut->addHTML(
					Html::element(
						'span',
						array( 'style' => 'color:darkred' ),
						wfMsgExt( 'livetranslate-dictionary-unallowed-langs', 'parsemag', $wgLang->listToText( $notAllowedLanguages ), count( $notAllowedLanguages ) )
					)
				);
			}
			*/
		}

		if ( $wgUser->isAllowed( 'managetms' ) ) {
			$wgOut->addHTML(
				Html::element(
					'a',
					array( 'href' => Title::newFromText( 'Special:LiveTranslate' )->getInternalURL() ),
					wfMsg( 'livetranslate-dictionary-goto-edit' )
				)
			);
		}
	}

	/**
	 * Outputs the Live Translate translation control.
	 *
	 * @since 0.4
	 *
	 * @param string $currentLang
	 */
	protected static function displayTranslationControl( $currentLang ) {
		global $wgOut;

		$langs = array();
		
		foreach ( LiveTranslateFunctions::getLanguages( $currentLang ) as $label => $code ) {
			$langs[] = "$code|$label";
		}

		$wgOut->addHTML(
			Html::rawElement(
				'div',
				array(
					'id' => 'livetranslatediv',
					'sourcelang' => $currentLang,
					'languages' => implode( '||', $langs )
				)
			)
		);

		LiveTranslateFunctions::loadJs();
	}

	/**
	 * Schema update to set up the needed database tables.
	 *
	 * @since 0.1
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onSchemaUpdate( /* DatabaseUpdater */ $updater = null ) {
		global $wgDBtype, $egLiveTranslateIP;

		if ( $wgDBtype == 'mysql' ) {
			// Set up the current schema.
			if ( $updater === null ) {
				global $wgExtNewTables, $wgExtNewIndexes, $wgExtNewFields;

				$wgExtNewTables[] = array(
					'live_translate',
					$egLiveTranslateIP . '/LiveTranslate.sql',
					true
				);
				$wgExtNewTables[] = array(
					'live_translate_memories',
					$egLiveTranslateIP . '/LiveTranslate.sql',
					true
				);

				$wgExtNewIndexes[] = array(
					'live_translate',
					'word_translation',
					$egLiveTranslateIP . '/sql/LT_IndexWordTranslation.sql',
					true
				);

				$wgExtNewFields[] = array(
					'live_translate',
					'memory_id',
					$egLiveTranslateIP . '/sql/LT_addTMField.sql'
				);
				
				$wgExtNewFields[] = array(
					'live_translate_memories',
					'memory_version_hash',
					$egLiveTranslateIP . '/sql/LT_addTMHashField.sql'
				);
			}
			else {
				$updater->addExtensionUpdate( array(
					'addTable',
					'live_translate',
					$egLiveTranslateIP . '/LiveTranslate.sql',
					true
				) );
				$updater->addExtensionUpdate( array(
					'addTable',
					'live_translate_memories',
					$egLiveTranslateIP . '/LiveTranslate.sql',
					true
				) );

				$updater->addExtensionUpdate( array(
					'addIndex',
					'live_translate',
					'word_translation',
					$egLiveTranslateIP . '/sql/LT_IndexWordTranslation.sql',
					true
				) );

				$updater->addExtensionUpdate( array(
					'addField',
					'live_translate',
					'memory_id',
					$egLiveTranslateIP . '/sql/LT_addTMField.sql',
					true
				) );
				
				$updater->addExtensionUpdate( array(
					'addField',
					'live_translate_memories',
					'memory_version_hash',
					$egLiveTranslateIP . '/sql/LT_addTMHashField.sql',
					true
				) );
			}
		}

		return true;
	}

	/**
	 * Handles edits to the dictionary page to save the translations into the db.
	 *
	 * @since 0.1
	 *
	 * @return true
	 */
	public static function onArticleSaveComplete( &$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect = null ) {

		$title = $article->getTitle();

		// FIXME: Hitting the db on every page save should be avoided
		if ( in_array( $title->getFullText(), LiveTranslateFunctions::getLocalMemoryNames() ) ) {
			$requestData = array(
				'action' => 'importtms',
				'format' => 'json',
				'source' => $title->getFullText(),
				'type' => LiveTranslateFunctions::getMemoryType( $title->getFullText() ),
				'local' => 1
			);

			$api = new ApiMain( new FauxRequest( $requestData, true ), true );
			$api->execute();
			$response = $api->getResultData();
		}

		return true;
	}

	/**
	 * Strips the magic words added by Live Translate from the page text.
	 *
	 * @since 0.6
	 *
	 * @param Parser &$parser
	 * @param string &$text
	 *
	 * @return true
	 */
	public static function stripMagicWords( Parser &$parser, &$text  ) {
		global $egLiveTranslateMagicWords;

		$mw = MagicWord::get( 'LT_NOTRANSLATIONCONTROL' );
		if ( $mw->matchAndRemove( $text ) ) {
			$egLiveTranslateMagicWords[] = 'LT_NOTRANSLATIONCONTROL';
		}

		$mw = MagicWord::get( 'LT_SHOWTRANSLATIONCONTROL' );
		if ( $mw->matchAndRemove( $text ) ) {
			$egLiveTranslateMagicWords[] = 'LT_SHOWTRANSLATIONCONTROL';
		}

		$po = $parser->getOutput();
		$po->mLTMagicWords = $egLiveTranslateMagicWords;

		return true;
	}

	public static function onOutputPageParserOutput( $outputpage, $parseroutput ) {
		$magicWords = isset( $parseroutput->mLTMagicWords ) ? $parseroutput->mLTMagicWords : array();
		return true;
	}

}
