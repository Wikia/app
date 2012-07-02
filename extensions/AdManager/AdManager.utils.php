<?php
/**
 * Helper functions for the Ad Manager extension.
 */

class AdManagerUtils {

	/**
	 * Displays an error box message.
	 *
	 * @param $condition Boolean
	 * @param $wikiMsg String: name of a system message to output as wikitext
	 * @return Boolean: true if error found
	 */
	public static function checkForAndDisplayError( $condition, $wikiMsg = 'admanager_error' ) {
		global $wgOut;

		if ( !$condition ) {
			$wgOut->addHTML( '<div class="errorbox">' );
			$wgOut->addWikiMsg( $wikiMsg );
			$wgOut->addHTML( '</div>' );
			return true;
		}
		return false;
	}

	/**
	 * Helper function to display a hidden field for different versions
	 * of MediaWiki.
	 */
	static function hiddenField( $name, $value ) {
		if ( class_exists( 'Html' ) ) {
			return "\t" . Html::hidden( $name, $value ) . "\n";
		} else {
			return "\t" . Xml::hidden( $name, $value ) . "\n";
		}
	}
}