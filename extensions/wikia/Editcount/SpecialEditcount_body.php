<?php
if (!defined('MEDIAWIKI')) die();

class Editcount extends SpecialPage {
	const ONE_QUERY = 1;
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
		global $wgVersion, $wgRequest, $wgOut, $wgContLang, $wgSpecialEditCountExludedUsernames;

		if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
			$wgOut->versionRequired( '1.5beta4' );
			return;
		}

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

		if ( $this->including() ) {
			if ( !isset($namespace) ) {
				if ($uid != 0) {
					// ADi: can't do that, we need count per wiki
					// $out = $wgContLang->formatNum( User::edits( $uid ) );
					$out = $wgContLang->formatNum( $this->getTotal( $this->editsByNs( $uid ) ) );
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
			$wgOut->addHTML( $out );
		} else {
			$nscount = $nscountAll = array();
			if ($uid != 0) {
				/* show results for current wiki */
				$total = $this->getTotal( $nscount = $this->editsByNs( $uid ) );
				/* show results for all wikis */
				$totalAll = $this->getTotal( $nscountAll = $this->editsByNsAll( $uid ) );
			}
			$html = new EditcountHTML;
			$html->outputHTML( $username, $uid, @$nscount, @$total, @$nscountAll, @$totalAll );
		}
	}

	/**
	 * Parse the username and namespace parts of the input and return them
	 *
	 * @access private
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
	 * @access private
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
		$nscount = $wgMemc->get($key);
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
			$wgMemc->set( $key, $nscount, 86400 );
		}

		return $nscount;
	}

	function editsByNsAll( $uid ) {
		global $wgStatsDB, $wgStatsDBEnabled, $wgMemc;

		$key = wfSharedMemcKey( 'namespaceCountAllWikis', $uid );
		$nscount = $wgMemc->get($key);

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
			$wgMemc->set( $key, $nscount, 86400 );
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
			$wgMemc->set( $key, $nscount, 86400 );
		}

		return $res;
	}

}

class EditcountHTML extends Editcount {
	/**
	 * @access private
	 * @var array
	 */
	var $nscount;
	var $nscountall;

	/**
	 * @access private
	 * @var int
	 */
	var $total;
	var $totalall;

	/**
	 * Output the HTML form on Special:Editcount
	 *
	 * @param string $username
	 * @param int    $uid
	 * @param array  $nscount
	 * @param int    $total
	 */
	function outputHTML( $username, $uid, $nscount, $total, $nscountall, $totalall ) {
		global $wgTitle, $wgOut, $wgLang;
		wfProfileIn( __METHOD__ );

		/* current wiki */
		$this->nscount = $nscount;
		$this->total = $total;
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
		$wgOut->addHTML( $oTmpl->render("main-form") );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Make the editcount-by-namespaces HTML table
	 *
	 * @access private
	 */
	function makeTable() {
		global $wgLang, $wgCityId, $wgDBname;
        wfProfileIn( __METHOD__ );

		$total = wfMessage( 'editcount_total' )->escaped();
		$wikiName = $wgDBname;
		/* current wiki */
		$ftotal = $wgLang->formatNum( $this->total );
		$percent = ($this->total > 0) ? wfPercent( $this->total / $this->total * 100 , 2 ) : wfPercent( 0 ); // @bug 4400
		/* all wikis */
		$ftotalall = $wgLang->formatNum( $this->totalall );
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
            "nstotal"		=> $this->total,
            "nscountall"	=> $this->nscountall,
            "nstotalall"	=> $this->totalall,
            "wgLang"		=> $wgLang,
        ));
        $res = $oTmpl->render("table");
        wfProfileOut( __METHOD__ );
        return $res;
	}
}
