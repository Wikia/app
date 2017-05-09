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
 *  * Hide MediaWiki redirects
 *
 */
class LocalSitemapSpecialPage extends SpecialAllpages {
	/**
	 * Setting this flag causes the Special:AllPages to skip over redirects when displaying the list of pages.
	 * It has a matching Wikia change in SpecialAllpages class. Note it only works when including() returns true.
	 *
	 * @var bool
	 */
	public $skipRedirects = true;

	/**
	 * Generate chunks as the page was included. This removes the UI around the lists.
	 *
	 * @var bool
	 */
	protected $mIncluding = true;

	/**
	 * Use alternative line format for "from A to B" links
	 *
	 * @param String $inpoint
	 * @param String $outpoint
	 * @param int $namespace
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
				'ns' => $namespace
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
		$ns = $request->getVal( 'ns', null );

		if ( is_null( $ns ) ) {
			$this->showToplevel( NS_MAIN, $from, $to );
			$this->showToplevel( NS_FILE, $from, $to );
		} else {
			$this->showToplevel( intval( $ns ), $from, $to );
		}
	}
}
