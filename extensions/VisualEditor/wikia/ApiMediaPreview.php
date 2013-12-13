<?php

// NOTE: this is only for videos now - might need to change the class name to reflect that
class ApiMediaPreview extends ApiBase {
	const PREVIEW_WIDTH = 728;

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$this->mParams = $this->extractRequestParams();
		$this->mRequest = $this->getMain()->getRequest();
		$this->mUser = $this->getUser();

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

		$tempVideo->setVideoId( $videoId );
		$tempVideo->setProps( array( 'mime' => 'video/' . $provider ) );

		return array(
			'embedCode' => json_encode( $tempVideo->getEmbedCode( self::PREVIEW_WIDTH, false, false, true ) ),
		);
	}

	private function executeWikiaVideo( $title ) {
		$file = wfFindFile( $title );

		if ( !( $file instanceof LocalFile ) ) {
			$this->dieUsage( 'Wikia video doesn\'t exist', 'wikia-video-missing' );
		}

		return array(
			'embedCode' => $file->getEmbedCode( self::PREVIEW_WIDTH, false, false, true),
		);
	}

	public function getAllowedParams() {
		return array(
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

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}