<?php

class SpecialDiscussionsController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/f';
	const DISCUSSIONS_ACTION = 'specialdiscussions';

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	private $activator;
	private $toggler;

	public function __construct() {
		parent::__construct( 'Discussions', '', false );
		$this->toggler = new DiscussionsVarToggler( $this->wg->CityId );
		$this->activator = new DiscussionsActivator(
			$this->wg->CityId,
			$this->wg->Sitename,
			$this->wg->ContLang->getCode()
		);
	}

	public function index() {
		$this->assertCanAccess();

		$this->setHeaders();
		$this->response->addAsset( 'special_discussions_scss' );
		$this->wg->Out->setPageTitle( wfMessage( 'discussions-pagetitle' )->escaped() );

		if ( $this->request->wasPosted() ) {
			$this->checkWriteRequest();
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

	private function setIndexOutput() {
		$callMethod = $this->activator->isDiscussionsActive() ? 'discussionsLink' : 'inputForm';
		$this->response->setVal( 'content', $this->sendSelfRequest( $callMethod ) );
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
		global $wgScriptPath;

		$this->response->setValues(
			[
				'discussionsActiveMessage' => wfMessage( 'discussions-active' )->escaped(),
				'discussionsLink' => $wgScriptPath . self::DISCUSSIONS_LINK,
				'discussionsLinkCaption' => wfMessage( 'discussions-navigate' )->escaped(),
			]
		);
	}

	/**
	 * Override directory where Nirvana looks for templates
	 * @return string
	 */
	public static function getTemplateDir() {
		return __DIR__ . '/../templates';
	}
}
