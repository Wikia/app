<?php

/**
 * This API will allow for the elimination of the interstitial page defined in
 * ContributionTracking_body.php. Instead of posting contribution data to that
 * page, a request to ApiContributionTracking will save contribution tracking
 * data locally and prepare a set of data to be immediately reposted to the
 * gateway by the original calling page. The ajax side of this is handled by
 * jquery.contributionTracking.js.
 * For a working example of the whole process, see
 * ContributionTracking_Tester.php (must be sysop for permission).
 * @author Katie Horn <khorn@wikimedia.org>
 */
class ApiContributionTracking extends ApiBase {

	public function execute( $params = null ) {
		if ( $params === null ) {
			$params = $this->extractRequestParams();
		}
		$params = $this->getStagedParams( $params );
		$contribution_tracking_id = ContributionTrackingProcessor::saveNewContribution( $params );
		$this->doReturn( $contribution_tracking_id, $params );
	}

	/**
	 * Stages incoming request parameters for the ContributionTrackingProcessor
	 * @param array $params Incoming request parameters
	 * @return array Paramaters ready to be sent off to the processor.
	 */
	function getStagedParams( $params = null ) {

		foreach ( $params as $key => $value ) {
			if ( $value == '' ) {
				if ( $key === 'comment-option' || $key === 'email-opt' ) {
					$params[$key] = false;
				} else {
					unset( $params[$key] ); //gotcha. And might I add: BOO-URNS.
				}
			}
		}
		return $params;
	}

	/**
	 * Assembles the data for the API to return.
	 * @param integer $id The Contribution Tracking ID.
	 * @param array $params Original (staged) request paramaters.
	 */
	function doReturn( $id, $params ) {
//		foreach ($params as $key=>$value){
//			if ($value != ''){
//				$this->getResult()->addValue(array('returns', 'parrot'), $key, $value);
//			}
//		}
		$params['contribution_tracking_id'] = $id;

		$repost = ContributionTrackingProcessor::getRepostFields( $params );

		$this->getResult()->addValue( array( 'returns', 'action' ), 'url', $repost['action'] );
		foreach ( $repost['fields'] as $key => $value ) {
			$this->getResult()->addValue( array( 'returns', 'fields' ), $key, $value );
		}
	}

	/**
	 *
	 * @return array An array of parameters allowed by ApiContributionTracking
	 */
	public function getAllowedParams() {
		return array(
			'amount' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'referrer' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'gateway' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'comment' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'comment-option' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'utm_source' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'utm_medium' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'utm_campaign' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'email-opt' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'language' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'owa_session' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'owa_ref' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'contribution_tracking_id' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'returnto' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'tshirt' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'size' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'premium_language' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'currency_code' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'fname' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'lname' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'email' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'recurring_paypal' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
			'amountGiven' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'amount' => 'Transaction amount (required)',
			'referrer' => 'String identifying the referring entity (required)',
			'gateway' => array(
				'String identifying the specific entity used to process this payment. ',
				'Probably "paypal". (required)' ),
			'comment' => 'String with a comment. Actually saved as "note" in the database',
			'comment-option' => 'Boolean assumed to be from a checkbox. This is actually the inverse of the anonymous flag.',
			'utm_source' => 'String identifying "utm_source"',
			'utm_medium' => 'String identifying "utm_medium"',
			'utm_campaign' => 'String identifying "utm_campaign"',
			'email-opt' => 'Boolean assumed to be from a checkbox. This is actually the inverse of the E-mail opt-out checkbox.',
			'language' => array(
				'User language code. Messages will be translated appropriately (where possible).',
				'This will also determine what "Thank You" page the user sees upon completion of a donation at the gateway.' ),
			'owa_session' => 'String identifying the "owa_session"',
			'owa_ref' => 'String with the referring URL.',
			'contribution_tracking_id' => 'Our ID for the current contribution. Not supplied for new contributions.', //in fact, why is this here?
			'returnto' => 'String identifying an alternate "Thank You" page to show the user on completion of their transaction.',
			'tshirt' => 'Boolean indicating whether or not there is a t-shirt involved.',
			'size' => 'String indicating the desired size of the above t-shirt (if involved)',
			'premium_language' => 'Language code for the shirt. This will have no effect on message translation outside of the physical scope of the shirt.',
			'currency_code' => 'Currency code for the current transaction.',
			'fname' => "String: Donor's first name",
			'lname' => "String: Donor's last name",
			'email' => "String: Donor's email",
			'recurring_paypal' => 'Boolean identifying a recurring donation. Do not supply at all for a one-time donation.',
			'amountGiven' => 'Normalized amount.'
		);
	}

	public function getDescription() {
		return array(
			'Track donor contributions via API',
			'This API exists so we are able to eliminate the interstitial page',
			'that would otherwise be used to track contributions before sending',
			'the donor off to paypal (or wherever).',
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=contributiontracking&comment=examplecomment&referrer=examplereferrer&gateway=paypal&amount=5.50',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiContributionTracking.php 94744 2011-08-17 11:41:58Z reedy $';
	}

}
