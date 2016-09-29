<?php

class SpecialDiscussionsController extends WikiaSpecialPageController {

	const DISCUSSIONS_ACTION = 'specialdiscussions';
	const EDIT_TOKEN = 'editToken';

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $discussionsApi;
	private $varToggler;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );
		$this->discussionsApi = new DiscussionsApi();
		$this->varToggler = new DiscussionsVarToggler();
	}

	public function index() {
		$this->assertCanAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );

		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		if ( $this->request->wasPosted() ) {
			$this->assertValidPostRequest();
			$this->discussionsApi->activateDiscussions();
			$this->varToggler->setEnableDiscussions( true )->save();
		}

		$this->setIndexOutput();
	}

	private function assertCanAccess() {
		if ( !$this->wg->User->isAllowed( self::DISCUSSIONS_ACTION ) ) {
			throw new \PermissionsError( self::DISCUSSIONS_ACTION );
		}
	}

	private function assertValidPostRequest() {
		if ( !$this->getUser()->matchEditToken( $this->request->getVal( self::EDIT_TOKEN ) ) ) {
			throw new BadRequestApiException();
		}
	}

	private function setIndexOutput() {
		$callMethod = $this->discussionsApi->isDiscussionsActive() ? 'discussionsLink' : 'inputForm';
		$this->response->setVal( 'content', $this->sendSelfRequest( $callMethod ) );
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

	private function getDiscussionsLink() {
		return "/d/f";
	}

	public static function getTemplateDir() {
		return dirname( __FILE__ ) . '/../templates';
	}
}
