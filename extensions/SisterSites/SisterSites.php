<?php

/**
 * Quickie demo hack!
 *
 * fixme:
 * - a script to import things into the db
 * - only displaying in the right place/time
 * - some sort of cache invalidation
 * - pretty logos
 * - etc!
 * - lots of things ;)
 */

// This should be in a footer. meh
$wgHooks['BeforePageDisplay'][] = 'wfSisterDisplay';

function wfSisterDisplay( $out ) {
	if( $out->isArticleRelated() ) {
		global $wgTitle;
		$title = $wgTitle;
		
		$sister = new SisterSitesList();
		$matches = $sister->siblings( $title );
		
		if( $matches ) {
			$out->addHtml( wfSisterList( $matches ) );
		}
	}
	return true;
}

function wfSisterList( $sites ) {
	foreach( $sites as $site ) {
		$bits[] = wfElement( 'a',
			array(
				'href'  => $site->getUrl(),
				'class' => 'extiw',
				'title' => $site->getWikiLink(),
			),
			$site->getSiteName() );
	}
	return "<div class=\"mw_sistersites\">" .
		"Sister sites: " .
		implode( " | ", $bits ) .
		"</div>\n";
}

class SisterSitesLink {
	function __construct( $row ) {
		$this->mUrl = $row->ssp_url;
		$this->mTitle = $row->ssp_title;
		
		$this->mSiteName = $row->sss_name;
		$this->mInterwiki = $row->sss_interwiki;
	}
	
	function getUrl() {
		return strval( $this->mUrl );
	}
	
	function getWikiLink() {
		return $this->mInterwiki . ':' . $this->mTitle;
	}
	
	function getSiteName() {
		return $this->mSiteName;
	}
}

class SisterSitesList {
	/**
	 * @param Title $title
	 * @return array of SisterSiteLink
	 */
	function siblings( $title ) {
		$normal = self::normalize( $title->getPrefixedText() );
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'sistersites_page', 'sistersites_site' ),
			array(
				'ssp_url',
				'ssp_title',
				'sss_name',
				'sss_interwiki',
			),
			array(
				'ssp_normalized_title' => $normal,
				'ssp_site=sss_id',
			),
			__METHOD__ );
		
		$out = array();
		while( $row = $dbr->fetchObject( $result ) ) {
			$out[] = new SisterSitesLink( $row );
		}
		
		$dbr->freeResult( $result );
		return $out;
	}
	
	/**
	 * Lowercase and strip punctuation and whitespace
	 */
	static function normalize( $text ) {
		global $wgContLang;
		return preg_replace(
			"/[\\x20-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\x7e\\s]/",
			'',
			$wgContLang->lc( $text ) );
	}
}

