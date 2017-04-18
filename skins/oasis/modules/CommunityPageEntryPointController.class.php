<?php

class CommunityPageEntryPointController extends WikiaController {
	public function executeIndex( $params ) {
		Wikia::addAssetsToOutput( 'community_page_entry_point_js' );
		Wikia::addAssetsToOutput( 'community_page_entry_point_scss' );

		$topContributors = ( new CommunityPageSpecialUsersModel() )->getTopContributors();
		$avatars = [];

		if ( is_array( $topContributors ) ) {
			$avatars = array_map( function( $user ) {
				$user = User::newFromId( $user['userId'] );

				return [
					'avatarUrl' => AvatarService::getAvatarUrl( $user->getName(), 30 ),
					'userProfileUrl' => AvatarService::getUrl( $user->getName() ),
					'username' => User::isIp( $user->getName() )
						? wfMessage( 'oasis-anon-user' )->escaped() : $user->getName(),
				];
			}, array_slice( $topContributors, 0, 5) );
		}

		$this->setVal( 'avatars', $avatars );
	}
}
