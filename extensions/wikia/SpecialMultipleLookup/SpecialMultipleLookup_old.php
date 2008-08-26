<?php
/*
	Shared Contributions - displays user's contributions from multiple wikis
*/

if(!defined('MEDIAWIKI'))
   die();

define ('MULTILOOKUP_NO_CACHE', true) ;

$wgAvailableRights[] = 'multilookup';
$wgGroupPermissions['staff']['multilookup'] = true;

/* add data to tables */
$wgExtensionFunctions[] = 'wfMultiLookupPageSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Multiple Lookup',
   'author' => 'Bartek Lapinski',
   'description' => 'Provides user lookup on multiple wikis'
);

/* special page setup function */
function wfMultiLookupPageSetup () {
	global $IP, $wgMessageCache;
	require_once($IP. '/includes/SpecialPage.php');
       	/* messages for the extension */
        $wgMessageCache->addMessages(
        array(
		'multilookup_title' => 'Multiple Lookup User' ,
		'multilookup_help' => 'Search for accounts of the same user on multiple wikis.' ,
		'multilookup_subtitle' => 'looking for accounts of $1'
                )
        );

   /* name, restrictions, */
   SpecialPage::addPage(new SpecialPage('MultiLookup', 'multilookup', true, 'wfMultiLookupCore', false));
   $wgMessageCache->addMessage('multilookup', 'Multi Lookup User');
}

/* special page core function */
function wfMultiLookupCore () {
global $wgOut, $wgUser, $wgRequest, $wgUser ;
        $wgOut->setPageTitle( wfMsg('multilookup_title') ) ;
	$scF = new MultiLookupForm () ;
	$scF->showForm ('') ;
	$scL = new MultiLookupList () ;
        $scL->showList ('') ;
}

/* form class */
class MultiLookupForm {
	/* constructor */
	function MultiLookupForm () {

	}

	/* draws select and selects it properly */
	function makeSelect ($name, $options_array, $current) {
        	global $wgOut ;
		$wgOut->addHTML ("<select name=\"$name\">") ;
		foreach ($options_array as $key => $value) {
			if ($value == $current )
	                	$wgOut->addHTML ("<option value=\"$value\" selected=\"selected\">$key</option>") ;
			else
	                	$wgOut->addHTML ("<option value=\"$value\">$key</option>") ;
		}
		$wgOut->addHTML ("</select>") ;
	}

