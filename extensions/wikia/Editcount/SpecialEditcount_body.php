<?php
if (!defined('MEDIAWIKI')) die();

class Editcount extends SpecialPage {
	const ONE_QUERY = 1;
	const CACHE_TIME = 86400; // 24h
	var $refreshTimestamps;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'Editcount' );
		$this->includable( true );
	}

	/**
	 * main()
	 */
	function execute( $par = null ) {
		global $wgRequest, $wgContLang, $wgSpecialEditCountExludedUsernames;

		$target = isset( $par ) ? $par : $wgRequest->getText( 'username' );

		if (isset($par) && ($par == "User")) {
			global $wgUser;
			$target =  $wgUser->getName();
		}

		list( $username, $namespace ) = $this->extractParamaters( $target );

		$username = Title::newFromText( $username );
		$username = is_object( $username ) ? $username->getText() : '';

		//FB#1040: block requests for 'Default' username, using a configurable array, could be useful for further blocks
		if ( in_array( strtolower( $username ), $wgSpecialEditCountExludedUsernames ) ) {
			$uid = 0;
		} else {
			$uid = User::idFromName( $username );
		}

		/* take archived revisions count for current wiki into consideration */
		$arcount = 0;
		if ($uid != 0) {
			$arcount = $this->editsArchived( $uid );
		}

		if ( $this->including() ) {
			if ( !isset($namespace) ) {
				if ($uid != 0) {
					// ADi: can't do that, we need count per wiki
					// $out = $wgContLang->formatNum( User::edits( $uid ) );
					$out = $wgContLang->formatNum( $this->getTotal( $this->editsByNs( $uid ) ) + $arcount );
				} else {
					$out = "";
				}
			} else {
				if ($uid != 0) {
					$out = $wgContLang->formatNum( $this->editsInNs( $uid, $namespace ) );
				} else {
					$out = "";
				}
			}
			$this->getOutput()->addHTML( $out );
		} else {
			$nscount = $nscountAll = array();
			$total = $totalAll = 0;
			if ($uid != 0) {
				/* show results for current wiki */
				$total = $this->getTotal( $nscount = $this->editsByNs( $uid ) );
				$total += $arcount;// Let archived revisions have their share in percentage
				/* show results for all wikis */
				$totalAll = $this->getTotal( $nscountAll = $this->editsByNsAll( $uid ) );
			}
			$html = new EditcountHTML;
			$html->outputHTML( $username, $uid, $nscount, $arcount, $total, $nscountAll, $totalAll, $this->refreshTimestamps );
		}
	}

	/**
	 * Parse the username and namespace parts of the input and return them
	 *
	 * @param string $par
	 * @return array
	 */
	function extractParamaters( $par ) {
		global $wgContLang;

		@list($user, $namespace) = explode( '/', $par, 2 );

		// str*cmp sucks
		if ( isset( $namespace ) && !is_numeric($namespace) ) {
			$namespace = $wgContLang->getNsIndex( $namespace );
		}

		return array( $user, $namespace );
	}

	/**
	 * Compute and return the total edits in all namespaces
	 *
	 * @param array $nscount An associative array
	 * @return int
	 */
	function getTotal( $nscount ) {
		$total = 0;
		foreach ( array_values( $nscount ) as $i )
			$total += $i;

		return $total;
	}

	/**
	 * Count the number of edits of a user by namespace
	 *
	 * @param int $uid The user ID to check
	 * @return array
	 */
	function editsByNs( $uid ) {
		global $wgMemc;
		$key = wfMemcKey( 'namespaceCount', $uid );
		$keyTimestamp = wfMemcKey( 'namespaceCountTimestamp', $uid );
		$nscount = $wgMemc->get($key);
		$this->refreshTimestamps['currentWikia'] = $wgMemc->get($keyTimestamp);

		if ( empty($nscount) ) {
			$nscount = array();

			if (self::ONE_QUERY == 1) {
				$dbr =& wfGetDB( DB_SLAVE );
				$res = $dbr->select(
					array( 'revision', 'page' ),
					array( 'page_namespace', 'COUNT(*) as count' ),
					array(
						'rev_user' => $uid,
						'rev_page = page_id'
					),
					__METHOD__,
					array( 'GROUP BY' => 'page_namespace' )
				);

				while( $row = $dbr->fetchObject( $res ) ) {
					$nscount[$row->page_namespace] = $row->count;
				}
			} else {
				$nspaces = $this->editsByNsAll($uid);
				if (!empty($nspaces)) {
					foreach ($nspaces as $ns => $count) {
						if ($count > 0) {
							$nscount[$ns] = $this->editsInNs($uid, $ns);
						}
					}
				}
			}

			$wgMemc->set( $key, $nscount, self::CACHE_TIME );
			$this->refreshTimestamps['currentWikia'] = time()+self::CACHE_TIME;
			$wgMemc->set( $keyTimestamp, $this->refreshTimestamps['currentWikia'], self::CACHE_TIME );
		}

		return $nscount;
	}

	/**
	 * Count the number of archived edits (revisions) of a user
	 *
	 * @param int $uid The user ID to check
	 * @return int
	 */
	function editsArchived( $uid ) {
		global $wgMemc;
		$key = wfMemcKey( 'archivedCount', $uid );
		$arcount = $wgMemc->get($key);

		if ( empty($arcount) ) {
			$dbr =& wfGetDB( DB_SLAVE );
			$arcount = $dbr->selectField(
				array( 'archive' ),
				array( 'COUNT(*) as count' ),
				array(
					'ar_user' => $uid
				),
				__METHOD__
			);

			$wgMemc->set( $key, $arcount, self::CACHE_TIME );
		}

		return $arcount;
	}

	function editsByNsAll( $uid ) {
		global $wgStatsDB, $wgStatsDBEnabled, $wgMemc;

		$key = wfSharedMemcKey( 'namespaceCountAllWikis', $uid );
		$keyTimestamp = wfMemcKey( 'namespaceCountTimestamp', $uid );
		$nscount = $wgMemc->get($key);
		$this->refreshTimestamps['allWikias'] = $wgMemc->get($keyTimestamp);

		if ( empty($nscount) ) {
			$nscount = array();
			if ( !empty( $wgStatsDBEnabled ) ) {
				$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
				$res = $dbs->select(
					array( 'events' ),
					array( 'page_ns as namespace', 'count(page_ns) as count' ),
					array(
						'user_id' => $uid,
						' ( event_type = 1 ) or ( event_type = 2 ) '
					),
					__METHOD__,
					array (
						'GROUP BY' => 'page_ns',
						'ORDER BY' => 'null'
					)
				);

				while( $row = $dbs->fetchObject( $res ) ) {
					$nscount[$row->namespace] = $row->count;
				}
				$dbs->freeResult( $res );
			}
			$wgMemc->set( $key, $nscount, self::CACHE_TIME );
			$this->refreshTimestamps['allWikias'] = time()+self::CACHE_TIME;
			$wgMemc->set( $keyTimestamp, $this->refreshTimestamps['allWikias'], self::CACHE_TIME );
		}
		return $nscount;
	}

	/**
	 * Count the number of edits of a user in a given namespace
	 *
	 * @param int $uid The user ID to check
	 * @param int $ns  The namespace to check
	 * @return string
	 */
	function editsInNs( $uid, $ns ) {
		global $wgMemc;
		$key = wfMemcKey( 'namespaceCount', $uid, $ns );
		$nscount = $wgMemc->get( $key );

		if ( empty($nscount) ) {
			$nscount = array();

			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->selectField(
				array( 'revision', 'page' ),
				array( 'COUNT(*) as count' ),
				array(
					'page_namespace' => $ns,
					'rev_user' => $uid,
					'rev_page = page_id'
				),
				__METHOD__
			);
			$wgMemc->set( $key, $nscount, self::CACHE_TIME );
		}

		return $res;
	}

}

