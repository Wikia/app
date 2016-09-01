<?php

use Email\Fatal;

class EnableDiscussionsController extends \WikiaController {

	const ENABLE_DISCUSSIONS_NAVIGATION = 'wgEnableDiscussionNavigation';
	const ENABLE_DISCUSSIONS = 'wgEnableDiscussion';
	const ENABLE_FORUMS = 'wgEnableForumExt';

	const P_SITE_ID = 'siteId';
	const REASON = 'Enabling discussions!';

	public function index() {
		$this->request->isInternal();

		$siteId = $this->request->getParams()[static::P_SITE_ID];

		if ( !is_numeric( $siteId ) || $siteId < 0 ) {
			throw new Fatal( 'Please provide a valid siteId, provided ' . $siteId );
		}

		$discussions = $this->setVariable( $siteId, static::ENABLE_DISCUSSIONS, true );
		$navigation = $this->setVariable( $siteId, static::ENABLE_DISCUSSIONS_NAVIGATION, true );
		$forum = $this->setVariable( $siteId, static::ENABLE_DISCUSSIONS_NAVIGATION, false );

		$this->response->setBody( json_encode( [
			'enableDiscussions' => $discussions,
			'enableNavigation' => $navigation,
			'disableForums' => $forum,
		] ) );
	}

	/**
	 * Make sure to only allow authorized use of this extension.
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		if ( $this->request->isInternal() ) {
			return;
		}
		throw new Fatal( 'Access to this controller is restricted' );
	}

	private function setVariable( $siteId, $name, $value ) {
		$status = WikiFactory::setVarByName( $name, $siteId, $value, static::REASON );
		if ( $status ) {
			WikiFactory::clearCache( $siteId );
		}

		return $status;
	}

}
