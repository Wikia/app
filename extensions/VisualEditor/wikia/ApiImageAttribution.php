<?

class ApiImageAttribution extends ApiBase {
	public function execute() {

		$params = $this->extractRequestParams();

		// Username
		$fileTitle = Title::newFromText( $params['file'], NS_FILE );
		$username = wfFindFile( $fileTitle )->getUser();
		$this->getResult()->addValue( null, 'username', $username );

		// Avatar
		$avatarUrl = AvatarService::getAvatarUrl( $username, 16 );
		$this->getResult()->addValue( null, 'avatar', $avatarUrl );

		// Title
		$this->getResult()->addValue( null, 'title', $params['file'] );

		return true;
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
