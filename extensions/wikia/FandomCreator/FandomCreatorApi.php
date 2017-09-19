<?php

namespace FandomCreator;


class FandomCreatorApi {

	/** @var string */
	private $baseUrl;

	/** @var string */
	private $communityId;

	/**
	 * FandomCreatorApi constructor.
	 * @param string $baseUrl
	 * @param $communityId
	 */
	public function __construct($baseUrl, $communityId) {
		$this->baseUrl = $baseUrl;
		$this->communityId = $communityId;
	}
}