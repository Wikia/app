<?php
/**
 * SVGEdit extension: hooks
 * @copyright 2010 Brion Vibber <brion@pobox.com>
 */

class SVGEditHooks {
	/* Static Methods */

	/**
	 * BeforePageDisplay hook
	 *
	 * Adds the modules to the page
	 *
	 * @param $out OutputPage output page
	 * @param $skin Skin current skin
	 */
	public static function beforePageDisplay( $out, $skin ) {
		global $wgUser, $wgRequest, $wgSVGEditInline;
		$title = $out->getTitle();
		$modules = array();
		if( self::trigger( $title ) ) {
			$modules[] = 'ext.svgedit.editButton';
		}
		if ($wgSVGEditInline) {
			// Experimental inline edit trigger.
			// Potentially expensive and tricky as far as UI on article pages!
			if( $wgUser->isAllowed( 'upload' ) ) {
				$modules[] = 'ext.svgedit.inline';
			}
		}
		if ($wgRequest->getVal('action') == 'edit') {
			if( $wgUser->isAllowed( 'upload' ) ) {
				$modules[] = 'ext.svgedit.toolbar';
			}
		}
		if ($modules) {
			$out->addModules($modules);
		}
		return true;
	}

	/**
	 * MakeGlobalVariablesScript hook
	 *
	 * Exports a setting if necessary.
	 *
	 * @param $vars array of vars
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgTitle, $wgSVGEditEditor;
		#if( self::trigger( $wgTitle ) ) {
			$vars['wgSVGEditEditor'] = $wgSVGEditEditor;
		#}
		return true;
	}

	/**
	 * Should the editor links trigger on this page?
	 *
	 * @param Title $title
	 * @return boolean
	 */
	private static function trigger( $title ) {
		return $title && $title->getNamespace() == NS_FILE &&
			$title->userCan( 'edit' ) && $title->userCan( 'upload' );
	}

}
