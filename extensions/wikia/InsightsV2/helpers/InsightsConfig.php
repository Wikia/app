<?php

class InsightsConfig {
	const SUBTYPE = 'subtype';

	private $pageViews = true;
	private $whatLinksHere = false;
	private $whatLinksHereMessage = 'insights-used-on';
	private $displayFix = true;
	private $actions = [];
	private $type;
	private $subtype;

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

		if ( isset( $config['actions'] ) ) {
			$this->actions = $config['actions'];
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

	public function hasActions() {
		return !empty( $this->actions );
	}

	public function getActions() {
		return $this->actions;
	}

	public function getInsightType() {
		return $this->type;
	}

	public function getInsightSubType() {
		return $this->subtype;
	}
}