<?php

//select user_id, sum(creates + edits + deletes + undeletes) as contr from rollup_wiki_namespace_user_events where period_id = 1 and  time_id <= now()  and time_id > DATE_SUB(now(), INTERVAL 6 YEAR) GROUP BY user_id  ORDER BY contr desc LIMIT 10 ;


class CommunityPageSpecialModel {

	public function getTopContributors() {
		global $wgDatamartDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgDatamartDB );

		$data = ( new WikiaSQL() )
			->SELECT( 'user_id, sum(creates + edits + deletes + undeletes) as contributor' )
			->FROM ( 'rollup_wiki_namespace_user_events' )
			->WHERE ( 'period_id = 1 and  time_id <= now()  and time_id > DATE_SUB(now(), INTERVAL 6 YEAR)' )
			->GROUP_BY( 'user_id' )
			->ORDER_BY( 'contributor desc' )
			->LIMIT( 10 )
			->run( $dbr, function ( ResultWrapper $result ) {
				$out = [ ];
				while ( $row = $result->fetchRow() ) {
					$out[] = [
						'user_id' => $row[ 'user_id' ],
						'contributor' => $row[ 'contributor' ]
					];
				}
				return $out;
			} );

		return $data;
	}
}
