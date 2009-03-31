<?php

class ContributionTracking extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'ContributionTracking' );
	}

	function execute( $language ) {
		global $wgRequest, $wgOut;
		wfLoadExtensionMessages( 'ContributionTracking' );
		
		if ( !preg_match( '/^[a-z-]+$/', $language ) ) {
			$language = 'en';
		}
		$this->lang = Language::factory( $language );
		wfLoadExtensionMessages( 'ContributionTracking' );
		wfLoadExtensionMessages( 'ContributionTracking', $language );
		
		$this->setHeaders();
		
		$gateway = $wgRequest->getText( 'gateway' );
		if( !$wgRequest->wasPosted() ||
			!in_array( $gateway, array( 'paypal', 'moneybookers' ) ) ) {
			$wgOut->showErrorPage( 'contrib-tracking-error', 'contrib-tracking-error-text' );
			return;
		}
		
		$db = contributionTrackingConnection();
		
		$tracked_contribution = array(
			'note' => $wgRequest->getText('comment', NULL),
			'referrer' => $wgRequest->getText('referrer', NULL),
			'anonymous' => ($wgRequest->getCheck('comment-option', 0) ? 0 : 1),
			'utm_source' => $wgRequest->getText('utm_source', NULL),
			'utm_medium' => $wgRequest->getText('utm_medium', NULL),
			'utm_campaign' => $wgRequest->getText('utm_campaign', NULL),
			'optout' => ($wgRequest->getCheck('email', 0) ? 0 : 1),
			'language' => $wgRequest->getText('language', NULL),
		);
		
		// Make all empty strings NULL
		foreach ($tracked_contribution as $key => $value) {
			if ($value === '') {
				$tracked_contribution[$key] = NULL;
			}
		}
		
		// Store the contribution data
		$db->insert( 'contribution_tracking', $tracked_contribution );
		
		$contribution_tracking_id = $db->insertId();
		
		$returnText = $wgRequest->getText( 'returnto', "Donate-thanks/$language" );
		$returnTitle = Title::newFromText( $returnText );
		if( $returnTitle ) {
			$returnto = $returnTitle->getFullUrl();
		} else {
			$returnto = "http://wikimediafoundation.org/wiki/Donate-thanks/$language";
		}
		
		// Set the action and tracking ID fields
		$repost = array();
		$action = 'http://wikimediafoundation.org/';
		if ( $gateway == 'paypal' ) {
			$action = 'https://www.paypal.com/cgi-bin/webscr';
			
			// Tracking
			$repost['on0'] = 'contribution_tracking_id';
			
			// PayPal
			$repost['business'] = 'donations@wikimedia.org';
			$repost['item_name'] = 'One-time donation';
			$repost['item_number'] = 'DONATE';
			$repost['cmd'] = '_xclick';
			$repost['no_note'] = '0';
			$repost['notify_url'] = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';
			$repost['return'] = $returnto;
			
			$repost['currency_code'] = $wgRequest->getText( 'currency_code', 'USD' );
		}
		else if ( $gateway == 'moneybookers' ) {
			$action = 'https://www.moneybookers.com/app/payment.pl';

			// Tracking
			$repost['merchant_fields'] = 'os0';

			// Moneybookers
			$repost['pay_to_email'] = 'donation@wikipedia.org';
			$repost['status_url'] = 'https://civicrm.wikimedia.org/fundcore_gateway/moneybookers';
			$repost['language'] = 'en';
			$repost['detail1_description'] = 'One-time donation';
			$repost['detail1_text'] = 'DONATE';
			$repost['currency'] = $wgRequest->getText( 'currency_code', 'USD' );
		} else {
			throw new MWException( "This shouldn't happen, we validated the gateway earlier." );
		}
		
		// Normalized amount
		$repost['amount'] = $wgRequest->getVal( 'amount' );
		if ( $wgRequest->getVal( 'amountGiven' ) ) {
			$repost['amount'] = $wgRequest->getVal( 'amountGiven' );
		}
		
		// Tracking
		$repost['os0'] = $contribution_tracking_id;
		
		$wgOut->addWikiText( "<skin>Tomas</skin>{{2008/Donate-header/$language}}" );
		$wgOut->addHTML( $this->msgWiki( 'contrib-tracking-submitting' ) );
		
		// Output the repost form
		$output = '<form method="post" name="contributiontracking" action="' . $action . '">';

		foreach ( $repost as $key => $value ) {
			$output .= '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '" />';
		}
		
		// Offer a button to post the form if the user has no Javascript support
		$output .= $this->msgWiki( 'contrib-tracking-continue' );
		$output .= '<input type="submit" value="' . $this->msg( 'contrib-tracking-button' ) . '" />';

		$output .= '</form>';

		$wgOut->addHTML( $output );

		$wgOut->addWikiText( "{{2008/Donate-footer/$language}}\n" );

		// Automatically post the form if the user has Javascript support
		$wgOut->addHTML( '<script type="text/javascript">document.contributiontracking.submit();</script>' );

	}

	function msg( $key ) {
		return wfMsgExt( $key, array( 'escape', 'language' => $this->lang ) );
	}

	function msgWiki( $key ) {
		return wfMsgExt( $key, array( 'parse', 'language' => $this->lang ) );
	}

}
