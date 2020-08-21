<?php

use Wikia\Factory\ServiceFactory;

/**
 * Controller to fetch information about users
 *
 * @author adam
 */

class UserApiController extends WikiaApiController {

	const AVATAR_DEFAULT_SIZE = 100;
	const USER_LIMIT = 100;

	const USER_QUERY_BY_NAME_MAX_LENGTH = 255;
	const USER_QUERY_BY_NAME_DEFAULT_LIMIT = 6;
	const USER_QUERY_BY_NAME_MAX_LIMIT = 20;

	/**
	 * Get details about one or more user
	 *
	 * @requestParam string $ids A string with a comma-separated list of user ID's, limit for query equals 100
	 * @requestParam integer $size [OPTIONAL] The desired width and height for the thumbnail, defaults to 100, 0 for no thumbnail
	 *
	 * @responseParam array $items A list of results with the user ID as the index, each item has a title, name, url, avatar, numberofedits
	 * @responseParam string $basepath domain of a wiki to create a url for an user
	 *
	 * @example &ids=123&size=150
	 */
	public function getDetails() {
		wfProfileIn( __METHOD__ );
		$ids =  $this->request->getVal( 'ids' );

		if ( empty( $ids ) ) {
			wfProfileOut( __METHOD__ );
			throw new InvalidParameterApiException( 'ids' );
		}

		$ids = explode( ',', trim( $ids ) );
		$size = $this->request->getInt( 'size', static::AVATAR_DEFAULT_SIZE );

		//limit number of users
		$ids = array_slice( $ids, 0, static::USER_LIMIT );
		//users are cached inside the service
		$users = (new UserService())->getUsers( $ids );

		$items = array();

		$currentUser = $this->getContext()->getUser();

		foreach ( $users as $user ) {
			$userName = $user->getName();

			$item = array(
				'user_id' => $user->getId(),
				'title' => $user->getTitleKey(),
				'name' => $userName,
				'url' => AvatarService::getUrl( $userName ),
				'numberofedits' => (int) $user->getEditCount(),
				'is_subject_to_ccpa' => (
					$currentUser->equals( $user ) ? $currentUser->isSubjectToCcpa() : null
				),
			);

			//add avatar url if size !== 0
			if ( $size > 0 ) {
				$item[ 'avatar' ] = AvatarService::getAvatarUrl( $user, $size );
			}

			$items[] = $item;
		}

		if ( !empty( $items ) ) {

			$this->setResponseData(
				[ 'basepath' => $this->wg->Server, 'items' => $items ],
				[ 'imgFields'=> 'avatar', 'urlFields' => [ 'avatar', 'url' ] ],
				WikiaResponse::CACHE_STANDARD
			);

		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException();
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * IW-2298: Query for user names matching a given prefix in a case-insensitive manner.
	 *
	 * @throws DBQueryError
	 * @throws InvalidParameterApiException
	 * @throws MWException
	 */
	public function getUsersByName(): void {
		global $wgExternalSharedDB;

		$query = $this->request->getVal( 'query' );
		$limitFromQuery = $this->request->getInt( 'limit', self::USER_QUERY_BY_NAME_DEFAULT_LIMIT );
		$limit = max( 1, min( self::USER_QUERY_BY_NAME_MAX_LIMIT, $limitFromQuery ) );

		if ( empty( $query ) || mb_strlen( $query ) > self::USER_QUERY_BY_NAME_MAX_LENGTH ) {
			throw new InvalidParameterApiException( 'query' );
		}

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		// We use Latin-1 encoding to connect to our databases, but the column we're querying here uses the utf8mb4 charset.
		// Override the client character set to avoid encoding issues
		$dbr->query( 'SET NAMES utf8mb4' );

		$res = $dbr->select(
			'user',
			[ 'user_id', 'user_name_normalized' ],
			[ 'user_name_normalized ' . $dbr->buildLike( mb_strtolower( $query ), $dbr->anyString() ) ],
			__METHOD__,
			[ 'LIMIT' => $limit ]
		);

		$users = [];
		$userIds = [];

		foreach ( $res as $row ) {
			$users[] = [
				'id' => $row->user_id,
				'name' => $row->user_name_normalized,
			];
			$userIds[] = (int)$row->user_id;
		}

		if ( count( $userIds ) > 0 ) {
			$avatars = $this->getAvatars( $userIds );

			$users = array_map( function ( $user ) use ( $avatars ) {
				$user['avatarUrl'] = $avatars[(int)$user['id']];
				return $user;
			}, $users );
		}

		$this->response->setData( [ 'users' => $users ] );
	}

	private function getAvatars( array $userIds ): array {
		$userAttributeService = ServiceFactory::instance()->attributesFactory()->userAttributeGateway();
		$attributesForUsers = $userAttributeService->getAllAttributesForMultipleUsers( $userIds )['users'];

		$result = [];
		foreach ( $userIds as $id ) {
			$result[$id] = $attributesForUsers[$id]['avatar'] ?? null;
		}

		return $result;
	}
}
