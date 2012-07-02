<?php

/**
 * API module to get special translations stored by the Live Translate extension.
 *
 * @since 0.4
 *
 * @file ApiImportTranslationMemories.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiImportTranslationMemories extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'managetms' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		$params = $this->extractRequestParams();
		
		// In MW 1.17 and above ApiBase::PARAM_REQUIRED can be used, this is for b/c with 1.16.
		foreach ( array( 'source' ) as $requiredParam ) {
			if ( !isset( $params[$requiredParam] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $requiredParam ) );
			}			
		}

		foreach ( $params['source'] as $location ) {
			$text = false;
			
			$dbr = wfGetDB( DB_SLAVE );
			
			$res = $dbr->select(
				'live_translate_memories',
				array( 'memory_id', 'memory_local', 'memory_type' ),
				array( 'memory_location' => $location ),
				__METHOD__,
				array( 'LIMIT' => '1' )
			);			
			
			foreach ( $res as $tm ) {
				if ( $tm->memory_local != '0' ) {
					// Obtain the contents of the article.
					$title = Title::newFromText( $location, NS_MAIN );
					
					if ( is_object( $title ) && $title->exists() ) {
						$article = new Article( $title );
						$text = $article->getContent();
					}				
				}
				else {
					// Make an HTTP request to get the file contents. False is returned on failiure.
					$text = Http::get( $location );
				}
				
				if ( $text !== false ) {
					// If the text was obtained, parse it to a translation memory and import it into the db.
					$parser = LTTMParser::newFromType( $tm->memory_type );
					$this->doTMImport( $parser->parse( $text ), $tm->memory_id );
				}				
				
				break;
			}
		}
	}
	
	/**
	 * Imports a translation memory into the database.
	 * 
	 * @since 0.4
	 * 
	 * @param LTTranslationMemory $tm
	 * @param integer $memoryId
	 */
	protected function doTMImport( LTTranslationMemory $tm, $memoryId ) {
		$dbw = wfGetDB( DB_MASTER );

		// Delete the memory from the db if already there.
		$dbw->delete(
			'live_translate',
			array( 'memory_id' => $memoryId )
		);

		$idOffset = ( $memoryId - 1 ) * 100000;
		$wordId = 0;
		
		$dbw->begin();
		
		// Insert the memory in the db.
		foreach ( $tm->getTranslationUnits() as $tu ) {
			if ( $GLOBALS['egLTRequireSignificance'] && !$tu->isSignificant() ) {
				continue;
			}
			
			foreach ( $tu->getVariants() as $language => $translations ) {
				$primary = 1;
				
				foreach ( $translations as $translation ) {
					$dbw->insert(
						'live_translate',
						array(
							'word_id' => $idOffset + $wordId,
							'word_language' => $this->cleanLanguage( $language ),
							'word_translation' => $translation,
							'word_primary' => $primary,
							'memory_id' => $memoryId
						)
					);

					$primary = 0;
				}
			}
			
			$wordId++;
			
			if ( $wordId % 500 == 0 ) {
				$dbw->commit();
				$dbw->begin();
			}
		}
		
		$dbw->update(
			'live_translate_memories',
			array(
				'memory_lang_count' => $tm->getLanguageAmount(),
				'memory_tu_count' => $wordId,
				'memory_version_hash' => uniqid(),
			),
			array( 'memory_id' => $memoryId )
		);

		$dbw->commit();
	}
	
	/**
	 * Cleans the language code.
	 * 
	 * @since 0.4
	 * 
	 * @param string language
	 * 
	 * @return string
	 */
	protected function cleanLanguage( $language ) {
		$language = strtolower( $language );
		$mappings = LiveTranslateFunctions::getInputLangMapping();
		
		if ( array_key_exists( $language, $mappings ) ) {
			$language = $mappings[$language];
		}
		
		return $language;
	}

	public function getAllowedParams() {
		return array(
			'source' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				//ApiBase::PARAM_REQUIRED => true,
			),
		);
	}
	
	public function getParamDescription() {
		return array(
			'source' => 'Location of the translation memory. Multiple sources can be provided using the | delimiter.',
		);
	}
	
	public function getDescription() {
		return array(
			'Imports one or more translation memories.'
		);
	}
		
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'source' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=importtms&source=http://localhost/tmx.xml',
			'api.php?action=importtms&source=http://localhost/tmx.xml|http://localhost/google.csv|Live Translate Dictionary',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiImportTranslationMemories.php 93663 2011-08-01 22:01:41Z jeroendedauw $';
	}		
	
}