class EditcountHTML extends Editcount {
	/**
	 * @var array
	 */
	var $nscount;
	var $nscountall;

	/**
	 * @var int
	 */
	var $total;
	var $totalall;

	/**
	 * Output the HTML form on Special:Editcount
	 *
	 * @param string $username
	 * @param int $uid 	User ID
	 * @param array $nscount	Array of namespaces codes and editcounts per namespace for current wiki
	 * 			e.g. array ( '0'=> 5 ) 5 edits in main namespace (0)
	 * @param int $arcount Sum of archived revisions on wiki
	 * @param int $wikitotal	Sum of all edits in all namespaces plus archived revisions for current wiki
	 * @param array $nscountall	Array of namespaces codes and editcounts per namespace for all wikis
	 * @param int $totalall	Sum of edits on all wikis
	 * @param array $refreshTimestamps
	 */
	function outputHTML( $username, $uid, $nscount, $arcount, $wikitotal, $nscountall, $totalall, $refreshTimestamps ) {
		wfProfileIn( __METHOD__ );

		/* current wiki */
		$this->nscount = $nscount;
		$this->wikitotal = $wikitotal;
		$this->arcount = $arcount;
		/* all wikis */
		$this->nscountall = $nscountall;
		$this->totalall = $totalall;

		$this->setHeaders();

		list( $name, $subpage ) = SpecialPageFactory::resolveAlias( $this->getTitle()->getDBkey() );
		$title = SpecialPage::getTitleFor( $name ); // get link WITHOUT subpage
		$action = $title->getLocalUrl();

		$user = wfMessage( 'editcount_username' )->escaped();
		$submit = wfMessage( 'editcount_submit' )->escaped();

		$editcounttable = ($username != null && $uid != 0) ? $this->makeTable() : "";

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"			=> $action,
			"submit"			=> $submit,
			"user" 				=> $user,
			"username"			=> $username,
			"editcounttable" 	=> $editcounttable
		));
		$this->getOutput()->addHTML( $oTmpl->render("main-form") );

		$this->addRefreshTimestampsToOut( $refreshTimestamps );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Make the editcount-by-namespaces HTML table
	 *
	 */
	function makeTable() {
		global $wgCityId, $wgSitename;
        wfProfileIn( __METHOD__ );

		$total = wfMessage( 'editcount_total' )->escaped();
		$wikiName = $wgSitename;
		/* current wiki */
		$ftotal = $this->getLanguage()->formatNum( $this->wikitotal );
		$percent = ($this->wikitotal > 0) ? wfPercent( $this->wikitotal / $this->wikitotal * 100 , 2 ) : wfPercent( 0 ); // @bug 4400
		/* all wikis */
		$ftotalall = $this->getLanguage()->formatNum( $this->totalall );
		$percentall = ($this->totalall > 0) ? wfPercent( $this->totalall / $this->totalall * 100 , 2 ) : wfPercent( 0 );

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "total"			=> $total,
            "ftotal"		=> $ftotal,
            "ftotalall"		=> $ftotalall,
            "percent"		=> $percent,
            "percentall"	=> $percentall,
            "wikiName"		=> $wikiName,
            "nscount"		=> $this->nscount,
            "wikitotal"		=> $this->wikitotal,
            "nscountall"	=> $this->nscountall,
            "nstotalall"	=> $this->totalall,
            "arcount"		=> $this->arcount,
            "wgLang"		=> $this->getLanguage(),
        ));
        $res = $oTmpl->render("table");
        wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * Adds to output information for user when cached data will be refreshed next time
	 *
	 * @param $refreshTimestamps Array of timestamps in format YmdHis e.g. 20131107192200
	 *
	 */
	function addRefreshTimestampsToOut( $refreshTimestamps ) {
		wfProfileIn( __METHOD__ );
		global $wgSitename;

		// Current wikia column (using db name as column name)
		if( isset( $refreshTimestamps['currentWikia'] ) ) {
			$currentWikiaMsg = $wgSitename;
			$nextRefCurrW = $this->getLanguage()->timeanddate( $refreshTimestamps['currentWikia'] ,true, true );
			$this->getOutput()->addWikiMsg( 'editcount_refresh_time', $currentWikiaMsg, $nextRefCurrW );
		}

		// all wikias (summary column)
		if( isset( $refreshTimestamps[ 'allWikias' ] ) ) {
			$allWikiasMsg = wfMessage( 'editcount_allwikis' )->escaped();
			$nextRefAllW = $this->getLanguage()->timeanddate( $refreshTimestamps[ 'allWikias' ] ,true, true );
			$this->getOutput()->addWikiMsg( 'editcount_refresh_time', $allWikiasMsg, $nextRefAllW );
		}

		wfProfileOut( __METHOD__ );
	}

}
