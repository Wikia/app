<?php

class StatsGetter extends WikiaModel {

	const STATS_HEADERS = [ 'user', 'total reviewed', 'approved', 'deleted', 'qustionable', 'distance to avg.' ];
	const STATS_PAGE_HEADER = 'Image Review tool statistics';

	public function getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay ) {


		$startDate = $startYear . '-' . $startMonth . '-' . $startDay . ' 00:00:00';
		$endDate = $endYear . '-' . $endMonth . '-' . $endDay . ' 23:59:59';

		$summary = array(
			'all' => 0,
			ImageReviewStatuses::STATE_APPROVED 	=> 0,
			ImageReviewStatuses::STATE_REJECTED 	=> 0,
			ImageReviewStatuses::STATE_QUESTIONABLE => 0,
			'avg' => 0,
		);
		$data = [];
		$total = $avg = 0;

		$dbr = $this->getDatawareDB( DB_SLAVE );
		$reviewers = $this->getReviewersForStats();

		$count_users = count( $reviewers );
		if ( $count_users > 0 ) {
			foreach ( $reviewers as $reviewer ) {
				# user
				$user = User::newFromId( $reviewer );
				if ( !is_object( $user ) ) {
					// invalid user id?
					continue;
				}

				$query = array();
				foreach ( array_keys( $summary ) as $review_state ) {
					# union query: mysql explain: Using where; Using index and max 150k rows
					$query[] = $dbr->selectSQLText(
						array( 'image_review_stats' ),
						array( 'review_state', 'count(*) as cnt' ),
						array(
							"review_state"	=> $review_state,
							"reviewer_id"	=> $reviewer,
							"review_end between '{$startDate}' AND '{$endDate}'"
						),
						__METHOD__
					);
				}

				# Join the two fast queries, and sort the result set
				$sql = $dbr->unionQueries( $query, false );
				$res = $dbr->query( $sql, __METHOD__ );

				while ( $row = $dbr->fetchObject( $res ) ) {
					if ( !empty( $row->review_state ) ) {
						if ( !isset( $data[ $reviewer ] ) ) {
							$data[ $reviewer ] = array(
								'name' => $user->getName(),
								'total' => 0,
								ImageReviewStatuses::STATE_APPROVED => 0,
								ImageReviewStatuses::STATE_REJECTED => 0,
								ImageReviewStatuses::STATE_QUESTIONABLE => 0,
							);
						}
						$data[ $reviewer ][ $row->review_state ] = $row->cnt;
						$data[ $reviewer ][ 'total' ] += $row->cnt;

						# total
						$total += $row->cnt;

						# index in summary
						$summary[ $row->review_state ] += $row->cnt;
					}
				}

			}
		}
		$activeReviewers = count( $data );

		$summary[ 'all' ] = $total;
		$summary[ 'avg' ] = $activeReviewers > 0 ? $summary['all'] / $activeReviewers : 0;

		foreach ( $data as &$stats ) {
			$stats['toavg'] = $stats['total'] - $summary['avg'];
		}

		return array(
			'summary' => $summary,
			'data' => $data,
		);
	}

	private function getReviewersForStats() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'ImageReviewSpecialController', 'v2', __METHOD__);
		$reviewers = $this->wg->memc->get($key);
		if ( empty($reviewers) ) {
			$reviewers = array();
			$db = $this->getDatawareDB( DB_SLAVE );

			# MySQL explain: Using where; Using index for group-by
			$result = $db->select(
				array( 'image_review_stats' ),
				array( 'reviewer_id' ),
				array( 'reviewer_id > 0' ),
				__METHOD__,
				array( 'GROUP BY' => 'reviewer_id' )
			);

			while( $row = $db->fetchObject($result) ) {
				$reviewers[] = $row->reviewer_id;
			}
			$this->wg->memc->set( $key, $reviewers, 60 * 60 * 8 );
		}

		wfProfileOut( __METHOD__ );
		return $reviewers;
	}
	
	public function csvStats( WikiaRequest $request ) {
		// TODO implement this
//		if ( !$this->wg->User->isAllowed( self::VIEW_STATS_PERM ) ) {
//			$this->specialPage->displayRestrictionError( self::VIEW_STATS_PERM );
//			return false;
//		}

		$startDay = $request->getVal( 'startDay', date( 'd' ) );
		$startMonth = $request->getVal( 'startMonth', date( 'n' ) );
		$startYear = $request->getVal( 'startYear', date( 'Y' ) );

		$endDay = $request->getVal( 'endDay', date( 'd' ) );
		$endMonth = $request->getVal( 'endMonth', date( 'm' ) );
		$endYear = $request->getVal( 'endYear', date( 'Y' ) );

		$this->wg->Out->setPageTitle( self::STATS_PAGE_HEADER );
		$stats = $this->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );

		$name = "ImageReviewStats-$startYear-$startMonth-$startDay-to-$endYear-$endMonth-$endDay";

		header( "Pragma: public" );
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header( 'Content-Type: text/force-download' );

		header( 'Content-Disposition: attachment; filename="' . $name . '.csv"' );

		echo implode( ",", self::STATS_HEADERS ) . "\n";

		foreach ( $stats['data'] as $dataRow ) {
			echo implode( ",", $dataRow ) . "\n";
		}

		exit;
	}
}
