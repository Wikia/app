<?php

class WdsSearchModule {
	use WdsTrackingLabelTrait;

	public $type = 'search';
	public $suggestions;
	public $results;

	/**
	 * @param mixed $suggestions
	 * @return WdsSearchModule
	 */
	public function setSuggestions( $suggestions ) {
		$this->suggestions = $suggestions;

		return $this;
	}

	/**
	 * @param mixed $results
	 * @return WdsSearchModule
	 */
	public function setResults( $results ) {
		$this->results = $results;

		return $this;
	}

	/**
	 * @param WdsTranslatableText $activePlaceholder
	 * @return $this
	 */
	public function setActivePlaceholder( WdsTranslatableText $activePlaceholder ) {
		$this->{'placeholder-active'} = $activePlaceholder;

		return $this;
	}

	/**
	 * @param WdsTranslatableText $activePlaceholder
	 * @return $this
	 */
	public function setInactivePlaceholder( WdsTranslatableText $inactivePlaceholder ) {
		$this->{'placeholder-inactive'} = $inactivePlaceholder;

		return $this;
	}
}
