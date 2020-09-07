<?php

class EnableDiscussionsController extends \WikiaController {

	const ENABLE_DISCUSSIONS = 'enableDiscussions';
	const ENABLE_FORUM = 'enableForum';
	const SITE_ID = 'siteId';
	const CREATE_WELCOME_POST = 'createWelcomePost';

	public function init() {
		$this->assertCanAccessController();
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function activateDiscussions() {
		try {
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
		} catch ( WikiaBaseException $exception ) {
			// This is normally done in WikiaDispatcher::dispatch(),
			// but because it's an internal request, we would return 200 and only log error to ELK stack
			$this->response->setCode( $exception->getCode() );
			$this->response->setVal(
				'exception',
				[
					'message' => $exception->getMessage(),
					'code' => $exception->getCode()
				]
			);
		}
	}

	public function toggleVars() {
		$enableDiscussions = $this->request->getBool( self::ENABLE_DISCUSSIONS );
		$enableForum = $this->request->getBool( self::ENABLE_FORUM );
		$cityId = $this->request->getInt( self::SITE_ID, $this->wg->CityId );

		( new DiscussionsVarToggler( $cityId ) )->setEnableDiscussions( $enableDiscussions )
			->setEnableDiscussionsNav( $enableDiscussions )
			->setArchiveWikiForums( !$enableForum )
			->setEnableForums( $enableForum )
			->save();

		$this->response->setBody( json_encode( [
			DiscussionsVarToggler::ENABLE_DISCUSSIONS => $enableDiscussions,
			DiscussionsVarToggler::ENABLE_DISCUSSIONS_NAV => $enableDiscussions,
			DiscussionsVarToggler::ARCHIVE_WIKI_FORUMS => !$enableForum,
			DiscussionsVarToggler::ENABLE_FORUMS => $enableForum,
		] ) );
	}

	public function toggleReadOnlyForum() {
		$cityId = $this->request->getInt( 'siteId', $this->wg->CityId );
		$isRollback = $this->request->getBool( 'rollback', false );

		$success = WikiFactory::setVarByName( 'wgHideForumForms', $cityId, !$isRollback);

		if ( $success ) {
			$this->response->setCode( 200 );
		} else {
			$this->response->setCode( 500 );
		}
	}

	public function togglePostForumMigrationMessage() {
		$cityId = $this->request->getInt( 'siteId', $this->wg->CityId );
		$value = $this->request->getBool( 'value', true );

		$successBool = WikiFactory::setVarByName( 'wgEnablePostForumMigrationMessage', $cityId, $value );
		// keep the message displayed for 7 days
		$successTimestamp = WikiFactory::setVarByName( 'wgPostForumMigrationMessageExpiration', $cityId, time() + 60 * 60 * 24 * 7 );

		if ( $successBool && $successTimestamp ) {
			$this->response->setCode( 200 );
		} else {
			$this->response->setCode( 500 );
		}
	}

	public function toggleBeforeForumMigrationMessage() {
		$cityId = $this->request->getInt( 'siteId', $this->wg->CityId );
		$value = $this->request->getBool( 'value', false );

		$success = WikiFactory::setVarByName( 'wgEnableForumMigrationMessage', $cityId, $value );

		if ( $success ) {
			$this->response->setCode( 200 );
		} else {
			$this->response->setCode( 500 );
		}
	}

	/**
	 * Make sure to only allow authorized POST methods.
	 * @throws WikiaHttpException
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
