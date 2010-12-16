<?php
/*
 * Created on Jul 26, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * overwrites the existing special search to add in metavid specific features
 */
if ( !defined( 'MEDIAWIKI' ) )
	die();

class MediaSearch extends SpecialPage {
	function __construct() {
		parent::__construct( 'MediaSearch' );
	}
}
function wfSpecialMediaSearch() {
	$MV_SpecialMediaSearch = new MV_SpecialMediaSearch();
	$MV_SpecialMediaSearch->doSearchPage();
}
// extends search page
// @@todo add link to "media search"
class MV_SpecialSearch extends SpecialPage {
	function MV_SpecialSearch() {
		global $wgOut, $wgRequest, $wgUser, $wgTitle;
		if($wgTitle->getText()!='SpecialPages'){
			//mvfAddHTMLHeader( 'search' );
			// $MvSpecialSearch = new MV_SpecialMediaSearch();
			// $MvSpecialSearch->doSearchPage( $wgRequest->getVal('search') );
			$mediaPage = Title::newFromText( 'MediaSearch', NS_SPECIAL );
			$sk = $wgUser->getSkin();
			$wgOut->addHTML( wfMsg( 'mv_do_media_search',
					$sk->makeKnownLinkObj( $mediaPage,
							htmlspecialchars( $wgRequest->getVal( 'search' ) ),
							'mv_search=' . $wgRequest->getVal( 'search' )
						)
					)
				);
			SpecialPage :: SpecialPage( 'Search' );
		}
	}
}
/*
 * simple/quick implementation ...
 * @@todo future version should be better integrated with semantic wiki and or
 * an external scalable search engine ie sphinx or lucene
 *
 * example get request: filter 0, type match, value = wars
 * ?f[0]['t']=m&f[0]['v']=wars
 */
class MV_SpecialMediaSearch {
	// initial values for selectors ( keys into language as 'mv_search_$val')
	var $sel_filter_types = array (
		'match', // full text search
		'spoken_by',
		'category',
		'date_range', // search in a given date range
		'bill' // match against a given bill
		// not yet active:
		// 'stream_name', //search within a particular stream
		// 'layers'	 //specify a specific meta-layer set
		// 'smw_property'
		// 'smw_property_numeric'

	);
	var $sel_filter_andor = array (
		'and',
		'or',
		'not',
	);
	var $unified_term_search = '';
	var $adv_search = false;

	var $results = array ();
	var $mName = 'MediaSearch';
	var $outputInlineHeader = true;
	var $outputContainer = true;
	var $outputSeqLinks = false;

	var $limit = 20;
	var $offset = 0;
	var $order = 'relevant';

	function doSearchPage( $term = '' ) {
		global $wgRequest, $wgOut, $wgUser;
		$this->setUpFilters();
		// do the search
		$this->doSearch();
		// page control:
		$this->outputInlineHeader = false;
		if ( $wgRequest->getVal( 'seq_inline' ) == 'true' ) {
			$this->outputContainer = false;
			$this->outputSeqLinks = true;
			// @@todo add a absolute link to search results
			// print $this->getResultsHTML();
			print $this->getUnifiedResultsHTML();
			// @@todo cleaner exit
			// exit ();
		} else {
			// add the search placeholder
			// $wgOut->addWikiText( wfMsg( 'searchresulttext' ) );
			$sk = $wgUser->getSkin();
			$title = Title :: MakeTitle( NS_SPECIAL, 'Search' );

			// check if the skin already includes the dynamicSearchControl
			global $wgUser;
			$doDSC = false;
			$sk = $wgUser->getSkin();
			if ( isset ( $sk->skinProvidesMvSearch ) ) {
				if ( $sk->skinProvidesMvSearch == true ) {
					$doDSC = true;
				}
			} else {
				$doDSC = false;
			}
			if ( $doDSC )
				$wgOut->addHTML( $this->dynamicSearchControl() );

			// $wgOut->addHTML($this->getResultsBar());
			$wgOut->addHTML( $this->getUnifiedResultsHTML() );
			if ( trim( $this->unified_term_search ) != '' ) {
				$wgOut->addHTML( wfMsg( 'mv_page_search', $sk->makeKnownLinkObj( $title, $this->unified_term_search, http_build_query( array (
					'search' => $this->unified_term_search
				) ) ) ) );
			}
		}
	}
	function dynamicSearchControl() {
		$title = SpecialPage :: getTitleFor( 'MediaSearch' );
		$action = $title->escapeLocalURL();

		$o = "<div id=\"msms_form_search_row\" class=\"form_search_row\">
						<form id=\"mv_media_search\" method=\"get\" " .
		"action=\"$action\">\n
								<input type=\"hidden\" id=\"advs\" name=\"advs\" value=\"";
		$o .= ( $this->adv_search ) ? '1' : '0';
		$o .= "\">
								<span class=\"advs_basic\" style=\"display:";
		$o .= ( $this->adv_search ) ? 'none' : 'inline';
		$o .= "\">
									<input type=\"text\" class=\"searchField\" name=\"mv_search\" id=\"searchInput\" value=\"{$this->unified_term_search}\"/>
								</span>
								<span class=\"advs_adv\" id=\"adv_filters\" style=\"display:";
		$o .= ( $this->adv_search ) ? 'inline' : 'none';
		$o .= "\">
									{$this->list_active_filters()}
								</span>
								<input type=\"submit\" value=\"" . wfMsg( 'mv_video_search' ) . "\">
								<a href=\"javascript:mv_toggle_advs()\" class=\"advanced_search_tag\">
									<span class=\"advs_basic\" style=\"display:";
		$o .= ( $this->adv_search ) ? 'none' : 'inline';
		$o .= "\">advanced search</span>
									<span class=\"advs_adv\" style=\"display:";
		$o .= ( $this->adv_search ) ? 'inline' : 'none';
		$o .= "\">basic search</span>
								</a>
						</form>
					</div>";
		return $o;
	}
	function loadFiltersFromSerialized( $sval ) {
		$this->filters = unserialize( $sval );
	}

