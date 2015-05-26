<?php

/**
 * Hooks for Exitstitial ads
 */
class AdEngine2ExitstitialHooks {
	/**
	 * Deal with external interwiki links: add exitstitial class to them if needed
	 *
	 * @param $skin
	 * @param $target
	 * @param $options
	 * @param $text
	 * @param $attribs
	 * @param $ret
	 *
	 * @return bool
	 */
	static public function onLinkEnd( $skin, Title $target, array $options, &$text, array &$attribs, &$ret ) {
		if ( $target->isExternal() ) {
			static::handleExternalLink( $attribs['href'], $attribs );
		}
		return true;
	}

	/**
	 * Deal with external links: add exitstitial class to them if needed
	 *
	 * @param $url
	 * @param $text
	 * @param $link
	 * @param $attribs
	 *
	 * @return bool
	 */
	static function onLinkerMakeExternalLink( &$url, &$text, &$link, &$attribs ) {
		static::handleExternalLink( $url, $attribs );
		return true;
	}

	/**
	 * Export variables necessary for Exitstitial.js to work
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript( array &$vars ) {
		global $wgOutboundScreenRedirectDelay, $wgEnableOutboundScreenExt;

		if ( !empty( $wgEnableOutboundScreenExt ) ) {
			$vars['wgEnableOutboundScreenExt'] = true;

			if ( !empty( $wgOutboundScreenRedirectDelay ) ) {
				$vars['wgOutboundScreenRedirectDelay'] = $wgOutboundScreenRedirectDelay;
			}
		}

		return true;
	}

	/**
	 * Add exitstitial class to the external links pointing to not-whitelisted domains
	 * if $wgEnableOutboundScreenExt is set, user is anonymous, not in editor, etc
	 *
	 * @param $url
	 * @param $attribs
	 *
	 * @return null
	 */
	static private function handleExternalLink( $url, &$attribs ) {
		global $wgEnableOutboundScreenExt, $wgRTEParserEnabled, $wgTitle, $wgUser;

		if ( !$wgEnableOutboundScreenExt
			|| $wgRTEParserEnabled    // skip logic when in FCK
			|| empty( $wgTitle )        // setup functions can call MakeExternalLink before wgTitle is set RT#144229
			|| $wgUser->isLoggedIn()  // logged in users have no exit stitial ads
			|| strpos( $url, 'http://' ) !== 0
		) {
			return;
		}

		foreach ( static::getExitstitialUrlsWhiteList() as $whiteListedUrl ) {
			if ( preg_match( '/' . preg_quote( $whiteListedUrl ) . '/i', $url ) ) {
				return;
			}
		}

		if ( isset( $attribs['class'] ) ) {
			$attribs['class'] .= ' exitstitial';
		}
	}


	static private function getExitstitialUrlsWhiteList() {

		global $wgDevelEnvironment, $wgCityId;

		static $whiteList = null;

		if ( is_array( $whiteList ) ) {
			return $whiteList;
		}

		$whiteList = [];
		$whiteListContent = wfMsgExt( 'outbound-screen-whitelist', array( 'language' => 'en' ) );

		if ( !empty( $whiteListContent ) ) {
			$lines = explode( "\n", $whiteListContent );
			foreach ( $lines as $line ) {
				if ( strpos( $line, '* ' ) === 0 ) {
					$whiteList[] = trim( $line, '* ' );
				}
			}
		}

		$wikiDomains = WikiFactory::getDomains( $wgCityId );
		if ( $wikiDomains !== false ) {
			$whiteList = array_merge( $wikiDomains, $whiteList );
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		if ( $wgDevelEnvironment && !empty( $_SERVER['SERVER_NAME'] ) ) {
			array_unshift( $whiteList, $_SERVER['SERVER_NAME'] );
		}

		return $whiteList;
	}
}
