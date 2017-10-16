<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ;
}

class TagsReportPage extends SpecialPage {
	const TABLE = 'city_used_tags';

	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "TagsReport"  /*class*/, 'tagsreport' /*restriction*/ );
	}

	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}
		if ( !$wgUser->isAllowed( 'tagsreport' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$wgOut->setPageTitle( wfMsg( 'tagsreporttitle' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * show form
		 */
		$tag = $wgRequest->getVal ( 'target' );
		$this->showForm( $tag );
		$this->showArticleList( $tag );
	}

	/**
	 * @param string $tag parser hook tag to get the report for
	 */
	function showForm ( $tag ) {
		global $wgOut;
        wfProfileIn( __METHOD__ );

		$timestamp = $this->getGenDate();
		if ( !empty( $timestamp ) ) {
			$wgOut->setSubtitle( wfMsg( 'tagsreportgenerated', $timestamp[0], $timestamp[1] ) );
		}

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( [
			"error"		=> '',
			"action"	=> htmlspecialchars( $this->getTitle()->getLocalURL() ),
			"tagList"	=> $this->getTagsList(),
			"mTag"  	=> $tag,
			"timestamp"	=> $timestamp
        ] );
        $wgOut->addHTML( $oTmpl->render( "main-form" ) );
        wfProfileOut( __METHOD__ );
	}

	/**
	 * @param string $tag parser hook tag to get the report for
	 */
	function showArticleList( $tag ) {
		global $wgOut;
		global $wgCanonicalNamespaceNames;
		global $wgContLang;
        wfProfileIn( __METHOD__ );

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( [
            "mTag"  		=> $tag,
            "articles" 		=> $this->getTagInfo( $tag ),
            "wgCanonicalNamespaceNames" => $wgCanonicalNamespaceNames,
            "wgContLang" 	=> $wgContLang,
            "skin"			=> RequestContext::getMain()->getSkin()
        ] );
        $wgOut->addHTML( $oTmpl->render( "tag-activity" ) );
        wfProfileOut( __METHOD__ );
	}

	/**
	 * Report how many times tags of each kind are used on this wiki
	 *
	 * Returns (tag name) => (count) pairs
	 *
	 * SELECT ct_kind as tag,count(*) as cnt FROM `city_used_tags` WHERE ct_wikia_id = 'X' AND (ct_kind is not null) GROUP BY ct_kind ORDER BY ct_kind
	 *
	 * @return mixed
	 * @throws MWException
	 */
	private function getTagsList() {
		return WikiaDataAccess::cache(
			wfMemcKey( __METHOD__ ),
			WikiaResponse::CACHE_SHORT,
			function() {
				global $wgCityId, $wgStatsDB, $wgStatsDBEnabled;

				if ( empty( $wgStatsDBEnabled ) ) {
					return [];
				}

				$dbs = wfGetDB( DB_SLAVE, [], $wgStatsDB );
				$res = $dbs->select(
					self::TABLE,
					[ 'ct_kind as tag', 'count(*) as cnt' ],
					[
						'ct_wikia_id' => $wgCityId,
						'ct_kind is not null'
					],
					__METHOD__,
					[
						'GROUP BY' => 'ct_kind',
						'ORDER BY' => 'ct_kind'
					]
				);

				$tags = [];
				foreach ( $res as $row ) {
					$tags[ $row->tag ] = intval( $row->cnt );
				}
				return $tags;
			}
		);
	}

	/**
	 * Report how on which articles in which namespace the given parser hook is used
	 *
	 * @param string $tag parser hook tag to get the report for
	 * @return mixed
	 * @throws MWException
	 */
	private function getTagInfo( $tag ) {
		return WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $tag ),
			WikiaResponse::CACHE_SHORT,
			function() use ( $tag ) {
				global $wgCityId, $wgStatsDB, $wgStatsDBEnabled;

				if ( empty( $wgStatsDBEnabled ) ) {
					return [];
				}

				$dbs = wfGetDB( DB_SLAVE, [], $wgStatsDB );
				$res = $dbs->select(
					self::TABLE,
					[ ' ct_namespace', 'ct_page_id' ],
					[
						'ct_wikia_id' => $wgCityId,
						'ct_kind' => $tag
					],
					__METHOD__,
					[
						'ORDER BY' => 'ct_namespace'
					]
				);

				$pages = [];
				foreach ( $res as $row ) {
					$pages[ $row->ct_namespace ][] = intval( $row->ct_page_id );
				}
				return $pages;
			}
		);
	}

	/**
	 * Get the formatted timestamp with the last run of tags_report for a current wiki
	 *
	 * @return mixed
	 * @throws MWException
	 */
	private function getGenDate() {
		global $wgLang, $wgStatsDB, $wgCityId, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			return [];
		}

		$dbs = wfGetDB( DB_SLAVE, [], $wgStatsDB );
		$ts = $dbs->selectField(
			self::TABLE,
			'max(ct_timestamp) as ts',
			[ 'ct_wikia_id' => $wgCityId ],
			__METHOD__
		);

		return [
			$wgLang->date( wfTimestamp( TS_MW, $ts ), true ),
			$wgLang->time( wfTimestamp( TS_MW, $ts ), true ),
		];
	}

}
