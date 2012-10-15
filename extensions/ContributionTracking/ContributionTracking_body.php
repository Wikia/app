<?php

class ContributionTracking extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'ContributionTracking' );
	}

	function execute( $language ) {
		global $wgRequest, $wgOut, $wgContributionTrackingReturnToURLDefault;

		if ( !preg_match( '/^[a-z-]+$/', $language ) ) {
			$language = 'en';
		}
		$this->lang = Language::factory( $language );

		$this->setHeaders();

		$wgOut->setPageTitle('');

		$gateway = $wgRequest->getText( 'gateway' );
		if ( !in_array( $gateway, array( 'paypal', 'moneybookers' ) ) ) {
			$wgOut->showErrorPage( 'contrib-tracking-error', 'contrib-tracking-error-text' );
			return;
		}

		// Store the contribution data
		if ( $wgRequest->getVal( 'contribution_tracking_id' ) ) {
			$contribution_tracking_id = $wgRequest->getVal( 'contribution_tracking_id', 0 );
		} else {
			$tracked_contribution = array(
				'note' => $wgRequest->getVal( 'comment' ),
				'referrer' => $wgRequest->getVal( 'referrer' ),
				'anonymous' => $wgRequest->getCheck( 'comment-option', false ) ? false : true, //yup: 'anonymous' = !comment-option
				'utm_source' => $wgRequest->getVal( 'utm_source' ),
				'utm_medium' => $wgRequest->getVal( 'utm_medium' ),
				'utm_campaign' => $wgRequest->getVal( 'utm_campaign' ),
				'optout' => $wgRequest->getCheck( 'email-opt', false ) ? false : true, //Also: 'optout' = !email-opt.
				'language' => $wgRequest->getVal( 'language' ),
				'owa_session' => $wgRequest->getVal( 'owa_session' ),
				'owa_ref' => $wgRequest->getVal( 'owa_ref', null ),
				//'ts' => $ts,
			);
			$contribution_tracking_id = ContributionTrackingProcessor::saveNewContribution( $tracked_contribution );
		}

		$params = array(
			'gateway' => $gateway,
			'tshirt' => $wgRequest->getVal( 'tshirt' ),
			'return' => $wgRequest->getText( 'returnto', "Donate-thanks/$language" ),
			'currency_code' => $wgRequest->getText( 'currency_code', 'USD' ),
			'fname' => $wgRequest->getText( 'fname', null ),
			'lname' => $wgRequest->getText( 'lname', null ),
			'email' => $wgRequest->getText( 'email', null ),
			'address1' => $wgRequest->getText( 'address1', null ),
			'city' => $wgRequest->getText( 'city', null ),			
			'state' => $wgRequest->getText( 'state', null ),
			'zip' => $wgRequest->getText( 'zip', null ),
			'country' => $wgRequest->getText( 'country', null ),
			'address_override' => $wgRequest->getText( 'address_override', '0' ),
			'recurring_paypal' => $wgRequest->getText( 'recurring_paypal' ),
			'amount' => $wgRequest->getVal( 'amount' ),
			'amount_given' => $wgRequest->getVal( 'amountGiven' ),
			'contribution_tracking_id' => $contribution_tracking_id,
			'language' => $language,
		);

		if ( $params['tshirt'] ) {
			$params['size'] = $wgRequest->getText( 'size' );
			$params['premium_language'] = $wgRequest->getText( 'premium_language' );
		}

		foreach ( $params as $key => $value ) {
			if ( $value === "" || $value === null ) {
				unset( $params[$key] );
			}
		}

		$repost = ContributionTrackingProcessor::getRepostFields( $params );

		#$wgOut->addWikiText( "{{2009/Donate-banner/$language}}" );
		$wgOut->addHTML( $this->msgWiki( 'contrib-tracking-submitting' ) );

		// Output the repost form
		$output = '<form method="post" name="contributiontracking" action="' . $repost['action'] . '">';

		foreach ( $repost['fields'] as $key => $value ) {
			$output .= '<input type="hidden" name="' . htmlspecialchars( $key ) . '" value="' . htmlspecialchars( $value ) . '" />';
		}

		$output .= $this->msgWiki( 'contrib-tracking-redirect' );

		// Offer a button to post the form if the user has no Javascript support
		$output .= '<noscript>';
		$output .= $this->msgWiki( 'contrib-tracking-continue' );
		$output .= '<input type="submit" value="' . $this->msg( 'contrib-tracking-button' ) . '" />';
		$output .= '</noscript>';

		$output .= '</form>';

		$wgOut->addHTML( $output );

		// Automatically post the form if the user has Javascript support
		$wgOut->addHTML( '<script type="text/javascript">document.contributiontracking.submit();</script>' );
	}

	function msg() {
		return wfMsgExt( func_get_arg( 0 ), array( 'escape', 'language' => $this->lang ) );
	}

	function msgWiki( $key ) {
		return wfMsgExt( $key, array( 'parse', 'language' => $this->lang ) );
	}

}
