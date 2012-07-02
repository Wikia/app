<?php
/**
 * ShoutWikiAds class -- contains the hooked functions and some other crap for
 * displaying the advertisements.
 * Route all requests through loadAd( $type ) to ensure correct processing.
 *
 * We allow wiki admins to configure some things because our "sane defaults"
 * may clash with certain CSS styles (dark wikis, for example).
 * wfMsgForContent() is used because CSS is "global" (doesn't vary depending on
 * the user's language).
 *
 * All class methods are public and static.
 *
 * @file
 * @ingroup Extensions
 */

class ShoutWikiAds {

	/**
	 * Can we show ads on the current page?
	 *
	 * @return Boolean: false if ads aren't enabled or the current page is
	 *                  Special:UserLogin (login page) or if the user is
	 *                  autoconfirmed and the forceads parameter is NOT in the
	 *                  URL, otherwise true
	 */
	public static function canShowAds() {
		global $wgAdConfig, $wgTitle, $wgUser, $wgRequest;

		if( !$wgAdConfig['enabled'] ) {
			return false;
		}

		if( $wgTitle instanceof Title &&
				array_shift(SpecialPageFactory::resolveAlias( $wgTitle->getDBkey() )) == 'Userlogin' ||
			$wgUser->isAllowed( 'autoconfirmed' ) && !$wgRequest->getVal( 'forceads' )
		)
		{
			return false;
		}

		return true;
	}