	function setupFilters( $defaultType = 'empty', $opt = null ) {
		global $wgRequest;

		// set advs flag:
		$advs = $wgRequest->getVal( 'advs' );
		$this->adv_search = ( $advs == '' || $advs == 0 ) ? false : true;
		// check for unified searchterm:
		$term = $wgRequest->getVal( 'mv_search' );
		// set input from search (on normal search page)
		if ( $term == '' )
			$term = $wgRequest->getVal( 'search' );
		if ( $term != '' ) {
			$this->filters = array (
				array (
					't' => 'match',
					'v' => $term
				)
			);
			$this->unified_term_search = $term;
			// if not doing advanced search we are done

			if ( !$this->adv_search )
				return;
		}

		// print "CUR un: " . $this->unified_term_search;

		// first try any key titles:
		$title_str = $wgRequest->getVal( 'title' );
		$tp = split( '/', $title_str );
		if ( count( $tp ) == 3 ) {
			switch ( $tp[1] ) {
				case 'person' :
					$this->filters = array (
						array (
							't' => 'spoken_by',
							'v' => str_replace( '_',
							' ',
							$tp[2]
						)
					) );
				break;
				default:
					// empty filter:
					$this->filters = array (
							array (
								't' => 'match',
								'v' => ''
							)
						);
				break;
			}
		} else {
			if ( isset ( $_GET['f'] ) ) {
				$this->filters = $_GET['f'];
				// @@todo more input proccessing
				// grab unified_term_search if not already listed:
				if ( $this->unified_term_search == '' ) {
					foreach ( $this->filters as $f ) {
						if ( $f['t'] == 'match' ) {
							if ( $this->unified_term_search != '' )
								$this->unified_term_search .= ' ';
							$this->unified_term_search .= $f['v'];
						} else if ( $f['t'] == 'spoken_by' ) {
							$this->unified_term_search = $f['v'];
						}

					}
				}
			} else {
				switch ( $defaultType ) {
					case 'stream' :
						$this->filters = array (
							array (
								't' => 'stream_name',
								'v' => $opt['stream_name']
							)
						);
						break;
					case 'empty' :
					default :
						$this->filters = array (
							array (
								't' => 'match',
								'v' => ''
							)
						);
					break;
				}
			}
		}
	}
	function doSearch( $log_search = true ) {
		global $mvEnableSearchDigest;
		$mvIndex = new MV_Index();

		global $wgRequest;

		$this->results = $mvIndex->doUnifiedFiltersQuery( $this->filters );

		$this->num = $mvIndex->numResults();
		$this->numResultsFound = $mvIndex->numResultsFound();
		if ( isset ( $mvIndex->offset ) )
			$this->offset = $mvIndex->offset;
		if ( isset ( $mvIndex->limit ) )
			$this->limit = $mvIndex->limit;
		if ( isset ( $mvIndex->order ) )
			$this->order = $mvIndex->order;
		//fix replace text:


		// do search digest (if global config, function req and num_results fit criteria)
		if ( $mvEnableSearchDigest &&
			$wgRequest->getVal( 'tl' ) != '1' &&
			$log_search &&
			$this->numResultsFound != 0 )
		{
			$dbw = & wfGetDB( DB_WRITE );
			$dbr = & wfGetDB( DB_READ );
			// print_r($this->filters);
			// print "Adding to mv_search_digest : ". $this->getFilterDesc($query_key = true) . "\n";
			// print var_dump(debug_backtrace());
			// @@todo non-blocking insert... is that supported in mysql/php?
			$dbw->insert( 'mv_search_digest', array (
				'query_key' => $this->getFilterDesc( $query_key = true ),
				'time' => time() ),
			 'Database::searchDigestInsert' );
			// make sure the query key exists and is updated
			// @@todo I think we can do a INSERT IF NOT found here?
			$res = $dbr->select( 'mv_query_key_lookup', array (
				'filters'
			), array (
				'query_key' => $this->getFilterDesc( $query_key = true
			) ) );
			if ( $dbr->numRows( $res ) == 0 ) {
				$dbr->insert( 'mv_query_key_lookup', array (
					'query_key' => $this->getFilterDesc( $query_key = true
				), 'filters' => serialize( $this->filters ) ) );
			}
		}

	}
	/*list all the meta *layer* types */
	function powerSearchOptions() {
		global $mvMVDTypeAllAvailable;
		$opt = array ();
		// group track_req
		$opt['tracks'] = '';
		$coma = '';
		foreach ( $mvMVDTypeAllAvailable as $n ) {
			$opt['tracks'] .= $coma . $n;
			$coma = ',';
		}
		// $opt['redirs'] = $this->searchRedirects ? 1 : 0;
		// $opt['searchx'] = 1;
		return $opt;
	}
	function getResultsCMML() {

	}
	function getUnifiedResultsHTML( $show_sidebar = true ) {
		global $wgUser, $wgStylePath, $wgRequest, $wgContLang;
		global $mvDefaultClipRange;
		$sk = $wgUser->getSkin();
		$o = '';

		$o .= '<h5 class="search_results_header">' . wfMsg( 'mv_results_for', $this->getFilterDesc() ) .  '</h5>';

		$o .= '<div id="resultsArea">
						<ul id="metaResults">';
		if ( count( $this->results ) == 0 ) {
			$o .= '<h2><span class="mw-headline">' . wfMsg( 'mv_search_no_results' ) . '</span></h2>';
			// close
			$o .= '</ul></div>';
			return $o;
		}

		// num of results
		if ( $this->numResultsFound ) {
			$re = ( $this->limit + $this->offset > $this->numResultsFound ) ? $this->numResultsFound : ( $this->limit + $this->offset );
			$rs = ( $this->offset == 0 ) ? 1 : $this->offset;
			$o .= '<li class="results">' .
			wfMsg( 'mv_results_found', $rs, $re, number_format( $this->numResultsFound ) ) .
			'</li>';
		}
		// check order
		$prevnext = '';
		// pagging
		if ( $this->numResultsFound > $this->limit ) {
			$prevnext = mvViewPrevNext( $this->offset, $this->limit, SpecialPage :: getTitleFor( 'MediaSearch' ), $this->get_httpd_filters_query(), ( $this->num < $this->limit ) );
			$o .= '<li class="prevnext">' . $prevnext . '</li>';
		}
		$br = '<br />';
		$enddash = '';

		$sTitle = Title :: MakeTitle( NS_SPECIAL, 'MvExportSearch' );

		// force host for script (should be a better way to do this)
		if ( !isset( $_SERVER['HTTP_HOST'] ) )
			$_SERVER['HTTP_HOST'] = 'metavid.org';

		// make miro link:
		$o .= '<li class="subscribe"><a href="http://subscribe.getMiro.com/?url1=' .
			'http%3A%2F%2F' . $_SERVER['HTTP_HOST'] .  urlencode( $sTitle->getFullUrl( $this->get_httpd_filters_query() ) )  . '" ' .
		 'title="Subscribe with Miro"><img src="' . $wgStylePath . '/mvpcf/images/button_subscribe.png" alt="Miro Video Player" border="0" /></a></li>';

		// make rss link:
		$o .= '<li class="rss">';
		$o .= 	$sk->makeKnownLinkObj( $sTitle, 'RSS', $this->get_httpd_filters_query() );
		$o .= '</li>';

		$o .= '<br />';
		foreach ( array ( 'relevant', 'recent', 'viewed' ) as $type ) {
			if ( $this->order == $type ) {
				$o .= $enddash . '<li class="relevant">' . wfMsg( 'mv_most_' . $type ) . '</li>' ;
			} else {
				$q_req = $this->get_httpd_filters_query();
				if ( $wgRequest->getVal( 'limit' ) != '' || $wgRequest->getVal( 'order' ) != '' )
					$q_req .= '&' . http_build_query( array( 'limit' => $this->limit, 'offset' => $this->offset ) );
				$q_req .= '&order=' . $type;
				$o .= $enddash . '<li class="relevant">' . $sk->makeKnownLinkObj( SpecialPage :: getTitleFor( 'MediaSearch' ),
								wfMsg( 'mv_most_' . $type ), $q_req ) . '</li>';
			}
			$br = '';
			$enddash = ' - ';
		}

		$o .= '</ul>';

		// output results:
		// collect categories and people for sidebarbucket
		$sideBarLinkBucket = array (
							'person' => array(),
							'category' => array(),
							'bill' => array()
						);
		$o .= '	<ul id="results">';
		//setup the MV_index:
		$mvIndex = new MV_Index();
		foreach ( $this->results as $inx => & $mvd ) {
			$mvTitle = new MV_Title( $mvd->wiki_title );

			//get parent meta if requested:
			global $mvGetParentMeta;
			$pmeta_out = '';
			if( $mvGetParentMeta && strtolower( $mvTitle->getMvdTypeKey() ) == 'ht_en'){
				$pmvd = $mvIndex->getParentAnnotativeLayers($mvTitle);

				if( $pmvd->wiki_title ){
					$pMvTitle =  new MV_Title( $pmvd->wiki_title );
					$pAnnoStreamLink = Title :: MakeTitle( MV_NS_STREAM, $pMvTitle->getNearStreamName( 0 ) );
					$clip_desc_txt = 'Segment';
					if($pmvd->Speech_by){
						$personTitle = Title :: newFromText( $pmvd->Speech_by );
						$clip_desc_txt = 'Speech By ' . $personTitle->getText();
					}

					$pmeta_out.='This '. $sk->makeKnownLinkObj($pAnnoStreamLink, seconds2Description ( $mvTitle->getSegmentDuration(), true, true ) ).
								' clip is part of a larger '.
								$sk->makeKnownLinkObj($pAnnoStreamLink, seconds2Description ( $pMvTitle->getSegmentDuration(), true, true ) ) . ' Speech';
					if($pmvd->category){
						$pmeta_out.='<br />Covering: ';
						$coma='';
						foreach($pmvd->category as $cat_titlekey ){
							$cTitle = $cTitle = Title :: MakeTitle( NS_CATEGORY, $cat_titlekey );
							$pmeta_out .= $coma . $sk->makeKnownLinkObj( $cTitle, $cTitle->getText() );
							$coma=', ';
							assoc_array_increment( $sideBarLinkBucket, 'category', $cat_titlekey );
						}
					}
					if($pmvd->Bill){
						$pmeta_out.='<br />Bill: ';
						$bTitle = Title :: newFromText( $pmvd->Bill );
						$pmeta_out .= $sk->makeKnownLinkObj( $bTitle, $bTitle->getText() );
						assoc_array_increment( $sideBarLinkBucket, 'bill', $pmvd->Bill );
					}
				}
			}
			$mvd_cnt_links = '';
			if ( isset ( $mvd->spoken_by ) ) {
				$ptitle = Title :: MakeTitle( NS_MAIN, $mvd->spoken_by );
				$mvd_cnt_links .= wfMsg( 'mv_search_spoken_by' ) . ': ' . $sk->makeKnownLinkObj( $ptitle );
				$mvd_cnt_links .= '<br />';
				assoc_array_increment( $sideBarLinkBucket, 'person', $mvd->spoken_by );
			}
			$mvd_cat_links = $mvd_bill_links = '';
			$coma = '';
			if ( isset ( $mvd->categories ) ) {
				foreach ( $mvd->categories as $cat_id => $na ) {
					$cTitle = Title :: MakeTitle( NS_CATEGORY, $cat_id );
					if ( $mvd_cat_links == '' )
						$mvd_cat_links .= wfMsg( 'mv_search_categories' ) .
						': ';
					$mvd_cat_links .= $coma . $sk->makeKnownLinkObj( $cTitle, $cTitle->getText() );
					$coma = ', ';
					assoc_array_increment( $sideBarLinkBucket, 'category', $cat_id );
				}
			}
			$coma = '';
			if ( isset ( $mvd->bills ) ) {
				foreach ( $mvd->bills as $bill_id => $na ) {
					$bTitle = Title :: newFromText( $bill_id );
					if ( $mvd_bill_links == '' )
						$mvd_bill_links .= wfMsg( 'mv_search_bills' ) .
						': ';
					$mvd_bill_links .= $coma . $sk->makeKnownLinkObj( $bTitle, $bTitle->getText() );
					$coma = ', ';
					assoc_array_increment( $sideBarLinkBucket, 'bill', $bill_id );
				}
			}
			// link directly to the current range:
			//if the clip length is < $mvDefaultClipLength get range:
			global $mvDefaultClipLength;
			if( $mvTitle->getSegmentDuration() < $mvDefaultClipLength){
				$mvStreamTitle = Title :: MakeTitle( MV_NS_STREAM, $mvTitle->getNearStreamName( $mvDefaultClipRange ) );
			}else{
				$mvStreamTitle = Title :: MakeTitle( MV_NS_STREAM, $mvTitle->getNearStreamName( 0 ) );
			}
			// $mvTitle->getStreamName() .'/'.$mvTitle->getStartTime() .'/'. $mvTitle->getEndTime() );

			$o .= '<li class="result">
					<span class="vid_img" id="mvimg_' . htmlspecialchars( $mvd->id ) . '">
						' . $sk->makeKnownLinkObj( $mvStreamTitle,
								'<img alt="image for ' . htmlspecialchars( $mvTitle->getStreamNameText() ) .
								' ' . $mvTitle->getTimeDesc() . '" src="' . $mvTitle->getStreamImageURL( 'small' , $req_time = null, $foce_server = '', $direct_link=false ) .
							 '"/>' ) . '
					</span>
					<div class="result_description">
						<h4>' .
							$sk->makeKnownLinkObj( $mvStreamTitle, $mvTitle->getStreamNameText() .
								 ' :: ' . $mvTitle->getTimeDesc() ) .
						'</h4>
						<p>Matching Phrase:' . $this->termHighlight( $mvd->text, implode( '|', $this->getTerms() ), 1, 100 ) . ' </p>
						<span class="by">' . $mvd_cnt_links . '</span>
						<span class="by">' . $mvd_cat_links . '</span>
						<span class="by">' . $mvd_bill_links . '</span>
					</div>
					<div class="result_meta">
						<span class="views">Views: ' . htmlspecialchars( $mvd->view_count ) . '</span>
						<span class="duration">' . wfMsg( 'mv_duration_label' ) . ':' . htmlspecialchars( $mvTitle->getSegmentDurationNTP( $short_time = true ) ) . '</span>
						<span class="playinline"><a href="javascript:mv_pl(\'' . htmlspecialchars( $mvd->id ) . '\')">' .
			wfMsg( 'mv_play_inline' ) . '</a></span>
										</div>';
					if($pmeta_out!=''){
						$o .='<div class="parent_meta">'.$pmeta_out.'</div>';
					}
					$o.='</li>';
		}
		$o .= '</ul>';
		// add in prev-next at bottom too:
		if ( $this->numResultsFound > $this->limit )
			$o .= '<li class="prevnext">' . $prevnext . '</li>';
		$o .= '</div>';
		if ( !$show_sidebar )return $o;
		/*search sidebar*/
		$perSectionCount = 3;
		$o .= '<div id="searchSideBar">
					<div id="searchSideBarTop">
					</div>
						<div class="suggestionsBox" id="searchSideBarInner">';
		// look for people matches max of 3
		$first_block = ' first_block';
		$matches = 0;
		$person_out_ary = array();
		$person_out = MV_SpecialMediaSearch :: auto_complete_person( $this->unified_term_search, 3, 'person_html', $matches, $person_out_ary );
		if ( $person_out != '' || count( $sideBarLinkBucket['person'] ) != 0 ) {
			// for now don't include({$matches})
			$o .= "<div class=\"block{$first_block}\">
								<h6>" . wfMsg( 'mv_people_results' ) . "</h6>
							</div>";
			$o .= '<div class="block wide_block">';
			$o .=  $person_out;
			if ( isset ( $sideBarLinkBucket['person'] ) ) {
				$pAry = & $sideBarLinkBucket['person'];
				arsort( $pAry );
				$i = 0;
				foreach ( $pAry as $person_name => $count ) {
					if ( in_array( $person_name, $person_out_ary ) )continue;
					if ( $i == $perSectionCount )
						break;
					$o .= MV_SpecialMediaSearch :: format_ac_line( $person_name, '', '', MV_SpecialMediaSearch :: getPersonImageURL( $person_name ), $format = 'person_html' );
					$i++;
				}
			}
			$o .= '</div>';
			$first_block = '';
		}
		// get categories
		$category_out = MV_SpecialMediaSearch :: auto_complete_search_categories( $this->unified_term_search, 3, 'block_html', $matches );
		if ( $category_out != '' || count( $sideBarLinkBucket['category'] ) != 0 ) {
			$o .= '<div class="block' . htmlspecialchars( $first_block ) . '\">
								<h6>' . wfMsg( 'mv_category_results' ) . '</h6>
							</div>';
			$o .= '<div class="block wide_block">' . $category_out;
			if ( isset ( $sideBarLinkBucket['category'] ) ) {
				$cAry = & $sideBarLinkBucket['category'];
				arsort( $cAry );
				$i = 0;
				$catNStxt = $wgContLang->getNsText( NS_CATEGORY );
				foreach ( $cAry as $cat_name => $count ) {
					if ( $i == $perSectionCount )
						break;
					$o .= MV_SpecialMediaSearch :: format_ac_line( $cat_name, '', $catNStxt . ':', 'no_image', $format = 'block_html' );
					$i++;
				}
			}
			$o .= '</div>';
			$first_block = '';
		}
		// get bills:
		$bill_out = MV_SpecialMediaSearch :: auto_complete_category( 'Bill', $this->unified_term_search, 3, 'block_html', $matches );
		if ( $bill_out != '' || count( $sideBarLinkBucket['bill'] ) != 0 ) {
			global $wgContLang;
			$o .= '<div class=\"block ' . htmlspecialchars( $first_block ) . '">
								<h6>' . wfMsg( 'mv_bill_results' ) . '</h6>
							</div>';
			$o .= '<div class="block wide_block">' . $bill_out;
			if ( $sideBarLinkBucket['bill'] ) {
				$bAry = & $sideBarLinkBucket['bill'];
				arsort( $bAry );
				$i = 0;
				foreach ( $bAry as $bill_name => $count ) {
					if ( $i == $perSectionCount )
						break;
					$o .= MV_SpecialMediaSearch :: format_ac_line( $bill_name, '', '', 'no_image', $format = 'block_html' );
					$i++;
				}
			}
			$o .= '</div>';
			$first_block = '';
		}
		// intrest out is just simple title matching (for now)
		$intrest_out = MV_SpecialMediaSearch :: auto_complete_category( 'Interest_Group', $this->unified_term_search, 3, 'block_html', $matches );
		if ( $intrest_out != '' ) {
			$o .= "<div class=\"block{$first_block}\">
								<h6>" . wfMsg( 'mv_intrest_group_results' ) . "</h6>
							</div>";
			$o .= '<div class="block wide_block">' . $intrest_out . '</div>';
			$first_block = '';
		}
		$o .= '</div><!--searchSideBarInner-->
				</div>';
		$o .= '<div style="clear:both;"></div>';
		return $o;
	}

	function getTerms() {
		$ret_ary = $cat_ary = array ();
		foreach ( $this->filters as $filter ) {
			switch ( $filter['t'] ) {
				case 'match' :
					$ret_ary = array_merge($ret_ary, explode(' ', $filter['v']));
				break;
				case 'spoken_by' :
				case 'stream_name' :
					$ret_ary[] = $filter['v'];
					break;
				case 'category' :
					$cat_ary[] = $filter['v'];
					break;
				case 'smw_property' :

				break;
				case 'smw_property_number' :
					// should be special case for numeric values
				break;
			}
		}
		return $ret_ary + $cat_ary;
	}
	/*function termHighlightText(&$text, $terms_ary){
		if(count($terms_ary)==0)return;
		$term_pat=$or='';
		foreach($terms_ary as $term){
			if(trim($term)!=''){
				$term_pat.=$or.$term;
				$or='|';
			}
		}
		if($term_pat=='')return;
		//@@TODO:: someone somewhere has written a better wiki_text page highlighter
		$pat1 = "/(\[\[(.*)\]\]|(.*)($term_pat)(.*)/i";
		//print "pattern: ". $pat1 . "\n\n";
		return preg_replace( $pat1,
			  "$1<span class='searchmatch'>\\2</span>$3", $text );
		//print "\n\ncur text:". $text;
	}*/
	/*very similar to showHit in SpecialSearch.php */
	function termHighlight( & $text, $terms, $contextlines = 1, $contextchars = 50 ) {
		// $fname = 'SpecialSearch::termHighlight';
		// wfProfileIn( $fname );
		global $wgUser, $wgContLang, $wgLang;
		$sk = $wgUser->getSkin();

		$lines = explode( "\n", $text );
		$max = intval( $contextchars ) + 1;
		$pat1 = "/(.*)($terms)(.{0,$max})/i";

		$lineno = 0;

		$extract = '';
		//		wfProfileIn( "$fname-extract" );
		foreach ( $lines as $line ) {
			if ( 0 == $contextlines ) {
				break;
			}
			++ $lineno;
			$m = array ();
			if ( !preg_match( $pat1, $line, $m ) ) {
				continue;
			}
			-- $contextlines;
			$pre = $wgContLang->truncate( $m[1], - $contextchars );

			if ( count( $m ) < 3 ) {
				$post = '';
			} else {
				$post = $wgContLang->truncate( $m[3], $contextchars );
			}

			$found = $m[2];

			$line = htmlspecialchars( $pre . $found . $post );
			$pat2 = '/(' . $terms . ")/i";
			$line = preg_replace( $pat2, "<span class='searchmatch'>\\1</span>", $line );

			// $extract .= " <small>{$lineno}: {$line}</small>\n";
			$extract .= " {$line}\n";
		}
		// if we found no matches just return the first line:
		if ( $extract == '' )
			return ' ' . $wgContLang->truncate( $text, ( $contextchars * 2 ) ) . '';
		// wfProfileOut( "$fname-extract" );
		// wfProfileOut( $fname );
		// return "<li>{$link} ({$size}){$extract}</li>\n";
		return $extract;
	}
	// output expanded request via mvd_id
	function expand_wt( $mvd_id, $terms_ary ) {
		global $wgOut, $mvgIP;
		global $mvDefaultSearchVideoPlaybackRes;

		$mvd = MV_Index :: getMVDbyId( $mvd_id );
		if ( count( $mvd ) != 0 ) {
			$mvTitle = new MV_Title( $mvd->wiki_title );
			// validate title and load stream ref:
			if ( $mvTitle->validRequestTitle() ) {
				list ( $vWidth, $vHeight ) = explode( 'x', $mvDefaultSearchVideoPlaybackRes );
				$embedHTML = '<span style="float:left;width:' . htmlspecialchars( $vWidth + 20 ) . 'px">' .
				$mvTitle->getEmbedVideoHtml( array('id'=>'vid_' . $mvd_id, 'size'=>$mvDefaultSearchVideoPlaybackRes, 'autoplay'=> true ) ) .
				'</span>';
				$wgOut->clearHTML();
				$MvOverlay = new MV_Overlay();
				$MvOverlay->outputMVD( $mvd, $mvTitle );
				$pageHTML = '<span style="padding-top:10px;float:left;width:450px">' .
				$wgOut->getHTML() .
				'</span>';

				// return page html:
				return $embedHTML . $pageHTML . '<div style="clear: both;"/>';
			} else {
				return wfMsg( 'mvBadMVDtitle' );
			}
		} else {
			return wfMsg( 'mv_error_mvd_not_found' );
		}
		// $title = Title::MakeTitle(MV_NS_MVD, $wiki_title);
		// $article = new Article($title);
		// output table with embed left, and content right
		// return $wgOut->parse($article->getContent());
	}
	function get_httpd_filters_query() {
		// get all the mvd ns selected:
		$opt = $this->powerSearchOptions();
		// also add "order"

		return http_build_query( array( 'order' => $this->order ) + $opt + array (
			'f' => $this->filters
		) );
	}
	function list_active_filters() {
		global $mvgScriptPath;
		$s = $so = '';
		$dateObjOut = false;
		$s .= '<div id="mv_active_filters" style="margin-bottom:10px;">';
		foreach ( $this->filters as $i => $filter ) {
			if ( !isset ( $filter['v'] ) ) // value
				$filter['v'] = '';
			if ( !isset ( $filter['t'] ) ) // type
				$filter['t'] = '';
			if ( !isset ( $filter['a'] ) ) // and, or, not
				$filter['a'] = '';

			// output the master selecter per line:
			$s .= '<br /><span id="mvs_' . htmlspecialchars( $i ) . '">';
			$s .= '&nbsp;&nbsp;';
			// selctor (don't display if i==0')
			$s .= $this->selector( $i, 'a', $filter['a'], ( $i == 0 ) ? false : true );
			$s .= $this->selector( $i, 't', $filter['t'] ); // type selector
			$s .= '<span id="mvs_' . htmlspecialchars( $i ) . '_tc">';
			switch ( $filter['t'] ) {
				case 'match' :
					$s .= $this->text_entry( $i, 'v', $filter['v'], 'mv_hl_text' );
				break;
				case 'bill':
					$s .= $this->text_entry( $i, 'v', $filter['v'], 'mv_hl_text',
						array( 'onclick' => 'this.value=\'\';', 'size' => '35' ) );
				break;
				case 'category' :
					// $s.=$this->get_ref_ac($i, $filter['v']);
					$s .= $this->text_entry( $i, 'v', $filter['v'] );
				break;
				case 'date_range' :
					$s .= wfMsg( 'mv_time_separator', $this->text_entry( $i, 'vs', $filter['vs'], 'date-pick_' . $i, array( 'id' => 'vs_' . $i ) ),
													 $this->text_entry( $i, 've', $filter['ve'], 'date-pick_' . $i, array( 'id' => 've_' . $i ) ) );
					// also output dateObj (if not already output):
					if ( !$dateObjOut ) {
						global $wgOut;
						// add all date scripts:
						$mvgScriptPath = htmlspecialchars( $mvgScriptPath );
						$wgOut->addScript( "\n" .
						'<!-- required plugins -->
													<script type="text/javascript" src="' . $mvgScriptPath . '/skins/mv_embed/jquery/plugins/date.js"></script>
													<!--[if IE]><script type="text/javascript" src="' . $mvgScriptPath . '/skins/mv_embed/jquery/plugins/jquery.bgiframe.js"></script><![endif]-->

													<!-- jquery.datePicker.js -->
													<script type="text/javascript" src="' . $mvgScriptPath . '/skins/mv_embed/jquery/plugins/jquery.datePicker.js"></script>
													<script language="javascript" type="text/javascript">' .
						$this->getJsonDateObj( 'mvDateInitObj' ) .
						'</script>' );
						$dateObjOut = true;
					}
					break;
				case 'stream_name' :
					$s .= $this->text_entry( $i, 'v', $filter['v'] );
					break;
				case 'spoken_by' :
					$s .= $this->get_ref_person( $i, $filter['v'], true );
					break;
				case 'smw_property' :

				break;
			}
			$s .= '</span>';
			if ( $i > 0 )
				$s .= '&nbsp; <a href="javascript:mv_remove_filter(' .
				$i . ');">' .
				' <img title="' . wfMsg( 'mv_remove_filter' ) . '" ' .
					'src="' . $mvgScriptPath . '/skins/images/cog_delete.png"></a>';
			$s .= '</span>';
		}
		$s .= '</div>';
		// reference remove
		$s .= '<a id="mv_ref_remove" style="display:none;" ' .
		'href="">' .
		'<img title="' . htmlspecialchars( wfMsg( 'mv_remove_filter' ) ) . '" ' .
		'src="' . $mvgScriptPath . '/skins/images/cog_delete.png"></a>';

		// ref missing person image ref:
		$s .= $this->get_ref_person();

		// add link:
		$s .= '<a style="text-decoration:none;" href="javascript:mv_add_filter();">' .
			'<img border="0" title="' . htmlspecialchars( wfMsg( 'mv_add_filter' ) ) . '" ' .
			'src="' . $mvgScriptPath . '/skins/images/cog_add.png"> ' . htmlspecialchars( wfMsg( 'mv_add_filter' ) ) . '</a><br /><br />';

		/*$s .= '<input id="mv_do_search" type="submit" ' .
		' value="' . wfMsg('mv_run_search') . '">';*/

		return $s . $so;
	}
	function getResultsBar() {
		$o = '<div class="mv_result_bar">';
		if ( $this->numResultsFound ) {
			$re = ( $this->limit + $this->offset > $this->numResultsFound ) ? $this->numResultsFound : ( $this->limit + $this->offset );
			$rs = ( $this->offset == 0 ) ? 1 : $this->offset;
			$o .= wfMsg( 'mv_results_found_for', $rs, $re, number_format( $this->numResultsFound ) );
		}
		$o .= $this->getFilterDesc();
		$o .= '</div>';
		return $o;
	}
	function getSearchLink() {
		return SpecialPage :: getTitleFor( 'MediaSearch' ) .
		$this->get_httpd_filters_query();
	}
	/*
	 * returns human readable description of filters
	 */
	function getFilterDesc( $query_key = false ) {
		$o = $a = '';
		$bo = ( $query_key ) ? '' : '<b>';
		$bc = ( $query_key ) ? '' : '</b>';
		if ( is_array( $this->filters ) ) {
			foreach ( $this->filters as $inx => $f ) {
				if ( $inx != 0 )
					$a = ' ' . wfMsg( 'mv_search_' . $f['a'] ) . ' ';
					if ( $f['t'] != 'match' ) // no desc for text search
						$o .= ( $query_key ) ? $a : $a . wfMsg( 'mv_' . $f['t'] ) . ' ';
				if ( $f['t'] == 'date_range' ) { // handle special case of date range:
					$o .= ' '. wfMsg( 'mv_time_separator', $bo . htmlspecialchars( $f['vs'] ) . $bc, $bo . htmlspecialchars( $f['ve'] ) . $bc );
				} else {
					$o .=' '. $bo . str_replace( '_', ' ', htmlspecialchars( $f['v'] ) ) . $bc .' ';
				}
			}
		}
		return $o;
	}
	function get_ref_person( $inx = '', $person_name = MV_MISSING_PERSON_IMG, $disp = false ) {
		if ( $disp ) {
			$tname = 'f[' . $inx . '][v]';
			$inx = '_' . $inx;
			$disp = 'inline';
		} else {
			$tname = '';
			$inx = '';
			$person_name = '';
			$disp = 'none';
		}
		// make the missing person image ref:
		$imgTitle = Title :: makeTitle( NS_IMAGE, $person_name . '.jpg' );
		if ( !$imgTitle->exists() ) {
			$imgTitle = Title :: makeTitle( NS_IMAGE, MV_MISSING_PERSON_IMG );
		}

		$img = wfFindFile( $imgTitle );
		if ( !$img ) {
			$img = wfLocalFile( $imgTitle );
		}
		// print "title is: " .$imgTitle->getDBkey() ."IMAGE IS: " . $img->getURL();
		$inx = htmlspecialchars( $inx );
		return '<span class="mv_person_ac" id="mv_person' . $inx . '" style="display:' . htmlspecialchars( $disp ) . ';width:90px;">' .
		'<img id="mv_person_img' . $inx . '" style="padding:2px;" src="' . htmlspecialchars( $img->getURL() ) . '" width="44">' .
		'<input id="mv_person_input' . $inx . '" class="mv_search_text" style="font-size: 12px;" size="9" ' .
		'type="text" name="' . htmlspecialchars( $tname ) . '" value="' . htmlspecialchars( $person_name ) . '" autocomplete="off">' .
		'<div id="mv_person_choices' . $inx . '" class="autocomplete"></div>' .
		'</span>';
	}
	function selector( $i, $key, $selected = '', $display = true ) {
		$disp = ( $display ) ? '' : 'display:none;';
		$s = '<select id="mvsel_' . htmlspecialchars( $key ) . '_' .
			htmlspecialchars( $i ) . '" class="mv_search_select" style="font-size: 12px;' .
			htmlspecialchars( $disp ) . '" name="f[' . htmlspecialchars( $i ) . '][' .
			htmlspecialchars( $key ) . ']" >' . "\n";
		$items = ( $key == 't' ) ? $this->sel_filter_types : $this->sel_filter_andor;
		if ( $key == 'a' && $selected == '' )
			$selected = 'and';

		$sel = ( $selected == '' ) ? 'selected' : '';
		if ( $key == 't' )
			$s .= '<option value="na" ' . $sel . '>' . wfMsg( 'mv_search_sel_' . $key ) . '</option>' . "\n";
		foreach ( $items as $item ) {
			$sel = ( $selected == $item ) ? $sel = 'selected' : '';
			$s .= '<option value="' . htmlspecialchars( $item ) . '" ' . $sel . '>' . wfMsg( 'mv_search_' . $item ) . '</option>' . "\n";
		}
		$s .= '</select>';
		return $s;
	}
	// could be a suggest:
	function text_entry( $i, $key, $val = '', $more_class = '', $more_attr = array() ) {
		if ( $more_class != '' )
			$more_class = ' ' . $more_class;
		$default_attr = array( 'size' => '9', 'maxlength' => '255', 'style' => "font-size: 12px;" );
		$more_attr = array_merge( $default_attr, $more_attr );
		foreach ( $more_attr as $k => $v ) {
			$more_attr_out .= ' ' . htmlspecialchars( $k ) . '="' . htmlspecialchars( $v ) . '"';
		}
		$s = '<input ' . $more_attr_out . ' class="mv_search_text' . htmlspecialchars( $more_class ) . '" onchange=""
				type="text" name="f[' . htmlspecialchars( $i ) . '][' . htmlspecialchars( $key ) . ']" value="' . htmlspecialchars( $val ) . '">';
		return $s;
	}
	/*again here is some possibly metavid congress archive specific stuff:*/
	function auto_complete_all( $val ) {
		global $wgContLang;
		// everything is db key based so swap space for underscore:
		$val = str_replace( ' ', '_', $val );

		$catNStxt = $wgContLang->getNsText( NS_CATEGORY );

		// make sure people know they can "search" too (formated by
		$out = 'do_search|' . wfMsg( 'mv_search_transcripts_for', '<B>$1</B>' ) . '|no_image' . "\n";
		// get keywords
		$category_out = MV_SpecialMediaSearch :: auto_complete_search_categories( $val, 3 );
		if ( $category_out != '' ) {
			$out .= $catNStxt . ':Categories|<h6>' . wfMsg( 'mv_category_matches' ) . '</h6>|no_image' . "\n";
			$out .= $category_out;
		}
		// get people
		$person_out = MV_SpecialMediaSearch :: auto_complete_person( $val, 3 );
		if ( $person_out != '' ) {
			$out .= $catNStxt . ':Person|<h6>' . wfMsg( 'mv_people_matches' ) . '</h6>|no_image' . "\n";
			$out .= $person_out;
		}
		// get bills
		$bill_out = MV_SpecialMediaSearch :: auto_complete_category( 'Bill', $val, 3 );
		if ( $bill_out != '' ) {
			$out .= $catNStxt . ':Bill|<h6>' . wfMsg( 'mv_bill_matches' ) . '</h6>|no_image' . "\n";
			$out .= $bill_out;
		}
		// get interests
		$intrest_out = MV_SpecialMediaSearch :: auto_complete_category( 'Interest_Group', $val, 3 );
		if ( $intrest_out != '' ) {
			$out .= $catNStxt . ':Interest Group|<h6>' . wfMsg( 'mv_interest_group_matches' ) . '</h6>|no_image' . "\n";
			$out .= $intrest_out;
		}
		return $out;
	}
	function auto_complete_search_categories( $val, $result_limit = '5', $format = 'ac_line', & $match_count = '' ) {
		global $wgContLang;
		$dbr = & wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'page', 'page_title', array (
			'page_namespace' => NS_CATEGORY,
			'`page_title` LIKE \'%' . mysql_escape_string( $val
		) . '%\' COLLATE latin1_swedish_ci' ), __METHOD__, array (
			'LIMIT' => $result_limit
		) );
		$match_count = $dbr->numRows( $result );
		if ( $dbr->numRows( $result ) == 0 )
			return '';
		$out = '';
		$catNStxt = $wgContLang->getNsText( NS_CATEGORY );
		while ( $row = $dbr->fetchObject( $result ) ) {
			$out .= MV_SpecialMediaSearch :: format_ac_line( $row->page_title, $val, $catNStxt . ':', 'no_image', $format );
		}
		return $out;
	}
	function auto_complete_category( $category, $val, $result_limit = '5', $format = 'ac_line', & $match_count = '' ) {
		$dbr = & wfGetDB( DB_SLAVE );
		//do value pre-proccessing if bill type:
		if($category=='Bill')
			$val = MV_SpecialMediaSearch::bill_formater( $val );

		$result = $dbr->select( 'categorylinks', 'cl_sortkey', array (
			'cl_to' => $category,
			'`cl_sortkey` LIKE \'%' . mysql_escape_string( $val
		) . '%\'  COLLATE latin1_swedish_ci' ), __METHOD__, array (
			'LIMIT' => $result_limit
		) );
		// print 'ran: ' .  $dbr->lastQuery();
		// mention_bill catebory Bill
		$match_count = $dbr->numRows( $result );
		if ( $dbr->numRows( $result ) == 0 )
			return '';
		$out = '';
		while ( $row = $dbr->fetchObject( $result ) ) {
			$out .= MV_SpecialMediaSearch :: format_ac_line( $row->cl_sortkey, $val, '', 'no_image', $format );
		}
		return $out;
	}
	/*@@todo cache result for given values*/
	function auto_complete_person( $val, $result_limit = '5', $format = 'ac_line', & $match_count = '', & $person_ary = array() ) {
		$dbr = & wfGetDB( DB_SLAVE );

		//first check the nick names:
		$nick_rows = MV_SpecialMediaSearch::getViaNickname($val, $result_limit);
		foreach($nick_rows as $person){
			$person_ary[$person]=true;
		}

		$result = $dbr->select( 'categorylinks', 'cl_sortkey', array (
			'cl_to' => 'Person',
			'`cl_sortkey` LIKE \'%' . mysql_escape_string( $val
		) . '%\' COLLATE latin1_swedish_ci' ), __METHOD__, array (
			'LIMIT' => $result_limit
		) );
		$out = '';
		while ( $row = $dbr->fetchObject( $result ) ) {
			$person_name = $row->cl_sortkey;
			$person_ary[$person_name] = true;
		}

		if(count($person_ary)==0)
			return '';


		foreach($person_ary as $person_name=>$na){
			// make sure the person page exists:
			$personTitle = Title :: makeTitle( NS_MAIN, $person_name );
			if ( $personTitle->exists() ) {
				// dont try and get person full name from semantic table if available
				$person_full_name = $person_name;
				// format and output the line:
				$out .= MV_SpecialMediaSearch :: format_ac_line( $person_full_name, $val, '', MV_SpecialMediaSearch :: getPersonImageURL( $person_name ), $format );
			}
		}
		// $out.='</ul>';
		// return people people in the Person Category
		return $out;
	}
	//returns results via nickname via semantic query:
	function getViaNickname($partname, $limit=5){
		//split the nickname via spaces:
		$nick_parts = split('_', str_replace(' ', '_',$partname));
		$query_string='';
		$or='';
		foreach($nick_parts as $pname){
			$query_string.= $or . ' [[Nickname::~*'.ucfirst($pname).'*]] OR [[Nickname::'.ucfirst($pname).']] ';
			$or=' OR ';
		}
		$params=array('format' => 'broadtable',
    				  'offset' => 0,
					  'limit'	=>$limit);
		$results = array();
		$queryobj = SMWQueryProcessor::createQuery($query_string, $params, false, '', array());
		$queryobj->querymode = SMWQuery::MODE_INSTANCES;
		$res = smwfGetStore()->getQueryResult($queryobj);

		for($i=0;$i< $res->getCount();$i++){
			$v =  $res->getNext();
			$v = current(current($v)->getContent());
			array_push( $results, $v->getXSDValue());
		}
		//replace result text:
		return $results;
	}
	function getPersonImageURL( $person_name ) {
		// make the missing person image ref:
		$imgTitle = Title :: makeTitle( NS_IMAGE, $person_name . '.jpg' );
		if ( !$imgTitle->exists() ) {
			$imgTitle = Title :: makeTitle( NS_IMAGE, MV_MISSING_PERSON_IMG );
		}
		$img = wfFindFile( $imgTitle );
		if ( !$img ) {
			$img = wfLocalFile( $imgTitle );
		}
		return $img->getURL();
	}
	function bill_formater($val){
		$val = preg_replace('/[Ss]\.?\s?([0-9])/','S._$1',$val);
		$val = preg_replace('/[Hh]\.?[Rr]\.?\s?([0-9])/','H.R._$1',$val);
		$val = preg_replace('/[Hh][Rr][Ee][Ss]\.?\s?([0-9])/','HRes._$1',$val);
		return $val;
	}
	function format_ac_line( & $page_title, $val, $prefix = '', $img_link = 'no_image', $format = 'ac_line' ) {
		// no underscores in display title:
		$page_title_disp = str_replace( '_', ' ', $page_title );
		// bold matching part of title:
		$bs = stripos( $page_title_disp, str_replace( '_', ' ', $val ) );
		if ( $bs !== false ) {
			$page_title_disp = substr( $page_title_disp, 0, $bs ) .
			'<b>' . substr( $page_title_disp, $bs, strlen( $val ) ) .
			'</b>' . substr( $page_title_disp, $bs + strlen( $val ) );
		}
		// $page_title_bold = str_ireplace($val, '<b>'.$val.'</b>',$page_title);
		if ( $format == 'ac_line' ) {
			return $prefix . $page_title . '|' . $page_title_disp . '|' . $img_link . "\n";
		} else
			if ( $format == 'block_html' || $format == 'person_html' ) {
				global $wgUser;
				$sk = $wgUser->getSkin();
				$title = Title :: newFromText( $prefix . $page_title );

				if ( $format == 'block_html' )
					return "<p class=\"normal_match\">" . $sk->makeKnownLinkObj( $title, '<span>' .
					$page_title_disp . '</span>' ) . '</p>';

				if ( $format == 'person_html' )
					return "<p class=\"people2_match last_match\"><img src=\"{$img_link}\">" . $sk->makeKnownLinkObj( $title, $page_title_disp ) . '</p>';
			}
	}
	// return a json date obj
	// @@todo fix for big sites...(will start to be no fun if number of streams is > 2000 )
	function getJsonDateObj( $obj_name = 'mv_result' ) {
		$dbr = & wfGetDB( DB_SLAVE );
		$sql = 'SELECT `date_start_time` FROM `mv_streams` ' .
		'WHERE `date_start_time` IS NOT NULL ' .
		'ORDER BY `date_start_time` ASC  LIMIT 0, 2000';
		$res = $dbr->query( $sql, 'MV_SpecialMediaSearch:getJsonDateObj' );
		$start_day = time();
		$end_day = 0;
		$delta = 0;
		$sDays = array ();
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->date_start_time == 0 )
				continue; // skip empty / zero values
			if ( $row->date_start_time < $start_day )
				$start_day = $row->date_start_time;
			if ( $row->date_start_time > $end_day )
				$end_day = $row->date_start_time;
			list ( $month, $day, $year ) = explode( '/', date( 'm/d/Y', $row->date_start_time ) );
			$month = trim( $month, '0' );
			$day = trim( $day, '0' );
			if ( !isset ( $sDays[$year] ) )
				$sDays[$year] = array ();
			if ( !isset ( $sDays[$year][$month] ) )
				$sDays[$year][$month] = array ();
			if ( !isset ( $sDays[$year][$month][$day] ) ) {
				$sDays[$year][$month][$day] = 1;
			} else {
				$sDays[$year][$month][$day]++;
			}
		}
		return php2jsObj( array (
			'sd' => date( 'm/d/Y',
			$start_day
		), 'ed' => date( 'm/d/Y', $end_day ), 'sdays' => $sDays ), $obj_name );
	}
}