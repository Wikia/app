<?php

class CommunityPageSpecialModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const TOP_CONTRIB_DETAILS_MCACHE_KEY = 'community_page_top_contrib_details'; // todo not used
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';

	private $wikiService;

	private function getWikiService() {
		return $this->wikiService;
	}

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	public function getTopContributorsRaw() {
		$data = WikiaDataAccess::cache( wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY ), WikiaResponse::CACHE_STANDARD, function () {
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

	public static function getFirstRevision( User $user ) {
		if ( $user->isAnon() ) {
			return null;
		}

		$data = WikiaDataAccess::cache(
			wfMemcKey( self::FIRST_REV_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () use ($user) {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'rev_timestamp' )
					->FROM ( 'revision' )
					->WHERE ( 'rev_user' )->EQUAL_TO( $user->getID() )
					->LIMIT( 1 )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$out[] = [
								'rev_timestamp' => $row['rev_timestamp']
							];
						}

						return $out;
					} );

				return $sqlData;
			}
		);

		return $data;
	}
}
