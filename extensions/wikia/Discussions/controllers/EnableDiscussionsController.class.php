<?php

class EnableDiscussionsController extends \WikiaController {

	const ROLLBACK = 'rollback';
	const SITE_ID = 'siteId';
	const CREATE_WELCOME_POST = 'createWelcomePost';

	public function init() {
		$this->assertCanAccessController();
	}

	public function activateDiscussions() {
		$cityId = $this->request->getInt( self::SITE_ID );
		if ( empty( $cityId ) ) {
			throw new BadRequestException();
		}

		$wiki = WikiFactory::getWikiByID( $cityId );
		if ( empty( $wiki ) ) {
			throw new NotFoundException();
		}

		( new \DiscussionsActivator( $wiki->city_id, $wiki->city_title,
			$wiki->city_lang ) )->activateDiscussions();

		if ( $this->request->getBool( self::CREATE_WELCOME_POST, false ) ) {
			( new \StaffWelcomePoster() )->postMessage( $wiki->city_id, $wiki->city_lang );
		}
	}

	public function toggleVars() {
		$isRollback = $this->request->getBool( self::ROLLBACK );
		$cityId = $this->request->getInt( self::SITE_ID, $this->wg->CityId );

		( new DiscussionsVarToggler( $cityId ) )->setEnableDiscussions( !$isRollback )
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
		if ( !$this->request->wasPosted() ) {
			throw new MethodNotAllowedException( 'Only POST allowed' );
		}
	}
}
