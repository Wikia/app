<?php

class EnableDiscussionsController extends \WikiaController {

	const ROLLBACK = 'rollback';

	private $discussionsApi;
	private $varToggler;

	public function __construct() {
		parent::__construct();
		$this->varToggler = new DiscussionsVarToggler();
		$this->discussionsApi = new DiscussionsApi();
	}

	public function index() {
		$this->assertCanAccessController();

		$isRollback = $this->request->getBool( self::ROLLBACK );
		$this->varToggler
			->setEnableDiscussions( !$isRollback )
			->setEnableDiscussionsNav( !$isRollback )
			->setArchiveWikiForums( !$isRollback )
			->setEnableForums( $isRollback )
			->save();

		$this->response->setBody( json_encode( [
			DiscussionsVarToggler::ENABLE_DISCUSSIONS => !$isRollback,
			DiscussionsVarToggler::ENABLE_DISCUSSIONS_NAV => !$isRollback,
			DiscussionsVarToggler::ARCHIVE_WIKI_FORUMS => !$isRollback,
			DiscussionsVarToggler::ENABLE_FORUMS => $isRollback,
		] ) );
	}

	/**
	 * Make sure to only allow authorized POST methods.
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		if ( !$this->request->isInternal() ) {
			throw new ForbiddenException( 'Access to this controller is restricted' );
		}
	}
}
