<?php

class InsightsConfig {
	const SUBTYPE = 'subtype';

	private $pageViews = true;
	private $whatLinksHere = false;
	private $whatLinksHereMessage = 'insights-used-on';
	private $displayFix = true;
	private $action = false;
	private $type;
	private $subtype;
	private $subtypes = [];

	public function __construct( $type, $config = [] ) {
		$this->type = $type;

		if ( isset( $config['pageviews'] ) ) {
			$this->pageViews = $config['pageviews'];
		}

		if ( isset( $config['whatlinkshere'] ) ) {
			$this->whatLinksHere = $config['whatlinkshere'];
		}

		if ( isset( $config['whatlinksheremessage'] ) ) {
			$this->whatLinksHereMessage = $config['whatlinksheremessage'];
		}

		if ( isset( $config['displayfix'] ) ) {
			$this->displayFix = $config['displayfix'];
		}

		if ( isset( $config['action'] ) ) {
			$this->action = $config['action'];
		}

		if ( isset( $config[self::SUBTYPE] ) ) {
			$this->subtype = $config[self::SUBTYPE];
		}
	}

	public function showPageViews() {
		return $this->pageViews;
	}

	public function showWhatLinksHere() {
		return $this->whatLinksHere;
	}

	public function getWhatLinksHereMessage() {
		return $this->whatLinksHereMessage;
	}

	public function displayFix() {
		return $this->displayFix;
	}

	public function hasAction() {
		return $this->action;
	}

	public function getInsightType() {
		return $this->type;
	}

	public function getInsightSubType() {
		return $this->subtype;
	}

	public function hasSubtypes() {
		return !empty( $this->subtypes );
	}

	public function setSubtypes( Array $subtypes ) {
		$this->subtypes = $subtypes;
	}

	public function getSubtypes() {
		return $this->subtypes;
	}
}
