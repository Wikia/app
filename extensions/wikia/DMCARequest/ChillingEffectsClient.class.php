<?php

/**
 * Client class for sending notices to the Chilling Effects API.
 *
 * @author grunny
 */

namespace DMCARequest;

class ChillingEffectsClient {

	const DMCA_TYPE = 'Dmca';
	const DMCA_TOPIC = 5;

	const SUCCESSFUL_STATUS = 201;

	private $baseUrl;
	private $apiToken;

	/**
	 * Create client object.
	 *
	 * @param string $baseUrl  API URL.
	 * @param string $apiToken API token.
	 */
	public function __construct( $baseUrl, $apiToken ) {
		$this->baseUrl = $baseUrl;
		$this->apiToken = $apiToken;
	}

	/**
	 * Send notice data to the ChillingEffects API.
	 *
	 * @param  array         $noticeData The notice data to send to the CE API.
	 * @return MWHttpRequest             Instance of the executed request.
	 */
	public function sendNotice( array $noticeData ) {
		$requestData = [
			'authentication_token' => $this->apiToken,
			'notice' => $noticeData,
		];

		return \Http::post(
			$this->baseUrl . '/notices',
			[
				'postData' => json_encode( $requestData ),
				'headers' => [
					'Accept' => 'application/json',
					'Content-type' => 'application/json',
				],
				'returnInstance' => true,
				'noProxy' => true,
			]
		);
	}

	/**
	 * Check if a request to the ChillingEffects API was successful.
	 *
	 * @param  MWHttpRequest $response The response from the API request.
	 * @return boolean
	 */
	public function requestSuccessful( \MWHttpRequest $response ) {
		return $response->getStatus() === self::SUCCESSFUL_STATUS;
	}

	/**
	 * Get the resulting notice ID from the reponse header of the API
	 * request.
	 *
	 * @param  MWHttpRequest $response The response from the API request.
	 * @return int|boolean             The ID of the resulting notice or
	 *                                 false on failure.
	 */
	public function getNoticeIdFromResponse( \MWHttpRequest $response ) {
		$location = $response->getResponseHeader( 'Location' );

		if ( empty( $location ) ) {
			return false;
		}

		$path = parse_url( $location, PHP_URL_PATH );

		$matches = [];
		if ( preg_match( '/^\/notices\/(\d+)$/', $path, $matches ) ) {
			return (int)$matches[1];
		}

		return false;
	}

	/**
	 * Prepare notice data to be sent to ChillingEffects.
	 *
	 * @param  array  $noticeData The notice data.
	 * @param  array  $orgDetails The details of the recipient of the DMCA request.
	 * @return array              Prepared notice data.
	 */
	public function prepareNoticeData( array $noticeData, array $orgDetails ) {
		$originalUrls = [];
		foreach ( $noticeData['original_urls'] as $url ) {
			$originalUrls[] = [ 'url' => $url ];
		}

		$infringingUrls = [];
		foreach ( $noticeData['infringing_urls'] as $url ) {
			$infringingUrls[] = [ 'url' => $url ];
		}

		$noticeData = [
			'title' => $noticeData['reporttitle'],
			'type' => self::DMCA_TYPE,
			'subject' => $noticeData['subject'],
			'date_sent' => $noticeData['date'],
			'date_received' => $noticeData['date'],
			'source' => $noticeData['source'],
			'topic_ids' => [ self::DMCA_TOPIC ],
			'jurisdiction_list' => 'US, CA',
			'action_taken' => $noticeData['actiontaken'],
			'works_attributes' => [
				[
					'kind' => $noticeData['kind'],
					'description' => $noticeData['description'],
					'copyrighted_urls_attributes' => $originalUrls,
					'infringing_urls_attributes' => $infringingUrls,
				]
			],
			'entity_notice_roles_attributes' => [
				[
					'name' => 'recipient',
					'entity_attributes' => $orgDetails,
				],
				[
					'name' => 'sender',
					'entity_attributes' => [
						'name' => $noticeData['fullname'],
						'kind' => $noticeData['sendertype'],
					],
				],
			],
		];

		return $noticeData;
	}
}
