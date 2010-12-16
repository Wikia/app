<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

global $IP;
require_once( $IP . "/includes/SpecialPage.php" );
require_once( "SMW_NotAjaxAccess.php" );

global $smwgNMIP;

require_once( $smwgNMIP . '/includes/SMW_NotifyProcessor.php' );

/*
 * Standard class that is resopnsible for the creation of the Special Page
 */
class SMWNotifyMe extends SpecialPage {
	public function __construct() {
		parent::__construct( 'NotifyMe' );
	}
/*
 * Overloaded function that is responsible for the creation of the Special Page
 */
	public function execute() {

		global $wgRequest, $wgOut, $smwgNMScriptPath, $wgUser;

		# Get query parameters
		$feedFormat = $wgRequest->getVal( 'feed' );
		if ( $feedFormat == 'rss' ) {
			# 10 seconds server-side caching max
			$wgOut->setSquidMaxage( 10 );

			global $smwgNMMaxFeedItems;
			$limit = ( $smwgNMMaxFeedItems > 0 ) ? $smwgNMMaxFeedItems : 20;

			$dbr = wfGetDB( DB_SLAVE );
			$id = $wgRequest->getVal( 'uid' );
			$type = "uid";
			if ( $id ) {
				# Get last modified date, for client caching
				# Don't use this if we are using the patrol feature, patrol changes don't update the timestamp
				$lastmod = $dbr->selectField( 'smw_nm_rss', 'MAX(timestamp)', array( 'user_id' => $id ), 'NotifyMeRSS' );
			} else {
				$type = "nid";
				$id = $wgRequest->getVal( 'nid' );
				$lastmod = $dbr->selectField( 'smw_nm_rss', 'MAX(timestamp)', array( 'notify_id' => $id ), 'NotifyMeRSS' );
			}
			if ( $lastmod && $wgOut->checkLastModified( $lastmod ) ) {
				# Client cache fresh and headers sent, nothing more to do.
				return;
			}
			$this->rcOutputFeed( $feedFormat, $type, $id, $limit, $lastmod, true );
		} else {
			$user_id = $wgUser->getId();

			$wgOut->setPageTitle( wfMsg( 'smw_notifyme' ) );

			if ( $user_id > 0 ) {
				$isSysop = in_array( 'sysop', $wgUser->getEffectiveGroups() );
				if ( $isSysop ) {
					SMWNotifyMe::addAutocomplete();
				}

				$imagepath = $smwgNMScriptPath . '/skins/images/';

				$html = '<div id="nmcontent">
					<div id="shade" style="display:none"></div>
					<div id="fullpreviewbox" style="display:none">
					<div id="fullpreview"></div>
					<span class="nmbutton" onclick="$(\'fullpreviewbox\', \'shade\').invoke(\'toggle\')"><img src="' . $imagepath . 'delete.png"/>Close Preview</span></div>
					<div id="nmlayout">
						<div id="querytitle" onclick="notifyhelper.switchquery()" onmouseover="Tip(\'' . wfMsg( 'smw_nm_tt_query' ) . '\')"><a id="querytitle-link" class="minusplus" href="javascript:void(0)"></a>Notify Me Query</div>
						<div id="querycontent">' . $this->getQueryLayout() . '</div>
						<div id="layouttitle" onclick="notifyhelper.switchlayout()" onmouseover="Tip(\'' . wfMsg( 'smw_nm_tt_nmm' ) . '\')"><a id="layouttitle-link" class="minusplus" href="javascript:void(0)"></a>Notify Me Manager</div>
						<div id="layoutcontent">' . $this->getNotifyTable() . '</div>
					</div>
				</div>';

				global $wgEmailAuthentication, $wgEnableEmail;
				if ( $wgEnableEmail ) {
					if ( $wgEmailAuthentication && ( $wgUser->getEmail() != '' ) ) {
						if ( $wgUser->getEmailAuthenticationTimestamp() ) {
							$disableEmailPrefs = false;
						} else {
							$disableEmailPrefs = true;
						}
					} else {
						$disableEmailPrefs = false;
					}
					$eEmail = $wgUser->getOption( 'enotifyme' );
					$html .= '<div class="nmmenubar">
					<input id="nmemail" type="checkbox" value="1"' . ( $disableEmailPrefs ? ' disabled':'' ) . ( $eEmail ? ' checked':'' ) . '/> Enable \'Notify Me\' by E-mail ';
					if ( $disableEmailPrefs ) {
						$href = htmlspecialchars( $wgUser->getSkin()->makeSpecialUrl( 'Preferences' ) );
						$text = htmlspecialchars( wfMsg( 'mypreferences' ) );
						$html .= " (Please enable your email account in '<a href=\"$href\">$text</a>'. )";
					}
					$html .= '</div>';
				}

				$html .= '<div>
					RSS Feed : <input id="nmrss" size="80" type="text" title="RSS feed url" value="' . $this->getTitle()->getFullURL( 'feed=rss&uid=' . $user_id ) . '" />&nbsp;&nbsp;
					<button class="btn" onclick="notifyhelper.copyToClipboard(\'nmrss\')" onmouseover="this.className=\'btn btnhov\'; Tip(\'' . wfMsg( 'smw_nm_tt_clipboard' ) . '\')" onmouseout="this.className=\'btn\'">' . wfMsg( 'smw_qi_clipboard' ) . '</button>
				</div>';

				$html .= '<script type="text/javascript" src="' . $smwgNMScriptPath .  '/scripts/NotifyMe/nm_tooltip.js"></script>';
			} else {
				$html = '<div id="nmlayout">You have not logged in, please login first. Thanks.</div>';
			}
			$wgOut->addHTML( $html );
		}
	}
	private function getQueryLayout() {
		global $wgUser;
		$isSysop = in_array( 'sysop', $wgUser->getEffectiveGroups() );

		$html = '<table style="width: 100%;"><tr><td width=40%>
		<table width=100%>
		<tr><th width=40%>Name :</th><td width=60% onmouseover="Tip(\'Name of the notification\')"><input type="text" id="nmqname"></td></tr>
		<tr><th nowrap>Report all :</th><td onmouseover="Tip(\'Report all semantic semantic attribes\\\' change of monitored pages\')"><input type="checkbox" checked id="nmqrall"></td></tr>
		<tr><th nowrap>Show all :</th><td onmouseover="Tip(\'Show all query results with notifications\')"><input type="checkbox" id="nmqsall"></td></tr>';
		if ( $isSysop ) {
			$html .= '<tr><th nowrap>Delegate to :</th><td><input type="text" id="nmd_new" size=35>
				<div class="page_name_auto_complete" id="nmdiv_new"></div></td>';
		}
		$html .= '</table></td><td width=60%><table style="width: 100%;">
		<tr><th onmouseover="Tip(\'' . wfMsg( 'smw_nm_tt_qtext' ) . '\')">Query (table format, all link only)</th></tr>
		<tr><td onmouseover="Tip(\'Full query string, with {{#ask syntax\')">
			{{#ask:<br/>
			<textarea id="nmquery" cols="20" rows="6"></textarea><br/>
			| format=table<br/>
			| link=all<br/>
			|}}
		</td></tr>
		</table>
		</td></tr></table>
		<div class="nmmenubar">
		<div style="text-align:left;float:left;">
		<button class="btn" onclick="notifyhelper.previewQuery()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Show full preview of your query results\')" onmouseout="this.className=\'btn\'">Preview Results</button>
		<button class="btn" onclick="notifyhelper.doSaveToNotify(' . $isSysop . ')" onmouseover="this.className=\'btn btnhov\'; Tip(\'Add this notification to you NotifyMe\')" onmouseout="this.className=\'btn\'">Add to NotifyMe</button>
		</div><div style="text-align:right;">
		<button class="btn" onclick="notifyhelper.resetQuery()"onmouseout="this.className=\'btn\'" onmouseover="this.className=\'btn btnhov\'; Tip(\'Resets the entire query\')">Reset Query</button>
		</div></div>';

		return $html;
	}

