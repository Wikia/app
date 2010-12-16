<?php
if (!defined('MEDIAWIKI')) die();

global $wgHooks, $IP;

require_once "$IP/includes/QueryPage.php";

class CrossNamespaceLinks extends SpecialPage {
	/**
	 * Constructor
	 */
	function CrossNamespaceLinks() {
		SpecialPage::SpecialPage( 'CrossNamespaceLinks' );
	}

	/**
	 * main()
	 */
	function execute( $parameters ) {
		wfLoadExtensionMessages( 'CrossNamespaceLinks' );
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();

		$cnl = new CrossNamespaceLinksPage();

		$cnl->doQuery( $offset, $limit );
	}
}

class CrossNamespaceLinksPage extends QueryPage {
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

	function getName() { return 'CrossNamespaceLinks'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgOut;
		wfLoadExtensionMessages( 'CrossNamespaceLinks' );
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
	function getSQL() {
		$dbr = wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'page', 'pagelinks' ) );
		$namespaces = implode( ',', $this->namespaces );
		return
			"
			SELECT
				'CrossNamespaceLinks' as type,
				COUNT(*) as namespace,
				page_title as title,
				pl_namespace as value
			FROM $pagelinks
			LEFT JOIN $page ON page_id = pl_from
			WHERE page_is_redirect = 0 AND page_namespace = " . NS_MAIN . " AND pl_namespace NOT IN ($namespaces)
			GROUP BY page_id
			";
	}

	function sortDescending() { return false; }

	function formatResult( $skin, $result ) {
		global $wgContLang, $wgLang;

		$nt = Title::makeTitle( NS_MAIN, $result->title );
		$text = $wgContLang->convert( $nt->getPrefixedText() );

		$plink = $skin->makeKnownLink( $nt->getPrefixedText(), htmlspecialchars( $text ) );

		wfLoadExtensionMessages( 'CrossNamespaceLinks' );
		return wfMsgExt( 'crossnamespacelinkstext', array( 'parsemag' ), $plink, $wgLang->formatNum( $result->namespace ), htmlspecialchars( $wgLang->getNsText( $result->value ) ) );
	}
}
