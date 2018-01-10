<?php

class PhalanxMatchParams {
	/** @var int $wiki */
	private $wiki;

	/** @var string $lang */
	private $lang;

	/** @var string $type */
	private $type;

	/** @var string|string[] $content */
	private $content;

	/** @var string $user */
	private $user;

	/** @var int $userId */
	private $userId;

	public static function builder(): PhalanxMatchParams {
		return new self();
	}

	public static function withGlobalDefaults(): PhalanxMatchParams {
		global $wgCityId, $wgLanguageCode;

		$phalanxMatchParams = new PhalanxMatchParams();
		$phalanxMatchParams->wiki = $wgCityId;
		$phalanxMatchParams->lang = $wgLanguageCode;

		return $phalanxMatchParams;
	}

	/**
	 * @param int $wiki
	 * @return PhalanxMatchParams
	 */
	public function cityId( int $wiki ): PhalanxMatchParams {
		$this->wiki = $wiki;

		return $this;
	}

	/**
	 * @param string $lang
	 * @return PhalanxMatchParams
	 */
	public function langCode( string $lang ): PhalanxMatchParams {
		$this->lang = $lang;

		return $this;
	}

	/**
	 * @param string $type
	 * @return PhalanxMatchParams
	 */
	public function type( string $type ): PhalanxMatchParams {
		$this->type = $type;

		return $this;
	}

	/**
	 * @param string|string[] $content
	 * @return PhalanxMatchParams
	 */
	public function content( $content ): PhalanxMatchParams {
		$this->content = $content;

		return $this;
	}

	/**
	 * @param string $user
	 * @return PhalanxMatchParams
	 */
	public function userName( string $user ): PhalanxMatchParams {
		$this->user = $user;

		return $this;
	}

	/**
	 * @param int $userId
	 * @return PhalanxMatchParams
	 */
	public function userId( int $userId ): PhalanxMatchParams {
		$this->userId = $userId;

		return $this;
	}

	public function buildQueryParams(): string {
		$postData = [];
		$queryParams = get_object_vars( $this );

		ksort( $queryParams );

		foreach ( $queryParams as $key => $values ) {
			if ( is_array( $values ) ) {
				foreach ( array_unique( $values ) as $val ) {
					$postData[] = urlencode( $key ) . '=' . urlencode( $val );
				}

				continue;
			}

			if ( $values !== null ) {
				$postData[] = urlencode( $key ) . '=' . urlencode( $values );
			}
		}

		return implode( '&', $postData );
	}
}