	static function addAutocomplete() {
		global $smwgNMDelegateQuery, $smwgNMDelegateUserGroup;
		if ( !$smwgNMDelegateQuery && !$smwgNMDelegateUserGroup ) return;

		global $wgOut, $smwgNMScriptPath;
		$nmScriptPath = $smwgNMScriptPath . '/specials/SMWNotifyMe';
		$nmYUIBase = "http://yui.yahooapis.com/2.7.0/build/";

		$wgOut->addLink( array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => "screen, projection",
			'href' => $nmScriptPath . '/skins/NM_yui_autocompletion.css'
			) );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'yahoo/yahoo-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'dom/dom-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'event/event-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'get/get-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'connection/connection-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'json/json-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'datasource/datasource-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmYUIBase . 'autocomplete/autocomplete-min.js"></script>' . "\n" );
		$wgOut->addScript( '<script type="text/javascript" src="' . $nmScriptPath . '/libs/NM_yui_autocompletion.js"></script>' . "\n" );

		$pages = array();
		if ( $smwgNMDelegateUserGroup ) {
			if ( $smwgNMDelegateUserGroup != "*" && !is_array( $smwgNMDelegateUserGroup ) ) {
				$groups = split( ",", $smwgNMDelegateUserGroup );
				for ( $i = count( $groups ) - 1; $i >= 0; --$i ) {
					$groups[$i] = strtolower( trim( str_replace( "\'", "\\\'", $groups[$i] ) ) );
				}
			}
			$pages = NMStorage::getDatabase()->getGroupedUsers( $groups );
			for ( $i = count( $pages ) - 1; $i >= 0; --$i ) {
				$pages[$i] = "['" . str_replace( "\'", "\\\'", $pages[$i] ) . "']";
			}
		}
		if ( $smwgNMDelegateQuery ) {
			global $smwgQDefaultNamespaces, $smwgQFeatures;
			$qp = new SMWQueryParser( $smwgQFeatures );
			$qp->setDefaultNamespaces( $smwgQDefaultNamespaces );
			$desc = $qp->getQueryDescription( $smwgNMDelegateQuery );

			$desc->prependPrintRequest( new SMWPrintRequest( SMWPrintRequest::PRINT_THIS, "" ) );

			$query = new SMWQuery( $desc, true );

			$query_result = smwfGetStore()->getQueryResult( $query );
			while ( $res = $query_result->getNext() ) {
				$pages[] = "['" . str_replace( "\'", "\\\'", $res[0]->getNextObject()->getWikiValue() ) . "']";
			}
		}
		global $smwgNMMaxAutocompleteValues;
		if ( $smwgNMMaxAutocompleteValues <= 0 ) {
			$smwgNMMaxAutocompleteValues = 10;
		}
		$wgOut->addScript( '<script type="text/javascript">
		nmautocompletestrings = [' . join( ',', $pages ) . '];
		nmMaxResultsDisplayed = ' . $smwgNMMaxAutocompleteValues . ';
		</script>' );
	}
	private function getNotifyTable() {
		global $wgUser;
		$isSysop = in_array( 'sysop', $wgUser->getEffectiveGroups() );

		$cols = 6;
		$html = '<table width="100%" class="smwtable" id="nmtable">
			<tr><th width="5%" onmouseover="Tip(\'Select notifications to be deleted\')">Delete?</th>
				<th width="20%" onmouseover="Tip(\'Name of the notification\')">Name</th>
				<th width="40%" onmouseover="Tip(\'Full query string, with {{#ask syntax\')" nowrap>Query String</th>
				<th width="5%" onmouseover="Tip(\'Report all semantic semantic attribes\\\' change of monitored pages\')" nowrap>Report All</th>
				<th width="5%" onmouseover="Tip(\'Show all query results with notifications\')" nowrap>Show All</th>
				<th width="5%" onmouseover="Tip(\'Current state of notification. Enabled?\')">Enabled?</th>';
		if ( $isSysop ) {
			$cols ++;
			$html .= '<th width="20%" onmouseover="Tip(\'Add delegate users to recieve NotifyMe, separated by comma\')">Delegate</th>';
		}
		$html .= '</tr>';
		$notifications = SMWNotifyProcessor::getNotifications();
		if ( $notifications != null ) {
			foreach ( $notifications as $row ) {
				$html .= '<tr>
					<td><input type="checkbox" name="nmdel" value=' . $row['notify_id'] . '></td>
					<td><a target="_blank" href="' . $this->getTitle()->getFullURL( 'feed=rss&nid=' . $row['notify_id'] ) . '">' . $row['name'] . '</a></td>
					<td>' . str_replace( "\n", "<br/>", $row['query'] ) . '</td>
					<td><input type="checkbox" ' . ( $row['rep_all'] ? 'checked':'' ) . ' name="nmall" value=' . $row['notify_id'] . '></td>
					<td><input type="checkbox" ' . ( $row['show_all'] ? 'checked':'' ) . ' name="nmsall" value=' . $row['notify_id'] . '></td>
					<td><input type="checkbox" ' . ( $row['enable'] ? 'checked':'' ) . ' name="nmenable" id="nmenable_' . $row['notify_id'] . '" value=' . $row['notify_id'] . '></td>';
				if ( $isSysop ) {
					$html .= '<td><input type="text" name="nmdelegate" id=nmd_' . $row['notify_id'] . ' value="' . $row['delegate'] . '">
					<div class="page_name_auto_complete" id="nmdiv_' . $row['notify_id'] . '"></div></td>';
				}
				$html .= '</tr>';
			}
		}
		$html .= '<tr id="nmtoolbar">
					<td><a href="#" onclick="notifyhelper.delall(true)">ALL</a>/<a href="#" onclick="notifyhelper.delall(false)">NONE</a>&nbsp; <button class="btn" onclick="notifyhelper.deleteNotify()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Delete the checked notifications\')" onmouseout="this.className=\'btn\'">Update</button></td>
					<td></td><td></td>
					<td><a href="#" onclick="notifyhelper.reportall(true)">ALL</a>/<a href="#" onclick="notifyhelper.reportall(false)">NONE</a>&nbsp; <button class="btn" onclick="notifyhelper.updateReportAll()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Report all semantic attributes\\\' change on checked notifications\')" onmouseout="this.className=\'btn\'">Update</button></td>
					<td><a href="#" onclick="notifyhelper.showall(true)">ALL</a>/<a href="#" onclick="notifyhelper.showall(false)">NONE</a>&nbsp; <button class="btn" onclick="notifyhelper.updateShowAll()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Show all query results with notifications\')" onmouseout="this.className=\'btn\'">Update</button></td>
					<td><a href="#" onclick="notifyhelper.enableall(true)">ALL</a>/<a href="#" onclick="notifyhelper.enableall(false)">NONE</a>&nbsp; <button class="btn" onclick="notifyhelper.updateStates()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Update the states of your notifications, enable or disable them\')" onmouseout="this.className=\'btn\'">Update</button></td>';
		if ( $isSysop )
			$html .= '<td><button class="btn" onclick="notifyhelper.updateDelegate()" onmouseover="this.className=\'btn btnhov\'; Tip(\'Update delegate\')" onmouseout="this.className=\'btn\'">Update</button></td>';
		$html .= '</tr></table>';
		return $html;
	}

