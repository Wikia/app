<?php

namespace Wikia\Service\User\Auth;

class AuthResultBuilder {
	private $result = false;
	private $authType = AuthResult::AUTH_TYPE_FAILED;
	private $status = \WikiaResponse::RESPONSE_CODE_ERROR;
	private $accessToken = '';

	public function __construct( bool $result ) {
		$this->result = $result;
	}

	public function result( bool $result ): AuthResultBuilder {
		$this->result = $result;
		return $this;
	}

	public function authType( int $authType ): AuthResultBuilder {
		$this->authType = $authType;
		return $this;
	}

	public function status( int $status ): AuthResultBuilder {
		$this->status = $status;
		return $this;
	}

	public function accessToken( string $accessToken ): AuthResultBuilder {
		$this->accessToken = $accessToken;
		return $this;
	}

	public function getResult(): bool {
		return $this->result;
	}

	public function getAuthType(): int {
		return $this->authType;
	}

	public function getStatus(): int {
		return $this->status;
	}

	public function getAccessToken(): string {
		return $this->accessToken;
	}

	public function build(): AuthResult {
		return new AuthResult( $this );
	}
}
