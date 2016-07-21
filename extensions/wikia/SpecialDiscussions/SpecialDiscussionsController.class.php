<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

/**
 * Discussion user log page
 */
class SpecialDiscussionsController extends WikiaSpecialPageController {

	const HTTP_STATUS_OK = 200;
	const DISCUSSIONS_ACTION = 'specialdiscussions';
	const SERVICE_NAME = 'discussion';
	const TIMEOUT = 5;
	const EDIT_TOKEN = 'editToken';
	const SITE_NAME_MAX_LENGTH = 256;

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $logger;
	private $sitesApi;
	private $siteId;
	private $siteName;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );

		$this->assertCanAccess();

		$this->sitesApi = $this->getDiscussionSitesApi();
		$this->siteId = F::app()->wg->CityId;
		$this->siteName = F::app()->wg->Sitename;
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	public function index() {
		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );

		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		if ( $this->request->wasPosted() ) {
			$this->activateDiscussions();
		}

		$this->setIndexOutput();
	}

	public function inputForm() {
		$this->response->setValues(
			[
				'discussionsInactiveMessage' => wfMessage( 'discussions-not-active' )->escaped(),
				'activateDiscussions' => wfMessage( 'discussions-activate' )->escaped(),
				'editToken' => $this->getUser()->getEditToken(),
			]
		);
	}

	public function discussionsLink() {
		$this->response->setValues(
			[
				'discussionsActiveMessage' => wfMessage( 'discussions-active' )->escaped(),
				'discussionsLink' => $this->getDiscussionsLink(),
				'discussionsLinkCaption' => wfMessage( 'discussions-navigate' )->escaped(),
			]
		);
	}

	private function setIndexOutput() {
		$callMethod =  $this->isDiscussionsActive() ? 'discussionsLink' : 'inputForm';
		$this->response->setVal( 'content', $this->sendSelfRequest( $callMethod ) );
	}

	private function activateDiscussions() {
		$this->assertValidPostRequest();

		$siteInput = new \Swagger\Client\Discussion\Models\SiteInput(
			[
				'id' => $this->siteId,
				'name' => substr( $this->siteName, 0, self::SITE_NAME_MAX_LENGTH ),
				'language_code' => F::app()->wg->ContLang->getCode(),
			]
		);

		try {
			$this->getDiscussionSitesApi()->createSite( $siteInput, F::app()->wg->TheSchwartzSecretToken );
		} catch ( ApiException $e ) {
			$this->logger->error(
				'Creating site caused an error',
				[
					'siteId' => $this->siteId,
					'error' => $e->getMessage(),
				]
			);
			throw new ErrorPageError( 'unknown-error', 'discussions-activate-error' );
		}
	}

	private function isDiscussionsActive() {
		try {
			$this->getDiscussionSitesApi()->getSite( $this->siteId );
			return true;
		} catch ( ApiException $e ) {
			$this->logger->debug( 'Getting site caused an error',
				[
					'siteId' => $this->siteId,
					'error' => $e->getMessage(),
				] );
		}
		return false;
	}

	private function getDiscussionsLink() {
		return "/d/f";
	}

	private function getDiscussionSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}

	private function assertCanAccess() {
		if ( !$this->wg->User->isAllowed( self::DISCUSSIONS_ACTION ) ) {
			throw new \PermissionsError( self::DISCUSSIONS_ACTION );
		}
	}

	private function assertValidPostRequest() {
		if ( !$this->request->wasPosted() ||
			!$this->getUser()->matchEditToken( $this->request->getVal( self::EDIT_TOKEN ) ) ) {
			throw new BadRequestApiException();
		}
	}
}
