<?php

class RevisionUpvotesApiController extends WikiaApiController {

	/**
	 * Add upvote for given revision made by current user
	 *
	 * @requestParam int revisionId
	 *
	 * @throws MissingParameterApiException
	 * @throws NotFoundException
	 * @throws BadRequestApiException
	 */
	public function addUpvote() {
		$request = $this->getRequest();
		$user = $this->wg->User;

		if ( !$user->isLoggedIn() ) {
			throw new UnauthorizedException();
		}
		$this->checkWriteRequest();

		$revisionId = $request->getInt( 'revisionId' );
		if ( empty( $revisionId ) ) {
			throw new MissingParameterApiException( 'revisionId' );
		}

		$revision = Revision::newFromId( $revisionId );
		if ( !$revision instanceof Revision ) {
			throw new NotFoundException();
		}

		$id = ( new RevisionUpvotesService() )->addUpvote(
			$this->wg->CityId,
			$revision->getPage(),
			$revisionId,
			$revision->getUser(),
			$user->getId()
		);

		$this->setResponseData( [
			'success' => !empty( $id ),
			'id' => $id
		] );
	}

	/**
	 * Remove upvote for given revision made by current user
	 *
	 * @requestParam int upvote id
	 * @requestParam int user id who made an edit
	 *
	 * @throws MissingParameterApiException
	 * @throws BadRequestApiException
	 */
	public function removeUpvote() {
		$request = $this->getRequest();
		$user = $this->wg->User;

		if ( !$user->isLoggedIn() ) {
			throw new UnauthorizedException();
		}
		$this->checkWriteRequest();

		$id = $request->getInt( 'id' );
		if ( empty( $id ) ) {
			throw new MissingParameterApiException( 'id' );
		}

		$userId = $request->getInt( 'userId' );

		$removed = ( new RevisionUpvotesService() )->removeUpvote( $id, $user->getId(), $userId );

		$this->setResponseData( [
			'success' => (bool) $removed
		] );
	}

	/**
	 * Get data about all upvotes for given revision
	 *
	 * @requestParam int revision id
	 *
	 * @throws MissingParameterApiException
	 */
	public function getRevisionUpvotes() {
		$revisionId = $this->getRequest()->getInt( 'revisionId' );
		if ( empty( $revisionId ) ) {
			throw new MissingParameterApiException( 'revisionId' );
		}

		$upvote = ( new RevisionUpvotesService() )->getRevisionUpvotes( $this->wg->CityId, $revisionId );

		$this->setResponseData( $upvote );
	}

	/**
	 * Get data about all upvotes for many revisions
	 *
	 * @requestParam string revisionsIds ids separated by comma
	 *
	 * @throws MissingParameterApiException
	 */
	public function getRevisionsUpvotes() {
		$revisionsIds = $this->getRequest()->getArray( 'revisionsIds' );
		if ( empty( $revisionsIds ) ) {
			throw new MissingParameterApiException( 'revisionsIds' );
		}

		$upvotes = ( new RevisionUpvotesService() )->getRevisionsUpvotes( $this->wg->CityId, $revisionsIds );

		$this->setResponseData( $upvotes );
	}

	public function setUserNotified() {
		$user = $this->wg->User;

		if ( !$user->isLoggedIn() ) {
			throw new UnauthorizedException();
		}
		$this->checkWriteRequest();

		( new RevisionUpvotesService() )->setUserNotified( $user->getId() );
	}
}
