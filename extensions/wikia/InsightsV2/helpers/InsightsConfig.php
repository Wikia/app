<?php

class InsightsConfig {
	const ACTION = 'action';
	const DISPLAYFIXITMSG = 'displayfixitmessage';
	const PAGEVIEWS = 'pageviews';
	const SUBTYPE = 'subtype';
	const USAGE = 'usage';
	const WHATLINKSHERE = 'whatlinkshere';
	const WHATLINKSHEREMSG = 'whatlinksheremessage';

	// should display page views data
	private $pageViews = false;
	// should display link to "what links here" page
	private $whatLinksHere = false;
	// message to create "what links here" link
	private $whatLinksHereMessage = 'insights-used-on';
	// should display notification fix message
	private $displayFixItMessage = false;
	// does insight has additional action
	private $action = false;
	// insights usage
	private $usage = InsightsModel::INSIGHTS_USAGE_ACTIONABLE;
	// insights type
	private $type;
	// insights subtype (if exists)
	private $subtype;
	// insights subtypes list
	private $subtypes = [];

	public function __construct( $type, $config = [] ) {
		$this->type = $type;

		if ( isset( $config[self::PAGEVIEWS] ) ) {
			$this->pageViews = $config[self::PAGEVIEWS];
		}

		if ( isset( $config[self::WHATLINKSHERE] ) ) {
			$this->whatLinksHere = $config[self::WHATLINKSHERE];
		}

		if ( isset( $config[self::WHATLINKSHEREMSG] ) ) {
			$this->whatLinksHereMessage = $config[self::WHATLINKSHEREMSG];
		}

		if ( isset( $config[self::DISPLAYFIXITMSG] ) ) {
			$this->displayFixItMessage = $config[self::DISPLAYFIXITMSG];
		}

		if ( isset( $config[self::ACTION] ) ) {
			$this->action = $config[self::ACTION];
		}

		if ( isset( $config[self::USAGE] ) ) {
			$this->usage = $config[self::USAGE];
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

	public function displayFixItMessage() {
		return $this->displayFixItMessage;
	}

	public function hasAction() {
		return $this->action;
	}

	public function getInsightUsage() {
		return $this->usage;
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
