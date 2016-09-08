<?php

class EnableDiscussionsController extends \WikiaController {

	const ENABLE_DISCUSSIONS_NAV = 'wgEnableDiscussionNavigation';
	const ENABLE_DISCUSSIONS = 'wgEnableDiscussion';
	const ENABLE_FORUMS = 'wgEnableForumExt';

	const P_SITE_ID = 'siteId';
	const P_ROLLBACK = 'rollback';
	const REASON = 'Enabling discussions!';

	public function index() {
		$this->assertCanAccessController();

		$siteId = $this->request->getInt( self::P_SITE_ID );
		$isRollback = $this->request->getBool( self::P_ROLLBACK );

		if ( $siteId < 1 ) {
			throw new InvalidArgumentException( 'Please provide a valid siteId, provided ' .
			                                    $siteId );
		}

		$discussions = $this->setVariable( $siteId, self::ENABLE_DISCUSSIONS, !$isRollback );
		$navigation = $this->setVariable( $siteId, self::ENABLE_DISCUSSIONS_NAV, !$isRollback );
		$forum = $this->setVariable( $siteId, self::ENABLE_FORUMS, $isRollback );

		$this->response->setBody( json_encode( [
			'enableDiscussions' => $discussions,
			'enableNavigation' => $navigation,
			'disableForums' => $forum,
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
		if ( !$this->request->wasPosted() ) {
			throw new MethodNotAllowedException( 'Only POST allowed' );
		}
	}

	private function setVariable( $siteId, $name, $value ) {
		$status = WikiFactory::setVarByName( $name, $siteId, $value, self::REASON );
		if ( $status ) {
			WikiFactory::clearCache( $siteId );
		}

		return $status;
	}

}
