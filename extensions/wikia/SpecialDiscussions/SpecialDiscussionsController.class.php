<?php

/**
 * Discussion user log page
 */
class SpecialDiscussionsController extends WikiaSpecialPageController {

	const DISCUSSIONS_ACTION = 'specialdiscussions';

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $siteId;
	private $siteName;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );

		$this->siteId = F::app()->wg->CityId;
		$this->siteName = F::app()->wg->Sitename;
	}

	public function index() {
		$this->assertCanAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );

		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		if ( $this->checkWriteRequest() ) {
			if ( !SpecialDiscussionsHelper::activateDiscussions(
					$this->siteId,
					$this->app->wg->ContLang->getCode(),
					$this->siteName ) ) {
				throw new ErrorPageError( 'unknown-error', 'discussions-activate-error' );
			}
		}

		$this->setIndexOutput();
	}

	public function inputForm() {
		$this->response->setValues(
			[
				'discussionsInactiveMessage' => wfMessage( 'discussions-not-active' )->escaped(),
				'activateDiscussions' => wfMessage( 'discussions-activate' )->escaped(),
				'token' => $this->getUser()->getEditToken(),
			]
		);
	}

	public function discussionsLink() {
		$this->response->setValues(
			[
				'discussionsActiveMessage' => wfMessage( 'discussions-active' )->escaped(),
				'discussionsLink' => SpecialDiscussionsHelper::DISCUSSIONS_LINK,
				'discussionsLinkCaption' => wfMessage( 'discussions-navigate' )->escaped(),
			]
		);
	}

	private function setIndexOutput() {
		$callMethod = SpecialDiscussionsHelper::isDiscussionsActive( $this->siteId ) ? 'discussionsLink' : 'inputForm';
		$this->response->setVal( 'content', $this->sendSelfRequest( $callMethod ) );
	}

	private function assertCanAccess() {
		if ( !$this->wg->User->isAllowed( self::DISCUSSIONS_ACTION ) ) {
			throw new \PermissionsError( self::DISCUSSIONS_ACTION );
		}
	}
}
