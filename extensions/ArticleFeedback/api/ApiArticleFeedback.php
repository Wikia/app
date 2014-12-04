<?php
class ApiArticleFeedback extends ApiBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, '' );
	}

	public function execute() {
		global $wgUser, $wgArticleFeedbackRatingTypes, $wgArticleFeedbackSMaxage,
			$wgArticleFeedbackNamespaces;
		$params = $this->extractRequestParams();

		// Anon token check
		if ( $wgUser->isAnon() ) {
			if ( !isset( $params['anontoken'] ) ) {
				$this->dieUsageMsg( array( 'missingparam', 'anontoken' ) );
			} elseif ( strlen( $params['anontoken'] ) != 32 ) {
				$this->dieUsage( 'The anontoken is not 32 characters', 'invalidtoken' );
			}

			$token = $params['anontoken'];
		} else {
			$token = '';
		}

		// Load check, is this page ArticleFeedback-enabled ?
		// Keep in sync with ext.articleFeedback.startup.js
		$title = Title::newFromID( $params['pageid'] );
		if (
			// Inexisting page ? (newFromID returns null so we can't use $title->exists)
			is_null( $title )
			// Namespace not a valid ArticleFeedback namespace ?
			|| !in_array( $title->getNamespace(), $wgArticleFeedbackNamespaces )
			// Page a redirect ?
			|| $title->isRedirect()
		) {
				// ...then error out
				$this->dieUsage( 'ArticleFeedback is not enabled on this page', 'invalidpage' );
		}

		$dbw = wfGetDB( DB_MASTER );

		// Query the latest ratings by this user for this page,
		// possibly for an older revision
		// Select from the master to prevent replag-induced bugs
		$res = $dbw->select(
			'article_feedback',
			array( 'aa_rating_id', 'aa_rating_value', 'aa_revision' ),
			array(
				'aa_user_text' => $wgUser->getName(),
				'aa_page_id' => $params['pageid'],
				'aa_rating_id' => array_keys( $wgArticleFeedbackRatingTypes ),
				'aa_user_anon_token' => $token,
			),
			__METHOD__,
			array(
				'ORDER BY' => 'aa_revision DESC',
				'LIMIT' => count( $wgArticleFeedbackRatingTypes ),
			)
		);

		$lastRatings = array();

		foreach ( $res as $row ) {
			$lastRatings[$row->aa_rating_id]['value'] = $row->aa_rating_value;
			$lastRatings[$row->aa_rating_id]['revision'] = $row->aa_revision;
		}

		$pageId = $params['pageid'];
		$revisionId = $params['revid'];

		foreach ( $wgArticleFeedbackRatingTypes as $ratingID => $unused ) {
			$lastPageRating = false;
			$lastRevRating = false;
			if ( isset( $lastRatings[$ratingID] ) ) {
				$lastPageRating = intval( $lastRatings[$ratingID]['value'] );
				if ( intval( $lastRatings[$ratingID]['revision'] ) == $revisionId ) {
					$lastRevRating = $lastPageRating;
				}
			}

			$thisRating = false;
			if ( isset( $params["r{$ratingID}"] ) ) {
				$thisRating = intval( $params["r{$ratingID}"] );
			}

			$this->insertRevisionRating( $pageId, $revisionId, $ratingID, $thisRating - $lastRevRating,
					$thisRating, $lastRevRating
			);
			
			$this->insertPageRating( $pageId, $ratingID, $thisRating - $lastPageRating, $thisRating, $lastPageRating );

			$this->insertUserRatings( $pageId, $revisionId, $wgUser, $token, $ratingID, $thisRating, $params['bucket'] );
		}

		$this->insertProperties( $revisionId, $wgUser, $token, $params );

		$squidUpdate = new SquidUpdate( array( wfAppendQuery( wfScript( 'api' ), array(
			'action' => 'query',
			'format' => 'json',
			'list' => 'articlefeedback',
			'afpageid' => $pageId,
			'afanontoken' => '',
			'afuserrating' => 0,
			'maxage' => 0,
			'smaxage' => $wgArticleFeedbackSMaxage
		) ) ) );
		$squidUpdate->doUpdate();

		wfRunHooks( 'ArticleFeedbackChangeRating', array( $params ) );

		$r = array( 'result' => 'Success' );
		$this->getResult()->addValue( null, $this->getModuleName(), $r );
	}
	
	/**
	 * Inserts (or Updates, where appropriate) the aggregate page rating
	 * 
	 * @param $pageId Integer: Page Id
	 * @param $ratingId Integer: Rating Id
	 * @param $updateAddition Integer: Difference between user's last rating (if applicable)
	 * @param $thisRating Integer|Boolean: Value of the Rating
	 * @param $lastRating Integer|Boolean: Value of the last Rating
	 */
	private function insertPageRating( $pageId, $ratingId, $updateAddition, $thisRating, $lastRating ) {
		$dbw = wfGetDB( DB_MASTER );

		// Try to insert a new afp row for this page with zeroes in it
		// Try will silently fail if the row already exists
		$dbw->insert(
			'article_feedback_pages',
			 array(
				'aap_page_id' => $pageId,
				'aap_total' => 0,
				'aap_count' => 0,
				'aap_rating_id' => $ratingId,
			),
			__METHOD__,
			 array( 'IGNORE' )
		);

		// We now know the row exists, so increment it
		$dbw->update(
			'article_feedback_pages',
			array(
				'aap_total = aap_total + ' . $updateAddition,
				'aap_count = aap_count + ' . $this->getCountChange( $lastRating, $thisRating ),
			),
			array(
				'aap_page_id' => $pageId,
				'aap_rating_id' => $ratingId,
			),
			__METHOD__
		);
	}

	/**
	 * Inserts (or Updates, where appropriate) the aggregate revision rating
	 * 
	 * @param $pageId Integer: Page Id
	 * @param $revisionId Integer: Revision Id
	 * @param $ratingId Integer: Rating Id
	 * @param $updateAddition Integer: Difference between user's last rating (if applicable)
	 * @param $thisRating Integer|Boolean: Value of the Rating
	 * @param $lastRating Integer|Boolean: Value of the last Rating
	 */
	private function insertRevisionRating( $pageId, $revisionId, $ratingId, $updateAddition, $thisRating, $lastRating ) {
		$dbw = wfGetDB( DB_MASTER );

		// Try to insert a new "totals" row for this page,rev,rating set
		$dbw->insert(
			'article_feedback_revisions',
			 array(
				'afr_page_id' => $pageId,
				'afr_total' => 0,
				'afr_count' => 0,
				'afr_rating_id' => $ratingId,
			 	'afr_revision' => $revisionId,
			),
			__METHOD__,
			 array( 'IGNORE' )
		);

		// Apply the difference between the previous and new ratings to the current "totals" row
		$dbw->update(
			'article_feedback_revisions',
			array(
				'afr_total = afr_total + ' . $updateAddition,
				'afr_count = afr_count + ' . $this->getCountChange( $lastRating, $thisRating ),
			),
			array(
				'afr_page_id' => $pageId,
				'afr_rating_id' => $ratingId,
				'afr_revision' => $revisionId,
			),
			__METHOD__
		);
	}
	/**
	 * Calculate the difference between the previous rating and this one
	 *    -1 == Rating last time, but abstained this time
	 *     0 == No change in rating count
	 *     1 == No rating last time (or new rating), and now there is
	 */
	protected function getCountChange( $lastRating, $thisRating ) {
		if ( $lastRating === false || $lastRating === 0 ) {
			return $thisRating === 0 ? 0 : 1;
		}
		// Last rating was > 0
		return $thisRating === 0 ? -1 : 0;
	}

	/**
	 * Inserts (or Updates, where appropriate) the users ratings for a specific revision
	 *
	 * @param $pageId Integer: Page Id
	 * @param $revisionId Integer: Revision Id
	 * @param $user User: Current User object
	 * @param $token Array: Token if necessary
	 * @param $ratingId Integer: Rating Id
	 * @param $ratingValue Integer: Value of the Rating
	 * @param $bucket Integer: Which rating widget was the user shown
	 */
	private function insertUserRatings( $pageId, $revisionId, $user, $token, $ratingId, $ratingValue, $bucket ) {
		$dbw = wfGetDB( DB_MASTER );

		$timestamp = $dbw->timestamp();

		$dbw->insert(
			'article_feedback',
			array(
				'aa_page_id' => $pageId,
				'aa_user_id' => $user->getId(),
				'aa_user_text' => $user->getName(),
				'aa_user_anon_token' => $token,
				'aa_revision' => $revisionId,
				'aa_timestamp' => $timestamp,
				'aa_rating_id' => $ratingId,
				'aa_rating_value' => $ratingValue,
				'aa_design_bucket' => $bucket,
			),
			__METHOD__,
			 array( 'IGNORE' )
		);

		if ( !$dbw->affectedRows() ) {
			$dbw->update(
				'article_feedback',
				array(
					'aa_timestamp' => $timestamp,
					'aa_rating_value' => $ratingValue,
				),
				array(
					'aa_page_id' => $pageId,
					'aa_user_text' => $user->getName(),
					'aa_revision' => $revisionId,
					'aa_rating_id' => $ratingId,
					'aa_user_anon_token' => $token,
				),
				__METHOD__
			);
		}
	}

	/**
	 * Inserts or updates properties for a specific rating
	 * @param $revisionId int Revision ID
	 * @param $user User object
	 * @param $token string Anon token or empty string
	 * @param $params array Request parameters
	 */
	private function insertProperties( $revisionId, $user, $token, $params ) {
		// Expertise is given as a list of one or more tags, such as profession, hobby, etc.
		$this->insertProperty( $revisionId, $user, $token, 'expertise', $params['expertise'] );
		// Capture edit counts as of right now for the past 1, 3 and 6 months as well as all time
		// - These time distances match the default configuration for the ClickTracking extension
		if ( $user->isLoggedIn() ) {
			$this->insertProperty(
				$revisionId, $user, $token, 'contribs-lifetime', (integer) $user->getEditCount()
			);
			// Take advantage of the UserDailyContribs extension if it's present
			if ( function_exists( 'getUserEditCountSince' ) ) {
				$now = time();
				$this->insertProperty(
					$revisionId, $user, $token, 'contribs-6-months',
					getUserEditCountSince( $now - ( 60 * 60 * 24 * 365 / 2 ) )
				);
				$this->insertProperty(
					$revisionId, $user, $token, 'contribs-3-months',
					getUserEditCountSince( $now - ( 60 * 60 * 24 * 365 / 4 ) )
				);
				$this->insertProperty(
					$revisionId, $user, $token, 'contribs-1-month',
					getUserEditCountSince( $now - ( 60 * 60 * 24 * 30 ) )
				);
			}
		}
	}

	/**
	 * Inserts or updates a specific property for a specific rating
	 * @param $revisionId int Revision ID
	 * @param $user User object
	 * @param $token string Anon token or empty string
	 * @param $key string Property key
	 * @param $value int Property value
	 */
	private function insertProperty( $revisionId, $user, $token, $key, $value ) {
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->insert( 'article_feedback_properties', array(
				'afp_revision' => $revisionId,
				'afp_user_text' => $user->getName(),
				'afp_user_anon_token' => $token,
				'afp_key' => $key,
				'afp_value' => is_int( $value ) ? $value : null,
				'afp_value_text' => !is_int( $value ) ? strval( $value ) : null,
			),
			__METHOD__,
			array( 'IGNORE' )
		);
		
		if ( !$dbw->affectedRows() ) {
			$dbw->update( 'article_feedback_properties',
				array( 
					'afp_value' => is_int( $value ) ? $value : null,
					'afp_value_text' => !is_int( $value ) ? strval( $value ) : null,
				),
				array(
					'afp_revision' => $revisionId,
					'afp_user_text' => $user->getName(),
					'afp_user_anon_token' => $token,
					'afp_key' => $key,
				), __METHOD__
			);
		}
	}

	public function getAllowedParams() {
		global $wgArticleFeedbackRatingTypes;
		$ret = array(
			'pageid' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
			),
			'revid' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
			),
			'anontoken' => null,
			'bucket' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_MIN => 0
			),
			'expertise' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
		);

		foreach( $wgArticleFeedbackRatingTypes as $ratingID => $unused ) {
			$ret["r{$ratingID}"] = array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_RANGE_ENFORCE => true,
				ApiBase::PARAM_MIN => 0,
				ApiBase::PARAM_MAX => 5,
			);
		}
		return $ret;
	}

	public function getParamDescription() {
		global $wgArticleFeedbackRatingTypes;
		$ret = array(
			'pageid' => 'Page ID to submit feedback for',
			'revid' => 'Revision ID to submit feedback for',
			'anontoken' => 'Token for anonymous users',
			'bucket' => 'Which rating widget was shown to the user',
			'expertise' => 'What kinds of expertise does the user claim to have',
		);
		foreach( $wgArticleFeedbackRatingTypes as $rating => $unused ) {
			$ret["r{$rating}"] = "Rating {$rating}";
		}
		return $ret;
	}

	public function getDescription() {
		return array(
			'Submit article feedback'
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'anontoken' ),
			array( 'code' => 'invalidtoken', 'info' => 'The anontoken is not 32 characters' ),
			array( 'code' => 'invalidpage', 'info' => 'ArticleFeedback is not enabled on this page' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=articlefeedback'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiArticleFeedback.php 110962 2012-02-08 20:52:22Z catrope $';
	}
}