	// rss feed related features
	function rcOutputFeed( $feedFormat, $type, $id, $limit, $lastmod, $queryresult_item = false ) {
		global $messageMemc, $wgFeedCacheTimeout;
		global $wgFeedClasses, $wgTitle, $wgSitename, $wgContLanguageCode;

		if ( !isset( $wgFeedClasses[$feedFormat] ) ) {
			wfHttpError( 500, "Internal Server Error", "Unsupported feed type." );
			return false;
		}

		$timekey = wfMemcKey( 'nmfeed', $feedFormat, $type, $id, 'timestamp' );
		$key = wfMemcKey( 'nmfeed', $feedFormat, $type, $id, 'limit', $limit );

		// purge cache if requested
		global $wgRequest, $wgUser;
		$purge = $wgRequest->getVal( 'action' ) == 'purge';
		if ( $purge && $wgUser->isAllowed( 'purge' ) ) {
			$messageMemc->delete( $timekey );
			$messageMemc->delete( $key );
		}

		/**
		 * Bumping around loading up diffs can be pretty slow, so where
		 * possible we want to cache the feed output so the next visitor
		 * gets it quick too.
		 */
		$cachedFeed = false;
		if ( ( $wgFeedCacheTimeout > 0 ) && ( $feedLastmod = $messageMemc->get( $timekey ) ) ) {
			/**
			 * If the cached feed was rendered very recently, we may
			 * go ahead and use it even if there have been edits made
			 * since it was rendered. This keeps a swarm of requests
			 * from being too bad on a super-frequently edited wiki.
			 */
			if ( time() - wfTimestamp( TS_UNIX, $feedLastmod ) < $wgFeedCacheTimeout ||
				wfTimestamp( TS_UNIX, $feedLastmod ) > wfTimestamp( TS_UNIX, $lastmod ) ) {
				wfDebug( "RC: loading feed from cache ($key; $feedLastmod; $lastmod)...\n" );
				$cachedFeed = $messageMemc->get( $key );
			} else {
				wfDebug( "RC: cached feed timestamp check failed ($feedLastmod; $lastmod)\n" );
			}
		}

		$feedTitle = $wgSitename . ' - Recent changes to ';
		if ( $type = "nid" ) {
			$dbr = wfGetDB( DB_SLAVE );
			$notify_name = $dbr->selectField( 'smw_nm_query', 'name', array( 'notify_id' => $id ), 'NotifyMeRSS' );
			$feedTitle .= "\"$notify_name\"";
		} else {
			$feedTitle .= "Notify Me";
		}
		$feedTitle .= ' [' . $wgContLanguageCode . ']';

		$feed = new $wgFeedClasses[$feedFormat](
			$feedTitle,
			'Track the most recent changes to ' . ( $notify_name ? "\"$notify_name\"":'Notify Me' ) . ' in this feed.',
			$wgTitle->getFullUrl() );

		if ( is_string( $cachedFeed ) ) {
			wfDebug( "RC: Outputting cached feed\n" );
			$feed->httpHeaders();
			echo $cachedFeed;
		} else {
			wfDebug( "RC: rendering new feed and caching it\n" );
			ob_start();
			$this->rcDoOutputFeed( $feed, $queryresult_item, $type, $id, $limit );
			$cachedFeed = ob_get_contents();
			ob_end_flush();

			$expire = 3600 * 24; # One day
			$messageMemc->set( $key, $cachedFeed );
			$messageMemc->set( $timekey, wfTimestamp( TS_MW ), $expire );
		}
		return true;
	}

