<?php
/**
 * Controller to fetch information about users
 *
 * @author adam
 */

class UserApiController extends WikiaApiController {

	const AVATAR_DEFAULT_SIZE = 100;
	const USER_LIMIT = 100;

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

		foreach ( $users as $user ) {
			$userName = $user->getName();
			$powerUserTypes = ( new \Wikia\PowerUser\PowerUser( $user ) )->getTypesForUser();

			$item = array(
				'user_id' => $user->getId(),
				'title' => $user->getTitleKey(),
				'name' => $userName,
				'url' => AvatarService::getUrl( $userName ),
				'numberofedits' => (int) $user->getEditCountLocal()
			);

			if ( !empty( $powerUserTypes ) ) {
				$item['poweruser_types'] = $powerUserTypes;
			}

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
}
