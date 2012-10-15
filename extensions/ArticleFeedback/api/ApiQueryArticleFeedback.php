<?php
class ApiQueryArticleFeedback extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'af' );
	}

	public function execute() {
		global $wgArticleFeedbackRatingTypes;
		
		$params = $this->extractRequestParams();
		$result = $this->getResult();
		$revisionLimit = $this->getRevisionLimit( $params['pageid'] );
		
		$this->addTables( array( 'article_feedback_revisions' ) );
		$this->addFields( array(
			'MAX(afr_revision) as afr_revision',
			'SUM(afr_total) as afr_total',
			'SUM(afr_count) as afr_count',
			'afr_rating_id',
		) );
		$this->addWhereFld( 'afr_page_id', $params['pageid'] );
		$this->addWhere( 'afr_revision >= ' . $revisionLimit );
		$this->addWhereFld( 'afr_rating_id', array_keys( $wgArticleFeedbackRatingTypes ) );
		$this->addOption( 'GROUP BY', 'afr_rating_id' );
		$this->addOption( 'LIMIT', count( $wgArticleFeedbackRatingTypes ) );

		// Rating counts and totals
		$res = $this->select( __METHOD__ );
		$ratings = array( $params['pageid'] => array( 'pageid' => $params['pageid'] ) );
		$historicCounts = $this->getHistoricCounts( $params );
		foreach ( $res as $i => $row ) {
			if ( !isset( $ratings[$params['pageid']]['revid'] ) ) {
				$ratings[$params['pageid']]['revid'] = (int) $row->afr_revision;
			}
			if ( !isset( $ratings[$params['pageid']]['ratings'] ) ) {
				$ratings[$params['pageid']]['ratings'] = array();
			}
			$ratings[$params['pageid']]['ratings'][] = array(
				'ratingid' => (int) $row->afr_rating_id,
				'ratingdesc' => $wgArticleFeedbackRatingTypes[$row->afr_rating_id],
				'total' => (int) $row->afr_total,
				'count' => (int) $row->afr_count,
				'countall' => isset( $historicCounts[$row->afr_rating_id] )
					? (int) $historicCounts[$row->afr_rating_id] : 0
			);
		}

		// User-specific data
		$ratings[$params['pageid']]['status'] = 'current';
		if ( $params['userrating'] ) {
			// User ratings
			$userRatings = $this->getUserRatings( $params );

			// If valid ratings already exist..
			if ( isset( $ratings[$params['pageid']]['ratings'] ) ) {
				foreach ( $ratings[$params['pageid']]['ratings'] as $i => $rating ) {
					if ( isset( $userRatings[$rating['ratingid']] ) ) {
						// Rating value
						$ratings[$params['pageid']]['ratings'][$i]['userrating'] =
							(int) $userRatings[$rating['ratingid']]['value'];
						// Expiration
						if ( $userRatings[$rating['ratingid']]['revision'] < $revisionLimit ) {
							$ratings[$params['pageid']]['status'] = 'expired';
						}
					}
				}

			// Else, no valid ratings exist..
			} else {

				if ( count( $userRatings ) ) {
					$ratings[$params['pageid']]['status'] = 'expired';
				}

				foreach ( $userRatings as $ratingId => $userRating ) {
					// Revision
					if ( !isset( $ratings[$params['pageid']]['revid'] ) ) {
						$ratings[$params['pageid']]['revid'] = (int) $userRating['revision'];
					}
					// Ratings
					if ( !isset( $ratings[$params['pageid']]['ratings'] ) ) {
						$ratings[$params['pageid']]['ratings'] = array();
					}
					// Rating value
					$ratings[$params['pageid']]['ratings'][] = array(
						'ratingid' => $ratingId,
						'ratingdesc' => $userRating['text'],
						'total' => 0,
						'count' => 0,
						'countall' => isset( $historicCounts[$row->afr_rating_id] )
							? (int) $historicCounts[$row->afr_rating_id] : 0,
						'userrating' => (int) $userRating['value'],
					);
				}
			}

			// Expertise
			if ( isset( $ratings[$params['pageid']]['revid'] ) ) {
				$expertise = $this->getExpertise( $params, $ratings[$params['pageid']]['revid'] );
				if ( $expertise !== false ) {
					$ratings[$params['pageid']]['expertise'] = $expertise;
				}
			}
		}

		foreach ( $ratings as $rat ) {
			if ( isset( $rat['ratings'] ) ) {
				$result->setIndexedTagName( $rat['ratings'], 'r' );
			}
			
			$result->addValue( array( 'query', $this->getModuleName() ), null, $rat );
		}
		
		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'aa' );
	}

	protected function getHistoricCounts( $params ) {
		global $wgArticleFeedbackRatingTypes;
		
		$res = $this->getDB()->select(
			'article_feedback_pages',
			array(
				'aap_rating_id',
				'aap_count',
			),
			array(
				'aap_page_id' => $params['pageid'],
				'aap_rating_id' => array_keys( $wgArticleFeedbackRatingTypes ),
			),
			__METHOD__
		);
		$counts = array();
		foreach ( $res as $row ) {
			$counts[$row->aap_rating_id] = $row->aap_count;
		}
		return $counts;
	}

	protected function getAnonToken( $params ) {
		global $wgUser;
		$token = '';
		if ( $wgUser->isAnon() && $params['userrating'] ) {
			if ( !isset( $params['anontoken'] ) ) {
				$this->dieUsageMsg( array( 'missingparam', 'anontoken' ) );
			} elseif ( strlen( $params['anontoken'] ) != 32 ) {
				$this->dieUsage( 'The anontoken is not 32 characters', 'invalidtoken' );
			}
			$token = $params['anontoken'];
		}
		return $token;
	}
	
	protected function getExpertise( $params, $revid ) {
		global $wgUser;
		
		return $this->getDB()->selectField(
			'article_feedback_properties',
			'afp_value_text',
			array(
				'afp_key' => 'expertise',
				'afp_user_text' => $wgUser->getName(),
				'afp_user_anon_token' => $this->getAnonToken( $params ),
				'afp_revision' => $revid,
			),
			__METHOD__
		);
	}
	
	protected function getUserRatings( $params ) {
		global $wgUser, $wgArticleFeedbackRatingTypes;

		$res = $this->getDB()->select(
			array( 'article_feedback' ),
			array(
				'aa_rating_id',
				'aa_revision',
				'aa_rating_value',
			),
			array(
				'aa_page_id' => $params['pageid'],
				'aa_rating_id' => array_keys( $wgArticleFeedbackRatingTypes ),
				'aa_user_text' => $wgUser->getName(),
				'aa_user_anon_token' => $this->getAnonToken( $params ),
			),
			__METHOD__,
			array(
				'LIMIT' => count( $wgArticleFeedbackRatingTypes ),
				'ORDER BY' => 'aa_revision DESC',
			)
		);
		$ratings = array();
		$revId = null;
		foreach ( $res as $row ) {
			if ( $revId === null ) {
				$revId = $row->aa_revision;
			}
			// Prevent incomplete rating sets from making a mess
			if ( $revId === $row->aa_revision ) {
				$ratings[$row->aa_rating_id] = array(
					'value' => $row->aa_rating_value,
					'revision' => $row->aa_revision,
					'text' => $wgArticleFeedbackRatingTypes[$row->aa_rating_id],
				);
			}
		}
		return $ratings;
	}

	/**
	 * Get the revision number of the oldest revision still being counted in totals.
	 * 
	 * @param $pageId Integer: ID of page to check revisions for
	 * @return Integer: Oldest valid revision number or 0 of all revisions are valid
	 */
	protected function getRevisionLimit( $pageId ) {
		global $wgArticleFeedbackRatingLifetime;

		$revision = $this->getDB()->selectField(
			'revision',
			'rev_id',
			array( 'rev_page' => $pageId ),
			__METHOD__,
			array(
				'ORDER BY' => 'rev_id DESC',
				'LIMIT' => 1,
				'OFFSET' => $wgArticleFeedbackRatingLifetime - 1
			)
		);
		if ( $revision ) {
			return intval( $revision );
		}
		return 0;
	}
	
	public function getCacheMode( $params ) {
		if ( $params['userrating'] ) {
			return 'anon-public-user-private';
		} else {
			return 'public';
		}
	}

	public function getAllowedParams() {
		return array(
			'pageid' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => 'integer',
			),
			'userrating' => 0,
			'anontoken' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'pageid' => 'Page ID to get feedback ratings for',
			'userrating' => "Whether to get the current user's ratings for the specified page",
			'anontoken' => 'Token for anonymous users',
		);
	}

	public function getDescription() {
		return array(
			'List article feedback ratings for a specified page'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
				array( 'missingparam', 'anontoken' ),
				array( 'code' => 'invalidtoken', 'info' => 'The anontoken is not 32 characters' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=articlefeedback&afpageid=1',
			'api.php?action=query&list=articlefeedback&afpageid=1&afuserrating=1',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryArticleFeedback.php 110962 2012-02-08 20:52:22Z catrope $';
	}
}