	/* draws the form itself  */
	function showForm ($error) {
		global $wgOut, $wgRequest ;

		/* on error, display error */
                if ( "" != $error ) {
                        $wgOut->addHTML ("<p class='error'>{$error}</p>\n") ;
                }

		$titleObj = Title::makeTitle( NS_SPECIAL, 'MultiLookup' );
		/* help and stuff */
                $action = $titleObj->escapeLocalURL ("");

		$wgOut->addWikiText (wfMsg('multilookup_help')) ;
		$wgOut->addHTML ("
			<form method=\"post\" action=\"$action\" >
				Select user: <input name=\"wpIP\" id=\"wpIP\" value=\"" . $wgRequest->getVal ('wpIP') . "\"/>&#160;&#160;
				Search for: &#160;
		") ;

		$wgOut->addHTML ("
				&#160;
				<input type=\"submit\" value=\"Go\" name=\"wpSubmit\">
			</form><br/>
		") ;

	}
}

/* list class  */
class MultiLookupList {
	var $numResults, $mIP  ;

	/* constructor */
	function MultiLookupList () {
		global $wgRequest ;
		$this->numResults = 0 ;
		$this->mIP =  $wgRequest->getVal ('wpIP') ;
	}

        /* show it up */
	function showList ($error) {
		global $wgOut, $wgRequest ;

		/* before, we need that numResults */
		$this->numResults = 0 ;
		$wikias = $this->fetchWikias () ;
		$fetched_all = array () ;
		if (is_array($wikias)) {
			foreach ($wikias as $wiki) {
				/* just fetch, don't display it yet */
				$fetched_all = $this->fetchContribs ($wiki->city_dbname, $wiki->city_url, $fetched_all, $wiki->city_title) ;
			}
		}

		$this->showPrevNext ($wgOut) ;
		$this->limitResult ($fetched_all) ;
		$wgOut->addHTML ("</tbody></table>") ;
		$this->showPrevNext ($wgOut) ;
	}

	/* return if such user exists */
	function checkUser ($name) {
		global $wgSharedDB, $wgUser ;

		/* for all those anonymous users out there */
		if ($wgUser->isIP($name)) {
			return true ;
		}
                $dbr =& wfGetDB( DB_SLAVE );
                $s = $dbr->selectRow( 'user', array( 'user_id' ), array( 'user_name' => $name ) );

                if ( $s === false ) {
                        return 0;
                } else {
                        return $s->user_id;
                }
	}

	/* limit results */
	function limitResult ($result_array) {
		global $wgOut, $wgRequest ;
		/* no matches found? */
		if ( (0 == count($result_array)) && ($wgRequest->getVal ('wpSubmit') == 'Go') ) {
			$wgOut->addWikiText("'''There are no results found.'''") ;
			return false ;
		}
		$range = 0 ;
		/* sort by timestamps in descending order */
		ksort ($result_array) ;
	        $result_array = array_reverse ($result_array);
		/* now, renumerate array */
		$result_array = array_values ($result_array) ;
		list( $limit, $offset ) = $wgRequest->getLimitOffset() ;
		( count ($result_array) < ($limit + $offset) ) ? $range = count ($result_array) : $range = ($limit + $offset)  ;
		for ($i = $offset; $i < $range; $i++) {
			$wgOut->addWikiText ("'''".$result_array[$i]->user_name."''' on ".$result_array[$i]->res_url." edited from IP address ".$this->mIP."\n") ;
		}

	}

	/* fetch all wikias from the database */
	function fetchWikias () {
        	global $wgMemc, $wgSharedDB ;
		$key =  "$wgSharedDB:MultiLookup:wikias" ;
                $cached = $wgMemc->get ($key) ;
		if (!is_array ($cached) || MULTILOOKUP_NO_CACHE) {
			/* from database */
			$dbr =& wfGetDB (DB_SLAVE);
			$query = "SELECT city_dbname, city_url, city_title FROM ". wfSharedTable("city_list");
			$res = $dbr->query ($query) ;
			$wikias_array = array () ;
			while ($row = $dbr->fetchObject($res)) {
				array_push ($wikias_array, $row ) ;
			}
			$dbr->freeResult ($res) ;
			if (!MULTILOOKUP_NO_CACHE) $wgMemc->set ($key, $wikias_array) ;
			return $wikias_array ;
		} else {
			/* from memcached */
			return $cached ;
		}
	}

        /* init for showprevnext */
        function showPrevNext( &$out ) {
                global $wgContLang, $wgRequest;
                list( $limit, $offset ) = $wgRequest->getLimitOffset();
                $wpIP = 'wpIP=' . urlencode ( $this->mIP ) ;
		$bits = implode ("&", array ($wpIP) ) ;
                $html = wfViewPrevNext(
                                $offset,
                                $limit,
                                $wgContLang->specialpage( 'MultiLookup' ),
                                $bits,
                                ($this->numResults - $offset) <= $limit
                        );
                $out->addHTML( '<p>' . $html . '</p>' );
        }

	/* fetch all contributions from that given database */
	function fetchContribs ($database, $url, $fetched_array, $wikia) {
		global $wgOut, $wgRequest, $wgLang, $wgMemc, $wgSharedDB ;

		$fetched_data = array () ;
			/* get that data from database */
			$dbr =& wfGetDB (DB_SLAVE);

			/* check if such database exists... */
			if ($dbr->selectDB ($database)) {
                        	$query = "SELECT user_name, rc_ip FROM ".
					  wfSharedTable("user"). ", `$database`.recentchanges
					  WHERE user_id = rc_user and rc_ip = ". $dbr->addQuotes ($this->mIP) ."
					  GROUP BY user_name" ;

		        	$res = $dbr->query ($query) ;
				while ($row = $dbr->fetchObject ($res)) {
					$row->res_database = $database ;
					$row->res_url = $url ;
					$row->res_city_title = $wikia ;
					$fetched_data[] = $row ;
				}
				$this->numResults += $dbr->numRows ($res) ;
				$dbr->freeResult ($res) ;
				$fetched_array = $fetched_array + $fetched_data ;
			}
			return $fetched_array ;
	}
}

?>
