<?php

namespace Wikia\FeedsAndPosts\Discussion;

use FatalError;
use Hooks;
use MWException;
use PostBuilder;
use User;

class PermissionsHelper {
	/**
	 * @param array $userIds
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function getBadgesMap( array $userIds ): array {
		$badges = [];
		Hooks::run( 'BadgePermissionsRequired', [ $userIds, &$badges ] );
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
