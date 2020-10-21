<?php

namespace Wikia\FeedsAndPosts\Discussion;

use FatalError;
use Hooks;
use MWException;
use PostBuilder;
use User;
use UserArray;

class PermissionsHelper {
	/**
	 * @param array $userIds
	 * @return array
	 */
	public static function getUsersMap( array $userIds ): array {
		$usersMap = [];
		if ( !empty( $userIds ) ) {
			foreach ( UserArray::newFromIDs( $userIds ) as $user ) {
				$usersMap[$user->getId()] = $user;
			}
		}

		if ( in_array( 0, $userIds ) && !array_key_exists( 0, $usersMap ) ) {
			$usersMap[0] = User::newFromId( 0 );
		}

		return $usersMap;
	}

	/**
	 * @param array $usersMap
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function getBadgesMap( array $usersMap ): array {
		$badges = [];
		foreach ( $usersMap as $user ) {
			$badge = '';
			Hooks::run( 'BadgePermissionsRequired', [ $user, &$badge ] );
			$badges[$user->getId()] = $badge;
		}

		return $badges;
	}

	public static function applyPermissionsForPost( array &$postData, array $threadData, User $user ) {
		if ( !isset( $postData['_embedded']['userData'][0] ) ) {
			// sometimes for anons it is not returned
			return $postData;
		}

		$post = ( new PostBuilder() )
			->position( $postData['position'] ?? 1 )
			->author( isset( $postData['createdBy']['id'] ) && !empty( $postData['createdBy']['id'] )
				? (int)$postData['createdBy']['id'] : 0 )
			->creationDate( $postData['creationDate']['epochSecond'] )
			->isEditable( $postData['isEditable'] )
			->isThreadEditable( $threadData['isEditable'] )
			->build();

		$rights = [];
		Hooks::run( 'UserPermissionsRequired', [ $user, $post, &$rights ] );

		if ( !empty( $rights ) ) {
			$postData['_embedded']['userData'][0]['permissions'] = $rights;
		}

		return $postData;
	}
}
