<?php

/*
	A special page providing means to manually refresh special pages
*/
if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'refreshspecial';
$wgGroupPermissions['staff']['refreshspecial'] = true;

$wgExtensionFunctions[] = 'wfRefreshSpecialSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Refresh Special',
   'author' => 'Bartek',
   'description' => 'allows manual special page refresh of special pages'
);

/* limits the number of refreshed rows */
define ('REFRESHSPECIAL_ROW_LIMIT', 1000) ;
/* interval between reconnects */
define ('REFRESHSPECIAL_RECONNECTION_SLEEP', 10) ;
/* amount of acceptable slave lag  */
define ('REFRESHSPECIAL_SLAVE_LAG_LIMIT', 600) ;
/* interval when slave is lagged */
define ('REFRESHSPECIAL_SLAVE_LAG_SLEEP', 30) ;

/* special page init */
function wfRefreshSpecialSetup() {
	global $IP, $wgMessageCache;
	require_once ($IP. '/includes/SpecialPage.php') ;
	require_once ($IP. '/includes/QueryPage.php') ;

        /* add messages to all the translator people out there to play with */
        $wgMessageCache->addMessages(
        array(
		'refreshspecial_title' => 'Refresh Special Pages' ,
		'refreshspecial_help' =>  'This special page provides means to manually refresh special pages. When you have chosen all pages that you want to refresh, click on the Refresh button below to make it go. Warning: the refresh may take a while on larger wikis.' ,
		'refreshspecial_button' => 'Refresh selected' ,
		'refreshspecial_refreshing' => 'refreshing special pages' ,
		'refreshspecial_skipped' => 'cheap, skipped' ,
		'refreshspecial_success_subtitle' => 'refreshing special pages' ,
		'refreshspecial_choice' => 'refreshing special pages' ,
		'refreshspecial_js_disabled' => '(<i>You cannot select all pages when Javascript is disabled</i>)' ,
		'refreshspecial_select_all_pages' => ' select all pages ' ,
		'refreshspecial_link_back' => 'Get back to extension ' ,
		'refreshspecial_here' => '<b>here</b>' ,
		'refreshspecial_none_selected' => 'You haven\'t selected any special pages. Reverting to default selection.' ,
		'refreshspecial_db_error' => 'FAILED: database error' ,
		'refreshspecial_no_page' => 'No such special page' ,
		'refreshspecial_slave_lagged' => 'Slave lagged, waiting...' ,
		'refreshspecial_reconnected' => 'Reconnected.' ,
		'refreshspecial_reconnecting' => 'Connection failed, reconnecting in 10 seconds...' ,
		'refreshspecial_total_display' => '<br/>Refreshed $1 pages totalling $2 rows in time $3 (complete time of the script run is $4)'
                )
        );
	SpecialPage::addPage(new SpecialPage('Refreshspecial', 'refreshspecial', true, 'wfRefreshSpecial', false));
	$wgMessageCache->addMessage('refreshspecial', 'Refresh special pages');
}

/* the core */
function wfRefreshSpecial () {
	global $wgOut, $wgUser, $wgRequest ;
   	$wgOut->setPageTitle (wfMsg('refreshspecial_title'));
	$cSF = new RefreshSpecialForm () ;

	$action = $wgRequest->getVal ('action') ;
	if ('success' == $action) {
		/* do something */
	} else if ('failure' == $action) {
		$cSF->showForm ('Please check at least one special page to refresh.') ;
	} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
	        $wgUser->matchEditToken( $wgRequest->getVal ('wpEditToken') ) ) {
	        $cSF->doSubmit () ;
	} else {
		$cSF->showForm ('') ;
	}
}

/* display the form */
class RefreshSpecialForm {
	var $mMode ;

	/* constructor */
	function RefreshSpecialForm () {
		global $wgRequest ;
	}

