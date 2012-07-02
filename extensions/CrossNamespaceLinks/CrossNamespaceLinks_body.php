<?php
if (!defined('MEDIAWIKI')) die();

class CrossNamespaceLinks extends QueryPage {
	/**
	 * An inclusive list of namespaces that are acceptable for a
	 * page in the main namespace on Wikimedia sites (Wikipedia) to
	 * link to.
	 *
	 * NS_IMAGE is not included because it doesn't appear in the
	 * pagelinks table but in imagelinks.
	 *
	 * @access private
	 * @var array
	 */
	var $namespaces = array(
		// Nothing should link to NS_MEDIA, [[Media:]] links
		// are recored in the imagelinks table
		// NS_MEDIA
		//
		// {{deletedpage}} links to Special: and probably some others
		NS_SPECIAL,
		NS_MAIN,

		// Many templates e.g. the deletion template and other
		// templates that indicate that there's something wrong
		// with the article link to the talk page.
		NS_TALK,

		// Templates like the stub template link to the
		// project namespace
		NS_PROJECT,
		NS_TEMPLATE,

		// [[Category:]] links are recored in the categorylinks
		// table, [[:Category:]] links should not exist.
		//NS_CATEGORY
	);

	public function __construct( $name = 'CrossNamespaceLinks' ) {
		parent::__construct( $name );
	}
	
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgOut;
		return $wgOut->parse( wfMsg( 'crossnamespacelinks-summary' ) );
	}

	/**
	 * Note: NS_SPECIAL and NS_MEDIA are not on our namespace
	 * whitelist so articles linking to them will be reported,
	 * however, when using the querycache the namespace will be
	 * inserted into qc_value which is defined as unsigned, so <0
	 * will be truncated to 0 so it will appear that these pages
	 * link to the main namespace when they do infact link to
	 * either NS_SPECIAL or NS_MEDIA, I figured it was better to
	 * report that there was something wrong with the article so
	 * that it could be fixed rather than put these two on the
	 * whitelist.
	 */
	function getQueryInfo() {
		return array(
			'tables' => array( 'page', 'pagelinks' ),
			'fields' => array( 'COUNT(*) AS namespace', 'page_title AS title', 'pl_namespace AS value' ),
			'options' => array( 'GROUP BY' => 'page_id' ),
			'conds' => array( 'page_is_redirect' => 0,
				'page_namespace' => NS_MAIN,
				'pl_namespace NOT' => $this->namespaces ),
			'join_conds' => array(
				'page' => array( 'LEFT JOIN', array( 'page_id=pl_from' ) )
			)
		);
	}

	function sortDescending() { return false; }

	function formatResult( $skin, $result ) {
		global $wgContLang, $wgLang;

		$nt = Title::makeTitle( NS_MAIN, $result->title );
		$text = $wgContLang->convert( $nt->getPrefixedText() );

		$plink = Linker::link( $nt, htmlspecialchars( $text ), array(), array(), "known" );

		return wfMsgExt( 'crossnamespacelinkstext', array( 'parsemag' ), $plink, $wgLang->formatNum( $result->namespace ), htmlspecialchars( $wgLang->getNsText( $result->value ) ) );
	}
}
