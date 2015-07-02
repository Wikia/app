<?php

class TemplateClassificationController extends WikiaController {

	var $title;

	static $templateTypes = array(
		'infobox',
		'quote',
		'navbox',
		/** more to come **/
	);

	/**
	 * Flags indicating type of the template
	 */
	const TEMPLATE_GENERAL = 1;
	const TEMPLATE_INFOBOX = 2;

	const TEMPLATE_CLASSIFICATION_MAIN_PROP = 'tc-template-recognized-type'; // prop stores positive match for easy retrieval
	const TEMPLATE_CLASSIFICATION_DATA_PREFIX = 'tc-data-'; // prop stores positive or negative match

	/**
	 * Flags indicating who's taking a classification action
	 */
	const CLASSIFICATION_ACTOR_AI = 0;
	const CLASSIFICATION_ACTOR_HUMAN = 1;

	public function __construct( Title $templateTitle ) {
		$this->title = $templateTitle;
	}

	public function getType() {
		return Wikia::getProps( $title->getArticleId(), self::TEMPLATE_CLASSIFICATION_MAIN_PROP );
	}

	/*
	 * this function is preferred for making simple verifications
	 */
	public function isType( $type ) {
		if ( !$this->getClassificationProp( $type ) ) {
			// invalid type
			return false;
		}

		return $this->getType() == $type;
	}

	private function getClassificationProp( $type ) {
		if ( array_search( $type, $this->templateTypes, true ) ) {
			return self::TEMPLATE_CLASSIFICATION_DATA_PREFIX . $type;
		}
		
		// invalid type!
		return false;
	}

	public function classifyTemplate( $type, $value, $actor = self::CLASSIFICATION_ACTOR_HUMAN ) {
		$prop = self::getClassificationProp( $type );
		if ( !$prop ) {
			// unrecognized property, quit early
			return false;
		}

		// @TODO check permissions here

		if ( $value ) {
			// Huzzah! Template positively identified! Store in main property for easy retrieval
			Wikia::setProps( $title->getArticleId(), array( self::TEMPLATE_CLASSIFICATION_MAIN_PROP => $type ) );
		}

		$data = array(
			'value' => (bool) $value,
			'actor' => $actor,
			'actor-id' => $this->wg->User->getId(),
			'timestamp' => wfTimestamp(),
		);

		Wikia::setProps( $title->getArticleId(), array( $prop => json_encode( $data ) ) );
	}
}
