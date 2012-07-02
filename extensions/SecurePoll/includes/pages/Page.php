<?php

/**
 * Parent class for Special:SecurePoll subpages.
 */
abstract class SecurePoll_Page {
	var $parent, $election, $auth, $user;
	var $context;

	/**
	 * Constructor.
	 * @param $parent SecurePollPage
	 */
	function __construct( $parent ) {
		$this->parent = $parent;
		$this->context = $parent->sp_context;
	}

	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	abstract function execute( $params );

	/**
	 * Internal utility function for initialising the global entity language 
	 * fallback sequence.
	 */
	function initLanguage( $user, $election ) {
		global $wgRequest, $wgLang;
		$uselang = $wgRequest->getVal( 'uselang' );
		if ( $uselang !== null ) {
			$userLang = $uselang;
		} elseif ( $user instanceof SecurePoll_Voter ) {
			$userLang = $user->getLanguage();
		} else {
			$userLang = $user->getOption( 'language' );
		}
		$wgLang = Language::factory( $userLang );

		$languages = array( $userLang );
		$fallback = $userLang;
		while ( $fallback = Language::getFallbackFor( $fallback ) ) {
			$languages[] = $fallback;
		}
		if ( $fallback != $election->getLanguage() ) {
			$fallback = $election->getLanguage();
			$languages[] = $fallback;
		}
		if ( $fallback != 'en' ) {
			$languages[] = 'en';
		}
		$this->context->setLanguages( $languages );
	}
}
