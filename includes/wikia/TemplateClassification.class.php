<?php

class TemplateClassification {
	/**
	 * Flags indicating type of the template.
	 */
	const TEMPLATE_UNCLASSIFIED = 'unclassified';
	const TEMPLATE_INFOBOX = 'infobox';
	const TEMPLATE_QUOTE = 'quote';
	const TEMPLATE_NAVBOX = 'navbox';

	/**
	 * Names of the primary and secondary properties used for templates' classification.
	 */
	const TEMPLATE_CLASSIFICATION_MAIN_PROP = 'tc-template-recognized-type'; // prop stores positive match for easy retrieval
	const TEMPLATE_CLASSIFICATION_DATA_PREFIX = 'tc-data-'; // prop stores positive or negative match

	/**
	 * Flags indicating who's taking a classification action.
	 */
	const CLASSIFICATION_ACTOR_AI = 0;
	const CLASSIFICATION_ACTOR_HUMAN = 1;

	/**
	 * Allowed types of templates stored in an array to make a validation process easier.
	 * @var array
	 */
	static $templateTypes = [
		self::TEMPLATE_INFOBOX,
		self::TEMPLATE_QUOTE,
		self::TEMPLATE_NAVBOX,
	];

	/**
	 * A Title object for the page you are classifying.
	 * @var Title
	 */
	private $title;

	public function __construct( Title $templateTitle ) {
		$this->title = $templateTitle;
	}

	/**
	 * Returns the main classification type of the template.
	 * @return string
	 */
	public function getType() {
		return Wikia::getProps( $this->title->getArticleId(), self::TEMPLATE_CLASSIFICATION_MAIN_PROP );
	}

	/**
	 * Checks if the template is of the given type.
	 * @param $type One of values from the $templateTypes array
	 * @return bool
	 */
	public function isType( $type ) {
		if ( !$this->getClassificationProp( $type ) ) {
			// invalid type
			return false;
		}

		return $this->getType() === $type;
	}

	/**
	 * Returns the full name of a page property associated with a given classification types
	 * or false if the type is not a valid one.
	 * @param string $type
	 * @return bool|string
	 */
	private function getClassificationProp( $type ) {
		if ( array_search( $type, self::$templateTypes, true ) !== false ) {
			return self::TEMPLATE_CLASSIFICATION_DATA_PREFIX . $type;
		}

		return false;
	}

	/**
	 * Performs all actions required to log all information required to have a given template
	 * classified and have them stored in an accessible way.
	 * @param string $type A type that you want to classify the template as.
	 * @param bool $value Value of the classification. If false, the type will be set to unclassified.
	 * @param int $actor Specifies if the recognition was made by a machine or a human
	 * @return bool
	 * @throws MWException
	 */
	public function classifyTemplate( $type, $value, $actor = self::CLASSIFICATION_ACTOR_HUMAN ) {
		global $wgUser;

		/**
		 * Check if the fetched $type is valid
		 * and if the user is permitted to perform templatedraft related actions.
		 */
		$prop = self::getClassificationProp( $type );
		if ( !$prop || !$this->title->userCan( 'templatedraft' ) ) {
			return false;
		}

		/**
		 * SET THE PRIMARY PAGE PROPERTY
		 *
		 * If the $value equals false it means somebody has just made a negative recognition
		 * (e.g. the template is NOT an infobox). In this case, we set the primary property to
		 * unclassified to mark that the template has been reviewed, but we do not have a definite
		 * information on its type.
		 */
		if ( !$value ) {
			$type = self::TEMPLATE_UNCLASSIFIED;
		}

		Wikia::setProps( $this->title->getArticleID(), [
			self::TEMPLATE_CLASSIFICATION_MAIN_PROP => $type
		] );

		/**
		 * SET THE SECONDARY PAGE PROPERTY
		 *
		 * This property is used to log more detailed information on the performed action.
		 */
		$data = [
			'value' => (bool) $value,
			'actor' => $actor,
			'actor-id' => $wgUser->getId(),
			'timestamp' => wfTimestamp(),
		];

		Wikia::setProps( $this->title->getArticleID(), [ $prop => json_encode( $data ) ] );

		/**
		 * Since Wikia::setProps fails silently we can return true at this point.
		 */
		return true;
	}
}