	/**
	 * Check if the current wiki's language is supported by the ad provider
	 * (currently checks against Google's list).
	 *
	 * @return Boolean: true if the language is supported, otherwise false
	 */
	public static function isSupportedLanguage() {
		global $wgLanguageCode;

		// "Publishers are also not permitted to place AdSense code on pages
		// with content primarily in an unsupported language"
		// @see https://www.google.com/adsense/support/bin/answer.py?answer=9727
		$supportedAdLanguages = array(
			// Arabic -> Dutch (+some Chinese variants)
			'ar', 'bg', 'zh', 'zh-hans', 'zh-hant', 'hr', 'cs', 'da', 'nl',
			// English and its variants
			'en', 'en-gb', 'en-lolcat', 'en-piglatin',
			// Finnish -> Polish
			'fi', 'fr', 'de', 'el', 'he', 'hu', 'it', 'ja', 'ko', 'no', 'pl',
			// Portuguese -> Turkish
			'pt', 'ro', 'ru', 'sr', 'sr-ec', 'sk', 'es', 'sv', 'th', 'tr',
			// http://adsense.blogspot.com/2009/08/adsense-launched-in-lithuanian.html
			'lt', 'lv', 'uk'
		);

		if( in_array( $wgLanguageCode, $supportedAdLanguages ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if the current namespace is allowed to show ads.
	 *
	 * @return Boolean: true if the namespace is supported, otherwise false
	 */
	public static function isEnabledNamespace() {
		global $wgAdConfig, $wgTitle;
		$namespace = $wgTitle->getNamespace();
		if( in_array( $namespace, $wgAdConfig['namespaces'] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Skin-agnostic way of getting the HTML for a Google AdSense sidebar
	 * ad.
	 *
	 * @return String: HTML code
	 */
	public static function getSidebarHTML() {
		global $wgAdConfig, $wgUser;

		$skinName = 'monaco';
		$id = "{$skinName}-sidebar-ad";
		$classes = "{$skinName}-ad noprint";
		// The code below might be useful, but it's not necessary currently
		// as Monobook cannot support this type of ad (Monobook has right
		// column and toolbox ads only)
		/*
		$skinObj = $wgUser->getSkin();
		$skinName = 'monobook'; // sane default
		if ( get_class( $skinObj ) == 'SkinMonaco' ) {
			$skinName = 'monaco';
		} elseif ( get_class( $skinObj ) == 'SkinMonoBook' ) {
			$skinName = 'monobook';
		}

		$id = "{$skinName}-sidebar-ad";
		$classes = "{$skinName}-ad noprint";
		// Different IDs and classes for Monaco and Monobook
		if ( $skinName == 'monobook' ) {
			$id = 'column-google';
			$classes = 'noprint';
		} elseif ( $skinName == 'monaco' ) {
			$id = "{$skinName}-sidebar-ad";
			$classes = "{$skinName}-ad noprint";
		}
		*/

		return '<!-- Begin sidebar ad (ShoutWikiAds) -->
		<div id="' . $id . '" class="' . $classes . '">
<script type="text/javascript"><!--
google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
google_ad_width = 200;
google_ad_height = 200;
google_ad_format = "200x200_as";
google_ad_type = "text";
google_ad_channel = "";
google_color_border = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-sidebar-ad-color-border', wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-border' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-border' ) : 'F6F4C4' ) . '";
google_color_bg = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-sidebar-ad-color-bg', wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-bg' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-bg' ) : 'FFFFE0' ) . '";
google_color_link = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-sidebar-ad-color-link', wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-link' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-link' ) : '000000' ) . '";
google_color_text = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-sidebar-ad-color-text', wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-text' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-text' ) : '000000' ) . '";
google_color_url = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-sidebar-ad-color-url', wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-url' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-sidebar-ad-color-url' ) : '002BB8' ) . '";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</div>
<!-- End sidebar ad (ShoutWikiAds) -->' . "\n";
	}

	/**
	 * Skin-agnostic way of getting the HTML for a Google AdSense leaderboard
	 * ad.
	 *
	 * @return String: HTML code
	 */
	public static function getLeaderboardHTML() {
		global $wgAdConfig, $wgUser;

		$skinName = 'monaco'; // sane default
		/*
		$skinObj = $wgUser->getSkin();
		if ( get_class( $skinObj ) == 'SkinMonaco' ) {
			$skinName = 'monaco';
		} elseif ( get_class( $skinObj ) == 'SkinMonoBook' ) {
			$skinName = 'monobook';
		}
		*/

		$adSlot = '';
		if ( isset( $wgAdConfig['ad-slot'] ) ) {
			$adSlot = $wgAdConfig['ad-slot'];
		}

		return '<!-- Begin leaderboard ad (ShoutWikiAds) -->
		<div id="' . $skinName . '-leaderboard-ad" class="' . $skinName . '-ad noprint">
<script type="text/javascript"><!--
google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
google_ad_slot = "' . $adSlot . '";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text";
google_ad_channel = "";
google_color_border = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-border', wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-border' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-border' ) : 'F6F4C4' ) . '";
google_color_bg = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-bg', wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-bg' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-bg' ) : 'FFFFE0' ) . '";
google_color_link = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-link', wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-link' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-link' ) : '000000' ) . '";
google_color_text = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-text', wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-text' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-text' ) : '000000' ) . '";
google_color_url = "' . ( !wfEmptyMsg( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-url', wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-url' ) ) ? wfMsgForContent( 'shoutwiki-' . $skinName . '-leaderboard-ad-color-url' ) : '002BB8' ) . '";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</div>
<!-- End leaderboard ad (ShoutWikiAds) -->' . "\n";
	}

	/**
	 * Get the HTML for Monobook toolbox ad (125x125).
	 * @return HTML
	 */
	public static function getToolboxHTML() {
		global $wgAdConfig;
		return '<!-- Begin toolbox ad (ShoutWikiAds) -->
<div id="p-ads-left" class="noprint">
<script type="text/javascript"><!--
google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
google_ad_width = 125;
google_ad_height = 125;
google_ad_format = "125x125_as";
google_ad_type = "text";
google_ad_channel = "";
google_color_border = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-toolbox-ad-color-border', wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-border' ) ) ? wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-border' ) : 'F6F4C4' ) . '";
google_color_bg = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-toolbox-ad-color-bg', wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-bg' ) ) ? wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-bg' ) : 'FFFFE0' ) . '";
google_color_link = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-toolbox-ad-color-link', wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-link' ) ) ? wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-link' ) : '000000' ) . '";
google_color_text = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-toolbox-ad-color-text', wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-text' ) ) ? wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-text' ) : '000000' ) . '";
google_color_url = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-toolbox-ad-color-url', wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-url' ) ) ? wfMsgForContent( 'shoutwiki-monobook-toolbox-ad-color-url' ) : '002BB8' ) . '";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</div>
<!-- End toolbox ad (ShoutWikiAds) -->' . "\n";
	}

	/**
	 * Get a skyscraper ad (currently only for Monobook skin).
	 * @return HTML
	 */
	public static function getSkyscraperHTML() {
		global $wgAdConfig;
		return "\n" . '<!-- Begin skyscraper ad (ShoutWikiAds) -->
<div id="column-google" class="noprint">
<script type="text/javascript"><!--
google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
google_ad_slot = "' . $wgAdConfig['ad-slot'] . '";
google_ad_width = 120;
google_ad_height = 600;
google_ad_format = "120x600_as";
google_ad_type = "text";
google_ad_channel = "";
google_color_border = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-rightcolumn-ad-color-border', wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-border' ) ) ? wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-border' ) : 'F6F4C4' ) . '";
google_color_bg = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-rightcolumn-ad-color-bg', wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-bg' ) ) ? wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-bg' ) : 'FFFFE0' ) . '";
google_color_link = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-rightcolumn-ad-color-link', wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-link' ) ) ? wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-link' ) : '000000' ) . '";
google_color_text = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-rightcolumn-ad-color-text', wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-text' ) ) ? wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-text' ) : '000000' ) . '";
google_color_url = "' . ( !wfEmptyMsg( 'shoutwiki-monobook-rightcolumn-ad-color-url', wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-url' ) ) ? wfMsgForContent( 'shoutwiki-monobook-rightcolumn-ad-color-url' ) : '002BB8' ) . '";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</div>
<!-- End skyscraper ad (ShoutWikiAds) -->' . "\n";
	}

	/**
	 * This just adds the relevant ad CSS file under certain conditions.
	 * The actual logic is elsewhere.
	 *
	 * @param $out Object: OutputPage instance
	 * @param $sk Object: instance of Skin or one of its child classes
	 * @return Boolean: true
	 */
	public static function setupAdCSS( &$out, &$sk ) {
		global $wgAdConfig, $wgRequest, $wgUser;

		if( !$wgAdConfig['enabled'] ) {
			return true;
		}

		// In order for us to load ad-related CSS, the user must either be very
		// new (=not autoconfirmed) or have supplied the forceads parameter in
		// the URL
		if(
			!$wgUser->isAllowed( 'autoconfirmed' ) ||
			$wgRequest->getVal( 'forceads' )
		)
		{
			$title = $out->getTitle();
			$namespace = $title->getNamespace();

			// Okay, the variable name sucks but anyway...normal page != not login page
			$isNormalPage = $title instanceof Title &&
				array_shift(SpecialPageFactory::resolveAlias( $title->getDBkey() )) !== 'Userlogin';

			// Load ad CSS file when ads are enabled
			if(
				$isNormalPage &&
				in_array( $namespace, $wgAdConfig['namespaces'] )
			)
			{
				if ( get_class( $sk ) == 'SkinMonaco' ) { // Monaco
					$out->addModuleStyles( 'ext.ShoutWikiAds.monaco' );
				} elseif( get_class( $sk ) == 'SkinMonoBook' ) { // Monobook
					if ( $wgAdConfig['right-column'] ) {
						$out->addModuleStyles( 'ext.ShoutWikiAds.monobook.skyscraper' );
					}
					if ( $wgAdConfig['toolbox-button'] ) {
						$out->addModuleStyles( 'ext.ShoutWikiAds.monobook.button' );
					}
				} elseif ( get_class( $sk ) == 'SkinTruglass' ) { // Truglass
					$out->addModuleStyles( 'ext.ShoutWikiAds.truglass' );
				}
			}
		}

		return true;
	}

	/**
	 * Load toolbox ad for Monobook skin.
	 * @return Boolean: true
	 */
	public static function onMonoBookAfterToolbox() {
		global $wgAdConfig;
		if ( $wgAdConfig['toolbox-button'] ) {
			echo self::loadAd( 'toolbox-button' );
		}
		return true;
	}

	/**
	 * Load skyscraper ad for Monobook skin.
	 * @return Boolean: true
	 */
	public static function onMonoBookAfterContent() {
		global $wgAdConfig;
		if ( $wgAdConfig['right-column'] ) {
			echo self::loadAd( 'right-column' );
		}
		return true;
	}

	/**
	 * Load sidebar ad for Monaco skin.
	 * @return Boolean: true
	 */
	public static function onMonacoSidebar() {
		global $wgAdConfig;
		if ( $wgAdConfig['monaco-sidebar'] ) {
			echo self::loadAd( 'sidebar' );
		}
		return true;
	}

	/**
	 * Load leaderboard ad in Monaco skin's footer.
	 * @return Boolean: true
	 */
	public static function onMonacoFooter() {
		global $wgAdConfig;
		if ( $wgAdConfig['monaco-leaderboard'] ) {
			echo self::loadAd( 'leaderboard' );
		}
		return true;
	}

	/**
	 * Called *only* by Truglass skin.
	 *
	 * @todo FIXME: use self::getLeaderboardHTML() or something for getting the
	 *              ad code...
	 * @return Boolean: true
	 */
	public static function renderTruglassAd() {
		global $wgAdConfig;
		if ( $wgAdConfig['truglass-leaderboard'] ) {
			echo '<!-- Begin Truglass ad (ShoutWikiAds) -->
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td valign="top" id="contentBox">
								<div id="contentCont">
										<table id="topsector" width="100%">
											<tr>
												<td>
													<div id="topadsleft" class="noprint">
														<script type="text/javascript"><!--
														google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
														google_alternate_color = "eeeeee";
														google_ad_width = 728;
														google_ad_height = 90;
														google_ad_format = "728x90_as";
														google_ad_type = "text";
														google_color_border = "CDCDCD";
														google_color_bg = "FFFFFF";
														google_color_link = "0066FF";
														google_color_url = "00A000";
														google_color_text = "000000";
														//-->
														</script>
														<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
														</script>
													</div>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- End Truglass ad (ShoutWikiAds) -->' . "\n";
		}
		return true;
	}

	/**
	 * Load ads for a defined "slot"
	 * Ad code (div element + JS) is echoed back and no value is returned
	 * except in special cases we return true (early return cases/unrecognized slot)
	 *
	 * @param $type String: what kind of ads to load
	 * @return Mixed: HTML (on success) or boolean true (on failure)
	 */
	public static function loadAd( $type ) {
		// Early return cases:
		// ** if we can't show ads on the current page (i.e. if it's the login
		// page or something)
		// ** if the wiki's language code isn't supported by Google AdSense
		// ** if ads aren't enabled for the current namespace
		if ( !self::canShowAds() ) {
			return '';
		}

		if ( !self::isSupportedLanguage() ) {
			return '';
		}

		if ( !self::isEnabledNamespace() ) {
			return '';
		}

		// Main ad logic starts here
		if( $type === 'leaderboard' ) {
			return self::getLeaderboardHTML();
		} elseif( $type === 'sidebar' ) {
			return self::getSidebarHTML();
		} elseif ( $type === 'toolbox-button' ) {
			return self::getToolboxHTML();
		} elseif ( $type === 'right-column' ) {
			return self::getSkyscraperHTML();
		} else { // invalid type/these ads not enabled in $wgAdConfig
			return '';
		}
	}

}
