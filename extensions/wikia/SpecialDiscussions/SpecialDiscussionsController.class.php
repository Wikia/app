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

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $logger;
	private $sitesApi;
	private $siteId;
	private $siteName;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );
		$this->sitesApi = $this->getDiscussionSitesApi();
		$this->siteId = F::app()->wg->CityId;
		$this->siteName = WikiFactory::getVarValueByName( 'wgSitename', $this->siteId );
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	public function index() {
		$this->checkAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );

		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		$editToken = $this->getVal( self::EDIT_TOKEN );
		if ( !empty( $editToken ) ) {
			$this->activateDiscussions();
		}

		$this->setIndexOutput();
	}

	public function inputForm() {
		$this->checkAccess();

		$this->response->setValues(
			[
				'discussionsInactiveMessage' => wfMessage( 'discussions-not-active' )->escaped(),
				'activateDiscussions' => wfMessage( 'discussions-activate' )->escaped(),
				'editToken' => $this->getUser()->getEditToken(),
			]
		);
	}

	public function discussionsLink() {
		$this->checkAccess();

		$this->response->setValues(
			[
				'discussionsActiveMessage' => wfMessage( 'discussions-active' )->escaped(),
				'discussionsLink' => $this->getDiscussionsLink(),
				'discussionsLinkCaption' => wfMessage( 'discussions-navigate' )->escaped(),
			]
		);
	}

	private function setIndexOutput() {
		if ( $this->getIsDiscussionsActive() ) {
			$this->response->setVal(
				'discussionsLink',
				$this->sendSelfRequest(
					'discussionsLink',
					[
						'discussionsLink' => $this->getDiscussionsLink(),
					]
				)
			);
		} else {
			$this->response->setVal(
				'inputForm',
				$this->sendSelfRequest(
					'inputForm',
					[
						'activateDiscussions' => $this->getActivateDiscussionsMessage(),
					]
				)
			);
		}
	}

	private function activateDiscussions() {
		$this->assertValidPostRequest( $this->request, $this->getUser() );

		$site = new \Swagger\Client\Discussion\Models\Site(
			[
				'id' => $this->siteId,
				'languageCode' => F::app()->wg->ContLang->getCode(),
			]
		);

		try {
			$this->getDiscussionSitesApi()->createSite( $site, F::app()->wg->TheSchwartzSecretToken );
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

	private function getIsDiscussionsActive() {
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

	private function getActivateDiscussionsMessage() {
		return wfMessage( 'discussions-activate' )->escaped();
	}

	private function getDiscussionSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}

	private function checkAccess() {
		if ( !$this->wg->User->isAllowed( self::DISCUSSIONS_ACTION ) ) {
			throw new \PermissionsError( self::DISCUSSIONS_ACTION );
		}
	}

	private function assertValidPostRequest( WikiaRequest $request, User $user ) {
		if ( !$request->wasPosted() || !$user->matchEditToken( $request->getVal( self::EDIT_TOKEN ) ) ) {
			throw new BadRequestApiException();
		}
	}
}
