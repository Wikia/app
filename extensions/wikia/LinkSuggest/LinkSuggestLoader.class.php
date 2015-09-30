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

	private static $instance = null;

	private function __construct() {
		// register hook to add LinkSuggest output modules
		F::app()->registerHook( 'BeforePageDisplay', get_class( $this ), 'onBeforePageDisplay', [], false, $this );
	}

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new LinkSuggestLoader();
		}

		return self::$instance;
	}

	/**
	 * Add the selector for an element to receive LinkSuggest
	 * @param string $selector : a single jQuery-style selector
	 */
	public function addSelectors( $selector ) {
		array_push( $this->selectors, $selector );
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
		// only add the module if there are elements that need it and the user enabled LinkSuggest
		if ( count( $this->selectors ) && !$out->getUser()->getGlobalPreference( 'disablelinksuggest' ) ) {
			$out->addJsConfigVars( [ 'wgLinkSuggestElements' => $this->selectors ] );
			$out->addModules( 'ext.wikia.LinkSuggest' );
		}

		return true;
	}
}
