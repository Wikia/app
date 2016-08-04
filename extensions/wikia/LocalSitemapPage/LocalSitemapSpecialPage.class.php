<?php

/**
 * Class LocalSitemapSpecialPage
 *
 * This class represents all the modifications to the Special:AllPages required
 * to use it as the local HTML sitemap:
 *
 *  * Allow the page to be cached for a short time for anonymous users
 *  * No forms and prev/next links
 *  * Better format of the from A to B links
 *  * Use alternative from/to params to overcome ?from robot.txt block
 *
 */
class LocalSitemapSpecialPage extends SpecialAllpages {

	/**
	 * Generate chunks as the page was included. This removes the UI around the lists.
	 *
	 * @return bool
	 */
	public function including() {
		return true;
	}

	/**
	 * Use alternative line format for "from A to B" links
	 *
	 * @param String $inpoint
	 * @param String $outpoint
	 * @return string
	 */
	public function showline( $inpoint, $outpoint ) {
		global $wgContLang;
		$inpointf = htmlspecialchars( str_replace( '_', ' ', $inpoint ) );
		$outpointf = htmlspecialchars( str_replace( '_', ' ', $outpoint ) );

		// Don't let the length runaway
		$inpointf = $wgContLang->truncate( $inpointf, $this->maxPageLength );
		$outpointf = $wgContLang->truncate( $outpointf, $this->maxPageLength );

		$link = '?' . http_build_query( [
				'pagefrom' => $inpoint,
				'pageto' => $outpoint,
			] );

		$out = '<div class="local-sitemap-line"><a href="' . htmlspecialchars( $link ) . '"><span>';
		$out .= $this->msg( 'alphaindexline' )->rawParams(
			'</span>' . $inpointf . '<span>',
			'</span>' . $outpointf . '<span>'
		)->escaped();
		$out .= '</span></a></div>';
		return $out;
	}

	public function execute( $par ) {
		$request = $this->getRequest();
		$out = $this->getOutput();
		$user = $this->getUser();

		// TODO: migrate to own i18n files after the new global footer release
		$out->setPageTitle( wfMessage( 'global-footer-local-sitemap' ) );
		$out->setRobotPolicy( 'noindex,follow' );

		if ( $user && !$user->isLoggedIn() ) {
			$out->mSquidMaxage = WikiaResponse::CACHE_VERY_SHORT;
		}

		$from = $request->getVal( 'pagefrom', null );
		$to = $request->getVal( 'pageto', null );

		$this->showToplevel( NS_MAIN, $from, $to );
	}
}
