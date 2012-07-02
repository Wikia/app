<?php
/**
 * Special Page Class for CommunityVoice extension
 *
 * @file
 * @ingroup Extensions
 */

class CommunityVoicePage extends SpecialPage {

	/* Functions */

	public function __construct() {

		/* Initialization */

		// Initializes special page
		parent::__construct( 'CommunityVoice' );
	}

	public function execute( $sub ) {
		global $wgOut, $wgRequest, $wgUser;

		/* Control */

		// Gets edit token
		$token = $wgRequest->getText( 'token' );
		// Checks if a token was given
		if ( $token ) {
			// Validates edit token
			if ( $wgUser->editToken() == $token ) {
				// Gets module
				$module = $wgRequest->getText( 'module' );
				// Gets action
				$action = $wgRequest->getText( 'action' );
				// Checks that module and action were given
				if ( $module and $action ) {
					// Calls action on module
					CommunityVoice::callModuleAction(
						$module, 'handle', $action
					);
					// Finishes page
					return true;
				} else {
					throw new MWException(
						$module . ' module or ' . $action . ' action ' .
						' not found or are not callable!'
					);
				}
			} else {
				throw new MWException( 'Invalid edit token!' );
			}
		}

		/* View */

		// Begins output
		$this->setHeaders();
		// Breaks sub into path steps
		$path = explode( '/', $sub );
		// Checks if a specific module was given
		if ( count( $path ) >= 1 && $path[0] != '' ) {
			// Calls specific action on module
			CommunityVoice::callModuleAction(
				$path[0], 'show', count( $path ) >= 2 ? $path[1] : 'Main', $path
			);
			// Finishes page
			return true;
		}
		// Modules summary view
		foreach ( CommunityVoice::getModules() as $module ) {
			// Adds heading
			$wgOut->addWikiText(
				'== ' . wfMsg( 'communityvoice-' . strtolower( $module ) ) . ' =='
			);
			// Calls summary action on module
			CommunityVoice::callModuleAction( $module, 'show', 'Summary', $path );
		}
		// Finishes page
		return true;
	}

}