	/* output */
	function showForm ( $err ) {
		global $wgOut, $wgUser, $wgRequest, $wgQueryPages ;
	
		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Refreshspecial' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		$wgOut->addWikiText (wfMsg('refreshspecial_help')) ;

		( 'submit' == $wgRequest->getVal( 'action' )) ? $scLink = htmlspecialchars ($this->mLink) : $scLink = '' ;

   		$wgOut->addHtml("
<form name=\"CleanupSpam\" method=\"post\" action=\"{$action}\"><ul>") ;

		/* list pages right here */

		/* todo display a time estimate or a raw factor 
			I guess it's not that important, since we have a 1000 rows limit on refresh?
			that brings up an interesting question - do we need that limit or not?
		*/
		foreach ( $wgQueryPages as $page ) {
		        @list( $class, $special, $limit ) = $page;

		        $specialObj = SpecialPage::getPage( $special );
		        if ( !$specialObj ) {
	        	        $wgOut->addWikiText (wfMsg ('refreshspecial_no_page') . " $special\n") ;
		                exit;
		        }
		        $file = $specialObj->getFile();
		        if ( $file ) {
		                require_once( $file );
		        }
		        $queryPage = new $class;
			$checked = '' ;
			if ( $queryPage->isExpensive() ) {
				$checked = "checked=\"checked\"" ;
				$wgOut->addHTML ("
					<li>
						<input type=\"checkbox\" name=\"wpSpecial[]\"  value=\"$special\" $checked />				
						<b>$special</b>
					</li>									
				") ;				
			}
                }
	
	       $wgOut->addHTML (" 
	                          <li>
				  	<input type=\"checkbox\" name=\"check_all\" id=\"refreshSpecialCheckAll\" onclick=\"refreshSpecialCheck(this.form);\" /><label for=\"refreshSpecialCheckAll\">".wfMsg ('refreshspecial_select_all_pages') ."
				  <noscript>".wfMsg ('refreshspecial_js_disabled')."
				  </noscript>") ;
				  $wgOut->addHTML("
					</label>
				  </li>
				  <script type=\"text/javascript\">
					function refreshSpecialCheck (form) {
						pattern = document.getElementById ('refreshSpecialCheckAll').checked ;
						for (i=0; i<form.elements.length; i++) {
							if (form.elements[i].type == 'checkbox' && form.elements[i].name != 'check_all') {
								form.elements[i].checked = pattern ;
							}
						}
					}
				  </script>
				  </ul>
	       			  <input tabindex=\"5\" name=\"wpRefreshSpecialSubmit\" type=\"submit\" value=\"".wfMsg('refreshspecial_button')."\" />
				  <input type='hidden' name='wpEditToken' value=\"{$token}\" />
				  </form>");
	}

	/* take amount of elapsed time, produce hours (hopefully never needed...), minutes, seconds */
	function compute_time ($amount) {
		$return_array = array () ;
		$return_array['hours'] = intval( $amount / 3600 );
		$return_array['minutes'] = intval( $amount % 3600 / 60 );
		$return_array['seconds'] = $amount - $return_array['hours'] * 3600 - $return_array['minutes'] * 60;
		return $return_array ;
	}

	/* format the time message */
	function format_time_message ($time, &$message) {
		if ( $time['hours'] ) {
			$message .= $time['hours'] . 'h ';
		}
		if ( $minutes ) {
			$message .= $time['minutes'] . 'm ';
		}
		$message .= $time['seconds'] . 's' ;
		return true ;
	}

	/* will need to be modified further */
	function refreshSpecial () {
		global $wgRequest, $wgQueryPages, $wgLoadBalancer, $wgOut ;
		$dbw =& wfGetDB( DB_MASTER );
		$to_refresh = $wgRequest->getArray ('wpSpecial') ;
		$total = array (
				'pages' => 0 ,
				'rows' => 0 ,
		         	'elapsed' => 0 ,
                                'total_elapsed' => 0
			 );

		foreach ( $wgQueryPages as $page ) {
		        @list( $class, $special, $limit ) = $page;
                        if (!in_array ($special, $to_refresh)) {
				continue ;
			}

		        $specialObj = SpecialPage::getPage( $special );
		        if ( !$specialObj ) {
	        	        $wgOut->addWikiText (wfMsg('refreshspecial_no_page').": $special\n") ;
		                exit;
		        }
		        $file = $specialObj->getFile();
		        if ( $file ) {
		                require_once( $file );
		        }
		        $queryPage = new $class;

			$message = "" ;
		        if( !(isset($options['only'])) or ($options['only'] == $queryPage->getName()) ) {
				$wgOut->addHTML ("<b>$special</b>: ") ;

			        if ( $queryPage->isExpensive() ) {
	        		        $t1 = explode( ' ', microtime() );
		        	        # Do the query
		        	        $num = $queryPage->recache( $limit === null ? REFRESHSPECIAL_ROW_LIMIT : $limit );
			                $t2 = explode( ' ', microtime() );

	        		        if ( $num === false ) {
	        	        	        $wgOut->addHTML ( wfMsg('refreshspecial_db_error') . "<br/>") ;
			                } else {
	        		                $message = "got $num rows in " ;
	                		        $elapsed = ($t2[0] - $t1[0]) + ($t2[1] - $t1[1]);
						$total['elapsed'] += $elapsed;
						$total['rows'] += $num ;
						$total['pages']++ ;
						$ftime = $this->compute_time ($elapsed) ;
						$this->format_time_message ($ftime, $message) ;
						$wgOut->addHTML ("$message<br/>") ;
		        	        }
					$t1 = explode( ' ', microtime() );
			                # Reopen any connections that have closed
			                if ( !$wgLoadBalancer->pingAll())  {
		        	                $wgOut->addHTML ("<br/>") ;
	        	        	        do {
			                                $wgOut->addHTML (wfMsg ('refreshspecial_reconnecting') ."<br/>") ;
			                                sleep (REFRESHSPECIAL_RECONNECTION_SLEEP);
			                        } while ( !$wgLoadBalancer->pingAll() );
		        	                $wgOut->addHTML (wfMsg ('refreshspecial_reconnected') . "<br/><br/>") ;
			                } else {
			                        # Commit the results
			                        $dbw->immediateCommit();
			                }

			                # Wait for the slave to catch up
			                $slaveDB =& wfGetDB( DB_SLAVE, array('QueryPage::recache', 'vslow' ) );
			                while( $slaveDB->getLag() > REFRESHSPECIAL_SLAVE_LAG_LIMIT ) {
		        	                $wgOut->addHTML (wfMsg('refreshspecial_slave_lagged') ."<br/>") ;
		                	        sleep (REFRESHSPECIAL_SLAVE_LAG_SLEEP) ;					
			                }
					$t2 = explode( ' ', microtime() );
					$elapsed_total = ($t2[0] - $t1[0]) + ($t2[1] - $t1[1]);
					$total['total_elapsed'] += $elapsed + $elapsed_total ;
				} else {
					$wgOut->addHTML (wfMsg('refreshspecial_skipped')."<br/>") ;
			        }
			}
		}
		/* display all stats */
		$elapsed_message = '' ;
		$total_elapsed_message = '' ;
		$this->format_time_message ($this->compute_time ($total['elapsed']), $elapsed_message ) ;
		$this->format_time_message ($this->compute_time ($total['total_elapsed']), $total_elapsed_message ) ;
                $wgOut->addHTML (wfMsg ('refreshspecial_total_display', $total['pages'], $total['rows'], $elapsed_message, $total_elapsed_message ) ) ;
		$wgOut->addHTML ("</ul></form>") ;		
	}

	/* on success */
	function showSuccess () {
		global $wgOut, $wgRequest ;
		$wgOut->setPageTitle (wfMsg('refreshspecial_title') ) ;
		$wgOut->setSubTitle(wfMsg('refreshspecial_success_subtitle')) ;	
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest ;
		/* guard against an empty array */
		$array = $wgRequest->getArray ('wpSpecial') ;
		if (!is_array ($array) || empty ($array) || is_null($array)) {
			$this->showForm ( wfMsg('refreshspecial_none_selected') ) ;
			return ;
		}

		$wgOut->setSubTitle ( wfMsg ('refreshspecial_choice', wfMsg('refreshspecial_refreshing') ) ) ;
		$this->refreshSpecial () ;
		$sk = $wgUser->getSkin () ;
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Refreshspecial' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, wfMsg ('refreshspecial_here')) ;
		$wgOut->addHTML ("<br/>".wfMsg ('refreshspecial_link_back')." $link_back.") ;
	}
}

?>
