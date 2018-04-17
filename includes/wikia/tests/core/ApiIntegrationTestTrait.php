<?php

trait ApiIntegrationTestTrait {
	/** @var User $user */
	private $user;

	/** @var string $editToken */
	private $editToken;

	protected function setupRequestUser( $userId ) {
		$this->user = User::newFromId( $userId );
		return $this;
	}

	protected function withExpectedToken( string $editToken ) {
		$this->editToken = $editToken;
		return $this;
	}

	protected function doApiRequest( array $params ): array {
		$request = new FauxRequest( $params );

		if ( $this->editToken ) {
			$request->setSessionData( 'wsEditToken', $this->editToken );
		}

		$context = new RequestContext();
		$context->setRequest( $request );

		if ( $this->user ) {
			$context->setUser( $this->user );
		}

		$api = new ApiMain( $context, true );
		$api->execute();

		return $api->getResultData();
	}

	protected function getTokenHash( string $editToken ): string {
		return md5( $editToken ) . EDIT_TOKEN_SUFFIX;
	}
}
