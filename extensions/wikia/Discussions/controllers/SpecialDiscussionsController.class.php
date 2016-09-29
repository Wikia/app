<?php

class SpecialDiscussionsController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/d/f';
	const DISCUSSIONS_ACTION = 'specialdiscussions';
	const EDIT_TOKEN = 'editToken';

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $activator;
	private $toggler;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );
		$this->activator = new DiscussionActivator();
		$this->toggler = new DiscussionsVarToggler();
	}

	public function index() {
		$this->assertCanAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );
		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		if ( $this->request->wasPosted() ) {
			$this->assertValidPostRequest();
			$this->activator->activateDiscussions();
			$this->toggler->setEnableDiscussions( true )->save();
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
		$callMethod = $this->activator->isDiscussionsActive() ? 'discussionsLink' : 'inputForm';
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
				'discussionsLink' => self::DISCUSSIONS_LINK,
				'discussionsLinkCaption' => wfMessage( 'discussions-navigate' )->escaped(),
			]
		);
	}

	/**
	 * Override the directory Nirvana looks for templates in
	 * @return string
	 */
	public static function getTemplateDir() {
		return dirname( __FILE__ ) . '/../templates';
	}
}
