<?

class ApiPhotoAttribution extends ApiBase {
	public function execute() {

		$params = $this->extractRequestParams();

		// Username
		$username = wfFindFile( $params['file'] )->getUser();
		$this->getResult()->addValue( null, 'username', $username );

		// Avatar
		$avatarUrl = AvatarService::getAvatarUrl( $username, 16 );
		$this->getResult()->addValue( null, 'avatar', $avatarUrl );

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
