<?php

class CanonicalHrefHooks {
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ): void {
		$statusCodesWithoutCanonicalHref = [ 404, 410 ];

		if (
			// No canonical on pages with pagination -- they should have the link rel="next/prev" instead
			$out->getRequest()->getVal( 'page' ) ||
			// SUS-5546: Don't render a canonical href for the closed wiki page
			$out->getTitle()->isSpecial( 'CloseWiki' ) ||
			in_array( $out->mStatusCode, $statusCodesWithoutCanonicalHref )
		) {
			return;
		}

		$canonicalUrl = $out->getTitle()->getFullURL();

		// Allow hooks to change the canonicalUrl that will be used in the page.
		Hooks::run( 'WikiaCanonicalHref', [ &$canonicalUrl, $out ] );

		$out->addLink( [
			'rel' => 'canonical',
			'href' => $canonicalUrl,
		] );
	}

	/**
	 * Strip canonical tags on pages that are noindexed as this mixes signals
	 * to Google and they will prefer the canonical signal over the noindex.
	 *
	 * @param  array      &$tags
	 * @param  OutputPage $out
	 * @return void
	 */
	public static function onOutputPageAfterGetHeadLinksArray( array &$tags, OutputPage $out ): void {
		if ( !isset( $tags['meta-robots'] ) ) {
			return;
		}

		$robotsTag = $tags['meta-robots'];
		if ( strpos( $robotsTag, 'content="noindex,' ) !== false ) {
			foreach ( $tags as $i => $tag ) {
				if ( strpos( $tag, ' rel="canonical" ' ) !== false ) {
					unset( $tags[$i] );
				}
			}
		}
	}
}