	function rcDoOutputFeed( &$feed, $queryresult_item, $type, $id, $limit ) {
		wfProfileIn( __METHOD__ );

		$feed->outHeader();

		if ( $queryresult_item && $type == "nid" ) {
			$dbr = wfGetDB( DB_SLAVE );
			$showall = $dbr->selectField( 'smw_nm_query', 'show_all', array( 'notify_id' => $id ), 'NotifyMeRSS' );
			if ( $showall ) {
				$query = $dbr->selectField( 'smw_nm_query', 'query', array( 'notify_id' => $id ), 'NotifyMeRSS' );
				SMWQueryProcessor::processFunctionParams( explode( "\n", $query ), $querystring, $params, $printouts );
				$query  = SMWQueryProcessor::createQuery( $querystring, $params, SMWQueryProcessor::INLINE_QUERY, 'auto', $printouts );
				$res = smwfGetStore()->getQueryResult( $query );

				$items = array();
				$labels = array();
				foreach ( $res->getPrintRequests() as $pr ) {
					$labels[] = $pr->getText( SMW_OUTPUT_WIKI );
				}
				$row = $res->getNext();
				$linker = new Linker();
				while ( $row !== false ) {
					$wikipage = $row[0]->getNextObject(); // get the object
					$a = new Article( $wikipage->getTitle() );
					$description = "<table style=\"width: 60em; font-size: 90%; border: 1px solid #aaaaaa; background-color: #f9f9f9; color: black; margin-bottom: 0.5em; margin-left: 1em; padding: 0.2em; clear: right; text-align:left;\"><tr><th style=\"text-align: center; background-color:#ccccff;\" colspan=\"2\"><big>" . $wikipage->getText() . "</big></th></tr>";
					$idx = 0;
					foreach ( $row as $field ) {
						$description .= "<tr><td>" . $labels[$idx] . "</td><td>";
						$first_value = true;
						while ( ( $object = $field->getNextObject() ) !== false ) {
							if ( $first_value ) $first_value = false; else $description .= ', ';
							$description .= $object->getShortText( SMW_OUTPUT_HTML, $linker );
						}
						$description .= "</td></tr>";
						$idx ++;
					}
					$description .= "</table>";
					$items[] = array ( 'title' => $wikipage->getText(), 'notify' => $description, 'timestamp' => $a->getTimestamp() );
					$row = $res->getNext();
				}
			} else {
				$items = NMStorage::getDatabase()->getNotifyRSS( $type, $id, $limit );
			}
		} else {
			$items = NMStorage::getDatabase()->getNotifyRSS( $type, $id, $limit );
		}
		foreach ( $items as $i ) {
			if ( isset( $i['link'] ) && $i['link'] ) {
				$item = new FeedItem(
					$i['title'],
					$i['notify'],
					$i['link'],
					$i['timestamp']
				);
			} else {
				$title = Title::makeTitle( NS_MAIN, $i['title'] );
				$talkpage = $title->getTalkPage();
				$item = new FeedItem(
					$title->getPrefixedText(),
					$i['notify'],
					$title->getFullURL(),
					$i['timestamp'],
					"",
					$talkpage->getFullURL()
				);
			}
			$feed->outItem( $item );
		}

		$feed->outFooter();
		wfProfileOut( __METHOD__ );
	}
}
