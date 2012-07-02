<?php

/**
 * API module to get special translations stored by the Live Translate extension.
 *
 * @since 0.1
 *
 * @file ApiLiveTranslate.php
 * @ingroup LiveTranslate
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiLiveTranslate extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		$params = $this->extractRequestParams();
		
		// In MW 1.17 and above ApiBase::PARAM_REQUIRED can be used, this is for b/c with 1.16.
		foreach ( array( 'from', 'to', 'words' ) as $requiredParam ) {
			if ( !isset( $params[$requiredParam] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $requiredParam ) );
			}			
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		
		foreach ( array_unique( $params['words'] ) as $word ) {
			$source = $dbr->selectRow(
				'live_translate',
				array( 'word_id' ),
				array(
					'word_language' => $params['from'],
					'word_translation' => $word
				)
			);
			
			$toggledWord = false;
			
			if ( !$source ) {
				$toggledWord = LiveTranslateFunctions::getToggledCase( $word );
				
				if ( $toggledWord ) {
					$source = $dbr->selectRow(
						'live_translate',
						array( 'word_id' ),
						array(
							'word_language' => $params['from'],
							'word_translation' => $toggledWord
						)
					);					
				}
			}
			
			if ( $source ) {
				$destination = $dbr->selectRow(
					'live_translate',
					array( 'word_translation' ),
					array(
						'word_language' => $params['to'],
						'word_id' => $source->word_id,
						'word_primary' => 1
					)
				);

				if ( $destination ) {
					if ( $toggledWord ) {
						$translation = LiveTranslateFunctions::getToggledCase( $destination->word_translation );
						
						if ( $translation ) {
							$destination->word_translation = $translation;
						}
					}

					$this->getResult()->addValue(
						'translations',
						$word,
						$destination->word_translation
					);						
				}
			}
		}
	}

	public function getAllowedParams() {
		return array(
			'from' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'to' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'words' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				//ApiBase::PARAM_REQUIRED => true,
			),
		);
	}
	
	public function getParamDescription() {
		return array(
			'from' => 'Source language',
			'to' => 'Destination language',
			'words' => 'The words to translate. Delimitered by |',
		);
	}
	
	public function getDescription() {
		return array(
			'Returns the available translations of the provided words in the source language in the destiniation language.'
		);
	}
		
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'from' ),
			array( 'missingparam', 'to' ),
			array( 'missingparam', 'words' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=livetranslate&from=English&to=Dutch&words=In|Your|Example',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiLiveTranslate.php 80360 2011-01-15 00:01:29Z jeroendedauw $';
	}		
	
}
