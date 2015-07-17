<?php

/**
 * @class LinkSuggestLoader
 * Proper loader for LinkSuggest
 * @author TK-999
 */
class LinkSuggestLoader {
	/**
	 * @var array $selectors : Array of jQuery-style selectors to apply LinkSuggest to
	 */
	private $selectors = [];

	/**
	 * @var bool $userWantsLinkSuggest : Whether the current user has enabled linkSuggest
	 */
	private $userWantsLinkSuggest = false;

	private static $instance = null;

	private function __construct() {
		$app = F::app();
		$this->userWantsLinkSuggest = !( $app->wg->User->getGlobalPreference( 'disablelinksuggest' ) );

		// only register hook if the user has enabled LinkSuggest
		if ( $this->userWantsLinkSuggest ) {
			$app->registerHook( 'BeforePageDisplay', get_class( $this ), 'onBeforePageDisplay', [], false, $this );
		}
	}

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new LinkSuggestLoader();
		}

		return self::$instance;
	}

	/**
	 * Add the selector for an element to receive LinkSuggest
	 * @param mixed $selectors : a single jQuery-style selector or an array
	 */
	public function addSelectors( $selectors ) {
		// only add selectors if the user has enabled LinkSuggest
		if ( $this->userWantsLinkSuggest ) {
			if ( is_array( $selectors ) ) {
				$this->selectors = array_merge( $this->selectors, $selectors );
			} else {
				array_push( $this->selectors, $selectors );
			}
		}
	}

	/**
	 * Hook: BeforePageDisplay
	 *
	 * Adds the selectors to JS to be parsed by LinkSuggest
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool true because it's a hook handler
	 */
	public function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		// only add the module if there are elements that need it
		if ( count( $this->selectors ) ) {
			$out->addJsConfigVars( [ 'wgLinkSuggestElements' => $this->selectors ] );
			$out->addModules( 'ext.wikia.LinkSuggest' );
		}

		return true;
	}
}
