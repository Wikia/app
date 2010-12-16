<?php
/**
 * Hooks for Usability Initiative OptIn extension
 *
 * @file
 * @ingroup Extensions
 */

class OptInHooks {

	/* Static Functions */
	public static function schema() {
		global $wgExtNewTables, $wgExtNewFields;
		
		$wgExtNewTables[] = array(
			'optin_survey',
			dirname( __FILE__ ) . '/OptIn.sql'
		);
		$wgExtNewFields[] = array(
			'optin_survey',
			'ois_type',
			dirname( __FILE__ ) . '/OptIn.patch.ois_type.sql'
		);
		$wgExtNewFields[] = array(
			'optin_survey',
			'ois_question',
			dirname( __FILE__ ) . '/patch-ois_question.sql'
		);
		
		return true;
	}
	
	public static function personalUrls( &$personal_urls, &$title ) {
		global $wgUser, $wgOptInAlwaysShowPersonalLink;
		global $wgOptInNeverShowPersonalLink, $wgRequest;
		
		if ( $wgOptInNeverShowPersonalLink ||
				( !SpecialOptIn::isOptedIn( $wgUser ) &&
				!$wgOptInAlwaysShowPersonalLink ) )
			// Don't show the link
			return true;
		
		// Loads opt-in messages
		wfLoadExtensionMessages( 'OptInLink' );
		
		$fromquery = array();
		if ( !( $wgRequest->wasPosted() ) ) {
			$fromquery = $wgRequest->getValues();
			unset( $fromquery['title'] );
		}
		$query = array(	'from' => $title->getPrefixedDBKey(),
				'fromquery' => wfArrayToCGI( $fromquery )
		);
		// Make sure we don't create links that return to
		// Special:UsabilityOptIn itself
		if ( $title->equals( SpecialPage::getTitleFor( 'OptIn' ) ) ) {
			$query['from'] = $wgRequest->getVal( 'from' );
			$query['fromquery'] = $wgRequest->getVal( 'fromquery' );
		}
		$addLinks = array();
		// For opted-in users, add a feedback link
		if ( SpecialOptIn::isOptedIn( $wgUser ) ) {
			$addLinks['optin-feedback'] = array(
				'text' => wfMsg( 'optin-feedback' ),
				'key' => 'optin-feedback',
				'href' => SpecialPage::getTitleFor( 'OptIn' )->getFullURL(
					array_merge( $query, array( 'opt' => 'feedback' ) )
				),
				'class' => 'no-text-transform'
			);
		}
		// Inserts a link into personal tools
		$key = SpecialOptIn::isOptedIn( $wgUser ) ? 'optin-leave' : 'optin-try';
		$addLinks[$key] = array(
			'text' => wfMsg( $key ),
			'href' => SpecialPage::getTitleFor( 'OptIn' )->getFullURL( $query ),
			'class' => 'no-text-transform'
		);
			
		// Add the links
		$personal_urls = array_merge( $addLinks, $personal_urls ); 
		return true;
	}
}
