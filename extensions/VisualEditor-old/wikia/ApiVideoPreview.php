<?php

/**
 * Class ApiVideoPreview
 *
 * Get embed code for previewing videos
 */

class ApiVideoPreview extends ApiBase {
	const EMBED_WIDTH = 728;

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$this->mParams = $this->extractRequestParams();

		if ( $this->mParams['provider'] === 'wikia' ) {
			$result = $this->executeWikiaVideo( $this->mParams['title'] );
		} else {
			$result = $this->execute3rdPartyVideo( $this->mParams['provider'], $this->mParams['videoId'] );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	/**
	 * @param string $provider Ex: youtube
	 * @param string $videoId Video id from provider
	 * @return array
	 */
	private function execute3rdPartyVideo( $provider, $videoId ) {
		$tempVideo = new WikiaLocalFile(
			Title::newFromText( uniqid( 'Temp_', true ), NS_FILE ),
			RepoGroup::singleton()->getLocalRepo()
		);

		// forceMime makes sure the correct file properties are set and sent to the handler when afterSetProps is called
		$tempVideo->forceMime( 'video/' . $provider );
		$tempVideo->setVideoId( $videoId );
		$tempVideo->afterSetProps();

		$options = [
			'autoplay' => true,
			'isAjax' => true,
		];

		return array(
			'embedCode' => json_encode( $tempVideo->getEmbedCode( self::EMBED_WIDTH, $options ) ),
		);
	}

	/**
	 * @param string $title Video title
	 * @return array
	 */
	private function executeWikiaVideo( $title ) {
		$file = wfFindFile( $title );
		if ( !( $file instanceof LocalFile ) ) {
			$this->dieUsage( 'Wikia video doesn\'t exist', 'wikia-video-missing' );
		}

		$options = [
			'autoplay' => true,
			'isAjax' => true,
		];

		return array(
			'embedCode' => json_encode( $file->getEmbedCode( self::EMBED_WIDTH, $options ) ),
		);
	}

	/**
	 * @return array
	 */
	public function getAllowedParams() {
		return array(
			'title' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false,
			),
			'videoId' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false,
			),
			'provider' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false,
			),
		);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}