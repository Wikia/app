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
	const DEFAULT_LANG = 'en';

	const SUCCESSFUL_STATUS = 201;

	/**
	 * The languages supported by the ChillingEffects API.
	 * @var array
	 */
	private $supportedLanguages = [
		'af' => 'Afrikaans',
		'ar' => 'Arabic',
		'be' => 'Belarusian',
		'bg' => 'Bulgarian',
		'ca' => 'Catalan; Valencian',
		'cs' => 'Czech',
		'cy' => 'Welsh',
		'da' => 'Danish',
		'de' => 'German',
		'el' => 'Greek, Modern',
		'en' => 'English',
		'eo' => 'Esperanto',
		'es' => 'Spanish; Castilian',
		'et' => 'Estonian',
		'fa' => 'Persian',
		'fi' => 'Finnish',
		'fr' => 'French',
		'ga' => 'Irish',
		'gl' => 'Galician',
		'hi' => 'Hindi',
		'hr' => 'Croatian',
		'ht' => 'Haitian; Haitian Creole',
		'hu' => 'Hungarian',
		'id' => 'Indonesian',
		'is' => 'Icelandic',
		'it' => 'Italian',
		'iw' => 'Hebrew',
		'ja' => 'Japanese',
		'ko' => 'Korean',
		'lt' => 'Lithuanian',
		'lv' => 'Latvian',
		'mk' => 'Macedonian',
		'ml' => 'Malayalam',
		'ms' => 'Malay',
		'mt' => 'Maltese',
		'nl' => 'Dutch',
		'no' => 'Norwegian',
		'pl' => 'Polish',
		'pt' => 'Portuguese',
		'ro' => 'Romanian',
		'ru' => 'Russian',
		'si' => 'Sinhala',
		'sk' => 'Slovak',
		'sl' => 'Slovene',
		'sq' => 'Albanian',
		'sr' => 'Serbian',
		'sv' => 'Swedish',
		'sw' => 'Swahili',
		'th' => 'Thai',
		'tl' => 'Tagalog',
		'tr' => 'Turkish',
		'uk' => 'Ukrainian',
		'vi' => 'Vietnamese',
		'yi' => 'Yiddish',
		'yo' => 'Yoruba',
		'zh' => 'Chinese',
	];

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
	 * Get a list of languages supported by the ChillingEffects API.
	 *
	 * @return array Language list with the code supported by ChillingEffects
	 *               as the key.
	 */
	public function getSupportedLanguages() {
		return $this->supportedLanguages;
	}

	/**
	 * Verify a given language code is supported by the ChillingEffects API.
	 *
	 * @param  string  $code Language code to check.
	 * @return boolean
	 */
	public function isValidLanguageCode( $code ) {
		return array_key_exists( $code, $this->supportedLanguages );
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

		return \ExternalHttp::post(
			$this->baseUrl . '/notices',
			[
				'postData' => json_encode( $requestData ),
				'headers' => [
					'Accept' => 'application/json',
					'Content-type' => 'application/json',
				],
				'returnInstance' => true
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
			'language' => $noticeData['language'],
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
					'name' => 'submitter',
					'entity_attributes' => $orgDetails,
				],
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
