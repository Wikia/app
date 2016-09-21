<?php

/**
 * Class LocalSitemapSpecialPage
 *
 * This class represents all the modifications to the Special:AllPages required
 * to use it as the local HTML sitemap:
 *
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
	 * @param int $namespace (ignored)
	 * @return string
	 */
	public function showline( $inpoint, $outpoint, $namespace = NS_MAIN ) {
		global $wgContLang;
		$inpointf = htmlspecialchars( str_replace( '_', ' ', $inpoint ) );
		$outpointf = htmlspecialchars( str_replace( '_', ' ', $outpoint ) );

		// Don't let the length runaway
		$inpointf = $wgContLang->truncate( $inpointf, $this->maxPageLength );
		$outpointf = $wgContLang->truncate( $outpointf, $this->maxPageLength );

		$link = '?' . http_build_query( [
				'namefrom' => $inpoint,
				'nameto' => $outpoint,
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

		$out->setPageTitle( wfMessage( 'local-sitemap-page-header' ) );
		$out->setRobotPolicy( 'noindex,follow' );

		$from = $request->getVal( 'namefrom', null );
		$to = $request->getVal( 'nameto', null );

		$this->showToplevel( NS_MAIN, $from, $to );
	}
}
