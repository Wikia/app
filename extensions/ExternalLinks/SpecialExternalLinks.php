<?php

class ExternalLinks extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		#global $wgVersion;
		parent::__construct( 'ExternalLinks', 'ExternalLinks' );
		#if ( version_compare( $wgVersion, '1.16', '<' ) ) {
			wfLoadExtensionMessages( 'ExternalLinks' );
		#}
	}

	function execute( $query ) {
		global $wgUser, $wgELuserRight, $wgOut;
		
		$this->setHeaders();
		
		if( !$wgELuserRight ) {
			$wgELuserRight = 'edit'; // default
		}
		if ( $wgUser->isAllowed( $wgELuserRight ) ) {
			// go ahead
			$this->ELdoExternalLinks();
		} else {
			// return error message
			$wgOut->addWikiMsg( 'badaccess-group0' );
			return false;
		}
	}
		
	// status-codes: http://www.w3.org/Protocols/rfc2616/rfc2616-sec6.html
	function headerResponseByNumber($respNum) {
		switch ( $respNum ) {
			case "100":
				$response = 'Continue';
				break;
			case "101":
				$response = 'Switching protocols';
				break;
			case "200":
				$response = 'OK';
				break;
			case "201":
				$response = 'Created';
				break;
			case "202":
				$response = 'Accepted';
				break;
			case "203":
				$response = 'Non-authoritative information';
				break;
			case "204":
				$response = 'No cntent';
				break;
			case "205":
				$response = 'Reset content';
				break;
			case "206":
				$response = 'Partial content';
				break;
			case "300":
				$response = 'Multiple choices';
				break;
			case "301":
				$response = 'Moved permanently and new target works. Might be smart to fix it as long as it redirects.';
				break;
			case "302":
				$response = 'Found, but might redirect';
				break;
			case "303":
				$response = 'See other';
				break;
			case "304":
				$response = 'Not modified';
				break;
			case "305":
				$response = 'Use proxy';
				break;
			case "307":
				$response = 'Temporary redirect';
				break;
			case "400":
				$response = 'Bad request';
				break;
			case "401":
				$response = 'Unauthorized';
				break;
			case "402":
				$response = 'Payment required';
				break;
			case "403":
				$response = 'Forbidden';
				break;
			case "404":
				$response = 'Not found';
				break;
			case "405":
				$response = 'Method not allowed';
				break;
			case "406":
				$response = 'Not acceptable';
				break;
			case "407":
				$response = 'Proxy authentication required';
				break;
			case "408":
				$response = 'Request time-out';
				break;
			case "409":
				$response = 'Conflict';
				break;
			case "410":
				$response = 'Gone';
				break;
			case "411":
				$response = 'Length required';
				break;
			case "412":
				$response = 'Precondition failed';
				break;
			case "413":
				$response = 'Request entity too large';
				break;
			case "414":
				$response = 'Request-URI too large';
				break;
			case "415":
				$response = 'Unsupported media type';
				break;
			case "416":
				$response = 'Requested range not satisfiable';
				break;
			case "417":
				$response = 'Expectation failed';
				break;
			case "500":
				$response = 'Internal server error';
				break;
			case "501":
				$response = 'Not implemented';
				break;
			case "502":
				$response = 'Bad gateway';
				break;
			case "503":
				$response = 'Service unavailable';
				break;
			case "504":
				$response = 'Gateway time-out';
				break;
			case "505":
				$response = 'HTTP version not supported';
				break;
			case "Domain not found?!":
				$response = '';
				break;
			default: 
				$response = '';
		}
		return $response;
	}
	
	function updateLastValidated( $link ) {
		//insert current date to 'el_last_validated'
		$currentDate = date('Y-m-d');
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'externallinks',
			array(
				'el_last_validated' => $currentDate,
			),
			array(
				'el_to' => $link
			),
			__METHOD__
		);
	}
	/* jQuery to hide if no link:
			if(($('#bodyContent').find('a').length)<1){
		    $('a#ELtoolboxLink').hide();   
			}
	*/
	
	function ELdoExternalLinks() {
		global $wgRequest, 
					 $wgELtableClass,
					 $wgELpageLinkClass,
					 $wgELvalidationMode,
					 $wgELmaxPerPage,
					 $wgELvalidationMaxPerPage,
					 $wgELenableSessionStoring,
					 $wgELtoolboxLink,
					 $wgTitle,
					 $wgScriptPath,
					 $wgOut;
					
		$do = $wgRequest->getVal('do');
		
		$showEmail = $wgRequest->getVal('showEmail');
		if($showEmail != NULL) {
			$showEmailchecked = 'checked="checked"';
		} else {
			$showEmailchecked = '';
		}
		
		$checkResponse = $wgRequest->getVal('checkResponse');
		if($checkResponse != NULL) {
			$checkResponseChecked = 'checked="checked"';
		} else {
			$checkResponseChecked = '';
		}
		
		$storeSession = $wgRequest->getVal('storeSession');
		if($storeSession != NULL) {
			$storeSessionChecked = 'checked="checked"';
		} else {
			$storeSessionChecked = '';
		}
		
		// default: 200
		$limit = 200;
		if( $wgELmaxPerPage ) {
			$limit = $wgELmaxPerPage;
		}
		if( $checkResponse && $wgELvalidationMode ) {
			$limit = 25;
		}
		if( $checkResponse && $wgELvalidationMaxPerPage ) {
			$limit = $wgELvalidationMaxPerPage;
		}
		
		$filterURL = $wgRequest->getVal('filterURL');
		
		$filterURLnot = $wgRequest->getVal('filterURLnot');
		
		$offset = $wgRequest->getVal('offset', 0);
		if( $offset < 0 ) {$offset = 0;}
		
		$pageID = $wgRequest->getVal('pageID');
		
		$lastValidation = preg_replace('/(\.|,).*/', '', $wgRequest->getVal('lastValidation'));
		
		$top = $wgOut->addWikiMsg('el-intro');
		if($wgELvalidationMode == NULL) {
			$top .= $wgOut->addWikiMsg('el-intro-alternative');
		}
		$top .= '<fieldset><legend>'.wfMsg('el-filterButton').'</legend>
						 <form name="ELform" id="ELform" style="display:inline" enctype="multipart/form-data" method="GET" action="'.$wgScriptPath.'/index.php/'.$wgTitle.'">
							 
							 <input type="hidden" name="do" value="filter" />
							 
							 <table><tr>
							 
							 <td align="right"><label for="filterURL">'.wfMsg('el-filterURL').'</label></td>
							 <td><input type="text" name="filterURL" id="filterURL" size="40" value="'.$filterURL.'">&nbsp;							 
							 <label for="filterURLnot">'.wfMsg('el-filterNot').'</label><!--
							 --><input type="text" name="filterURLnot" id="filterURLnot" size="40" value="'.$filterURLnot.'">
							 </td>			
							 				 
							 </tr><tr>
							 
							 <td></td>
							 
							 <td><input type="checkbox" name="showEmail" id="showEmail" '.$showEmailchecked.'><!--
							 --><label for="showEmail">'.wfMsg('el-showEmail').'</label>
							 </td>
							 
						';
		if($wgELvalidationMode != NULL) {
			$top .= ' 
							 </tr><tr>
							 <td></td>
							 <td><input type="checkbox" name="checkResponse" id="checkResponse" '.$checkResponseChecked.'><!--
							 --><label for="checkResponse">'.wfMsg('el-checkResponse').'</label></td>
							';
		}
		if($wgELenableSessionStoring != NULL) {
			$top .= '
							 </tr><tr>
							 <td></td>
							 <td><input type="checkbox" name="storeSession" id="storeSession" '.$storeSessionChecked.'><!--
							 --><label for="storeSession">'.wfMsg('el-storeSession').'</label></td>
							 </tr><tr>
							 <td>'.wfMsg('el-lastValidationOfURL').'</td>
							 <td><input type="text" name="lastValidation" id="lastValidation" size="3" value="'.$lastValidation.'">
							 '.wfMsg('el-lastValidationDays').'&nbsp; ('.wfMsg('el-lastValidationInfo').')
							 </td>
							';
		}
		if( is_numeric($pageID) ) { //if pageID in URL parameter (so it can be removed for new query), but independent from $wgELtoolboxLink
			$top .= '</tr><tr>
							 <td align="right">'.wfMsg('el-pageID').':</td>
							 <td><input type="text" name="pageID" id="pageID" size="7" value="'.$pageID.'"></td>
							 ';
		}
		$top .= '</tr><tr><td></td><td><input type="submit" class="ELsubmitButton" style="margin-top:8px" value="'.wfMsg('el-submit').'"></td>
						 </tr></table>
						 </form></fieldset>';
		$wgOut->addHTML( $top );
		
		if( $do != 'filter' ) {
			return false;
		}
		
		//$cond_arr for (and hopefully others)
		$query = "`el_to` LIKE '%".$filterURL."%'";
		$cond_arr = array("el_to LIKE '%".$filterURL."%'");
		
		if( $wgELtoolboxLink && is_numeric($pageID) ) {
			$query .= " AND (`el_from` = '".$pageID."')";
			$cond_arr[] = "el_from = '".$pageID."'";
		}
		
		if( $filterURLnot != NULL ) {
			$query .= " AND (`el_to` NOT LIKE '%".$filterURLnot."%')";
			$cond_arr[] = "el_to NOT LIKE '%".$filterURLnot."%'";
		}
		
		if( $showEmail == NULL ) {
			$query .= " AND (`el_to` NOT LIKE 'mailto:%')";
			$cond_arr[] = "el_to NOT LIKE 'mailto:%'";
		}
		
		if( is_numeric($lastValidation) ) {
			$lastValidationBefore = date("Y-m-d", strtotime("-".$lastValidation." days"));
			$query .= " AND (`el_last_validated` < '".$lastValidationBefore."')";
			$cond_arr[] = "el_last_validated < '".$lastValidationBefore."'";
		}
		
		// dummy query for number of all results (needed for pagination)
		$dbr = wfGetDB( DB_SLAVE );
		$resAll = $dbr->select(
				'externallinks',
				array(
					'el_from',
					'el_to',
				),
				$cond_arr,
				__METHOD__
		);
		$numAll = $resAll->numRows();
		
		// real query with limit and offset
		$res = $dbr->select(
				'externallinks',
				array(
					'el_from',
					'el_to',
				),
				$cond_arr,
				__METHOD__,
				array(
					'ORDER BY' => 'el_to DESC, el_from DESC',
					'LIMIT' => $limit,
					'OFFSET' => $offset,
				)
		);
		$numThis = $res->numRows();
		
		// if no results
		$navi = '';
		$naviReturn = '';
		$text = wfMsg('search-nonefound', ''); //MW default msg
		
		// if results
		if( $numThis > 0 ) {
			
			if( $wgELtableClass == NULL ) {
				$wgELtableClass = "wikitable sortable";
			}
			
			// return pagination
			$params = '&do=filter&filterURL='.$filterURL.'&filterURLnot='.$filterURLnot.'&showEmail='.$showEmail.'&checkResponse='.$checkResponse.'&lastValidation='.$lastValidation.'&storeSession='.$storeSession.'&pageID='.$pageID;
			$offsetNavi = ($offset - $limit);
			$naviInfo = '('.($offset + 1).'&minus;'.($offset + $numThis).' '.wfMsg('el-nav-outOf').' <strong>'.$numAll.'</strong>)';
			// Prev/First
			if( $offset > 0 ) {
				$navi .= '(<a href="'.$_SERVER['PHP_SELF'].'?offset='.($offsetNavi).''.$params.'">'.wfMsg('el-nav-prev').' '.$limit.'</a>';
				$first = '<a href="'.$_SERVER['PHP_SELF'].'?offset=0'.$params.'">'.wfMsg('el-nav-first').'</a>';
			} else {
				$navi .= '('.wfMsg('el-nav-prev').' '.$limit;
				$first = wfMsg('el-nav-first');
			}
			$navi .= ') (';
			// Next/Last
			if( ($offset + $numThis) < $numAll ) {
				$navi .= '<a href="'.$_SERVER['PHP_SELF'].'?offset='.($offset + $limit).''.$params.'">'.wfMsg('el-nav-next').' '.$limit.'</a>';
				$last = '<a href="'.$_SERVER['PHP_SELF'].'?offset='.($numAll - $limit).''.$params.'">'.wfMsg('el-nav-last').'</a>';
			} else {
				$navi .= wfMsg('el-nav-next').' '.$limit;
				$last = wfMsg('el-nav-last');
			}
			$navi .= ')&nbsp; ';
			$navi .= $naviInfo;
			$navi .= '&nbsp; ('.$first.' | '.$last.')';
			
			$naviReturn = $wgOut->addHTML('<p class="ELnavi">');
			// if no pagination is needed
			if($numAll >= $limit) {
				$naviReturn .= $navi;
			} else {
				$naviReturn .= $naviInfo;
			}
			$naviReturn .= $wgOut->addHTML('</p>');
			
			$wgOut->addHTML( $naviReturn );
			
			// return results table
			$text  = '<table id="ExternalLinks" width="100%" class="'.$wgELtableClass.'">';
			$text .= '<tr><th>';
			$text .= wfMsg('el-th-page');
			$text .= '</th><th>';
			$text .= wfMsg('el-th-url');
			$text .= '</th>';
			if( $checkResponse != NULL && $wgELvalidationMode != NULL ) {
				$text .= '<th>'.wfMsg('el-serverResponse').'</th>';
			}
			$text .= '</tr>';
			foreach ( $res as $row ) {
				$title = Title::newFromID($row->el_from);
				$link = $row->el_to;
				
				//update each reported link with current date
				if ( $wgELenableSessionStoring && $storeSession != NULL ) {
					$this->updateLastValidated( $link );
				}
				
				$text .= '<tr>';
				$text .= '<td class="ELtablePage plainlinks '.$wgELpageLinkClass.'" title="'.wfMsg('edit').'">[{{fullurl:'.$title.'|action=edit&preview=yes&minor=1&summary='.urlencode(wfMsg('el-edit-summary')).'#toolbar}} '.$title.']</td>';
				$text .= '<td class="ELtableURL">['.$link.' <nowiki>'.$link.'</nowiki>]</td>';
				
				// check server response
				if( $checkResponse != NULL && $wgELvalidationMode != NULL ) {
										
					switch ( $wgELvalidationMode ) {
				    case "getHeaders":
							// supports only HTTP (HTTPS also not via port 443)
							if( !preg_match('/^http:\/\//i',$link) ) {
								$respNum = '';
							} else {
								$header = get_headers($link, 1);
								$response = preg_replace('/HTTP\/\d\.\d+ /', '', $header[0]);
								$respNum = preg_replace('/(\d+).+/', '$1', $response);
								$respType = '';
							}
			        break;
				    case "cURL":
							// doesn't support HTTPS
							if( preg_match('/^https:\/\//i',$link) ) {
								$respNum = '';
							} else {
								$agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $link);
								curl_setopt($ch, CURLOPT_HEADER, 1);
								curl_setopt($ch, CURLOPT_NOBODY, 1);
								curl_setopt($ch, CURLOPT_USERAGENT, $agent);
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$buffer = curl_exec($ch);
								$curl_info = curl_getinfo($ch);
								//http://php.net/manual/en/function.curl-getinfo.php
								$respNum = curl_getinfo($ch, CURLINFO_HTTP_CODE);
								if( $respNum == NULL) {
									$respNum = "Domain Not Found?";
								}
								$respType = preg_replace(array('/; charset=.+/', '/\//'), array('', ' / '), curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
								$header_size = $curl_info['header_size'];
								$header = substr($buffer, 0, $header_size);
								curl_close($ch);
				        break;
				      }
					}
			
					if( $respNum != NULL ) {
						if( $respNum == 300
						 || $respNum == 302 ) {
							$respClass = 'ELrespNotice';
							$respBG = '#fffddf';
						}
						if( $respNum <= 200
					   || $respNum == 301) {
							$respClass = 'ELrespOK';
							$respBG = '#e8ffe8';
						}
						if( $respNum == "Domain Not Found?"
						 || $respNum >= 303 ) {
							$respClass = 'ELrespWarning';
							$respBG = '#fee';
						}
						if( $respNum == 405 ) {
							$respClass = 'ELrespNotice';
							$respBG = '#fffddf';
						}
						$text .= '<td class="ELresp '.$respClass.'" style="background-color:'.$respBG.' !important">';
						if( $respType ) {
							$text .= '<span class="ELrespType small grey" style="float:right; padding-left:8px">'.$respType.'</span>';
						}
						$text .= $respNum.' <span class="small">';
						$text .= $this->headerResponseByNumber($respNum);
						$text .= '</span></td>';
					} else {
						$text .= '<td class="ELresp">?</td>';
					}
			}
				$text .= '</tr>';
			}
			$res->free();
			$text .= '</table>';
		}
		
  	$wgOut->addWikiText( $text );
		
		// return bottom pagination
		$wgOut->addHTML( $naviReturn );
	}

}
