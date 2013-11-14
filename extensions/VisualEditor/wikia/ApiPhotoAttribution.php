<?php

class ApiPhotoAttribution extends ApiBase {
	public function execute() {
		$params = $this->extractRequestParams();

		$title = Title::newFromText( $params['file'], NS_FILE );
		$file = wfFindFile( $title );
		if ( $file ) {
			$username = $file->getUser();
			$avatarUrl = AvatarService::getAvatarUrl( $username, 16 );

			$this->getResult()->addValue( null, 'username', $username );
			$this->getResult()->addValue( null, 'avatar', $avatarUrl );
			$this->getResult()->addValue( null, 'title', $params['file'] );
		} else {
			Wikia::log( __METHOD__, false, "ApiPhotoAttribution called for not existing file: " . $params['file'] );
			$this->dieUsageMsg( 'File does not exist' );
		}
	}

	public function getAllowedParams() {
		return array(
			'file' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
