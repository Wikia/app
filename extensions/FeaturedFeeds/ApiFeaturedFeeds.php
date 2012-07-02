<?php

class ApiFeaturedFeeds extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	/**
	 * This module uses a custom feed wrapper printer.
	 *
	 * @return ApiFormatFeedWrapper
	 */
	public function getCustomPrinter() {
		return new ApiFormatFeedWrapper( $this->getMain() );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );

		$params = $this->extractRequestParams();

		global $wgFeedClasses;

		if ( !isset( $wgFeedClasses[$params['feedformat']] ) ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage( 'Invalid subscription feed type', 'feed-invalid' );
		}

		$language = isset( $params['language'] ) ? $params['language'] : false;
		if ( $language !== false && !Language::isValidCode( $language ) ) {
			$language = false;
		}
		$feeds = FeaturedFeeds::getFeeds( $language );
		$ourFeed = $feeds[$params['feed']];

		$feedClass = new $wgFeedClasses[$params['feedformat']] (
			$ourFeed->title,
			$ourFeed->description,
			wfExpandUrl( Title::newMainPage()->getFullURL() )
		);

		ApiFormatFeedWrapper::setResult( $this->getResult(), $feedClass, $ourFeed->getFeedItems() );

		// Cache stuff in squids
		$this->getMain()->setCacheMode( 'public' );
		$this->getMain()->setCacheMaxAge( FeaturedFeeds::getMaxAge() );

		wfProfileOut( __METHOD__ );
	}

	public function getAllowedParams() {
		global $wgFeedClasses;
		$feedFormatNames = array_keys( $wgFeedClasses );
		$availableFeeds = array_keys( FeaturedFeeds::getFeeds( false ) );
		return array (
			'feedformat' => array(
				ApiBase::PARAM_DFLT => 'rss',
				ApiBase::PARAM_TYPE => $feedFormatNames
			),
			'feed' => array(
				ApiBase::PARAM_TYPE => $availableFeeds,
				ApiBase::PARAM_REQUIRED => true,
			),
			'language' => array(
				ApiBase::PARAM_TYPE => 'string',
			)
		);
	}

	public function getParamDescription() {
		return array(
			'feedformat' => 'The format of the feed',
			'feed' => 'Feed name',
			'language' => 'Feed language code. Ignored by some feeds.',
		);
	}

	public function getDescription() {
		return 'Returns a user contributions feed';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'feed-invalid', 'info' => 'Invalid subscription feed type' ),
		) );
	}

	public function getExamples() {
		global $wgVersion;
		// attempt to find a valid feed name
		// if none available, just use an example value
		$availableFeeds = array_keys( FeaturedFeeds::getFeeds( false ) );
		$feed = reset( $availableFeeds );
		if ( !$feed ) {
			$feed = 'featured';
		}

		if ( version_compare( $wgVersion, '1.19alpha', '>=' ) ) {
			return array(
				"api.php?action=featuredfeed&feed=$feed" => "Retrieve feed ``$feed'",
			);
		} else {
			return array(
				"Retrieve feed `$feed'",
				"    api.php?action=featuredfeed&feed=$feed",
			);
		}
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiFeaturedFeeds.php 110562 2012-02-02 12:47:16Z liangent $';
	}
}
