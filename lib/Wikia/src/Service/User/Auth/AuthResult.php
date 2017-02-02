<?php

namespace Wikia\Service\User\Auth;

class AuthResult {
	const AUTH_TYPE_FAILED = 0;
	const AUTH_TYPE_NORMAL_PW = 1;
	const AUTH_TYPE_RESET_PW = 2;
	const AUTH_TYPE_FB_TOKEN = 4;

	private $result;
	private $authType;
	private $status;
	private $accessToken;

	public function __construct( AuthResultBuilder $builder ) {
		$this->result = $builder->getResult();
		$this->authType = $builder->getAuthType();
		$this->status = $builder->getStatus();
		$this->accessToken = $builder->getAccessToken();
	}

	public static function create( bool $result ): AuthResultBuilder {
		return new AuthResultBuilder( $result );
	}

	public function success(): bool {
		return $this->result;
	}

	public function isResetPasswordAuth(): bool {
		return $this->authType === self::AUTH_TYPE_RESET_PW;
	}

	public function checkStatus( int $status ): bool {
		return $this->status === $status;
	}

	public function getAccessToken(): string {
		return $this->accessToken;
	}
}
