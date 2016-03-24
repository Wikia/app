<?php

//select user_id, sum(creates + edits + deletes + undeletes) as contr from rollup_wiki_namespace_user_events where period_id = 1 and  time_id <= now()  and time_id > DATE_SUB(now(), INTERVAL 6 YEAR) GROUP BY user_id  ORDER BY contr desc LIMIT 10 ;


class CommunityPageSpecialModel {
	const MCACHE_KEY = 'communitypage';

	public function getTopContributorsRaw() {
		$data = WikiaDataAccess::cache( wfMemcKey( self::MCACHE_KEY ), WikiaResponse::CACHE_STANDARD, function () {
			global $wgDatamartDB;
			$db = wfGetDB( DB_SLAVE, [], $wgDatamartDB );

			$sqlData = ( new WikiaSQL() )
				->SELECT( 'user_id, sum(creates + edits + deletes + undeletes) as contributions' )
				->FROM ( 'rollup_wiki_namespace_user_events' )
				->WHERE ( 'period_id' )->EQUAL_TO( 1 )
				->AND_( 'time_id' )->LESS_THAN_OR_EQUAL( 'now()' )
				->AND_( 'time_id > DATE_SUB(now(), INTERVAL 6 YEAR)' )
				->GROUP_BY( 'user_id' )
				->ORDER_BY( 'contributions' )->DESC()
				->LIMIT( 10 )
				->run( $db, function ( ResultWrapper $result ) {
					$out = [];
					while ($row = $result->fetchRow()) {
						$out[] = [
							'userId' => $row['user_id'],
							'contributions' => $row['contributions']
						];
					}

					return $out;
				} );

			return $sqlData;
		} );
		return $data;
	}

	public function getTopContributorsDetails() {
		$contributors = $this->getTopContributorsRaw();

		return array_map( function ( $contributor ) {
			$user = User::newFromId( $contributor['userId'] );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );

			return [
				'userName' => $userName,
				'avatar' => $avatar,
				'contributions' => $contributor['contributions'],
				'profilePage' => $user->getUserPage()->getLocalURL()
			];
		}, $contributors );
	}
}
