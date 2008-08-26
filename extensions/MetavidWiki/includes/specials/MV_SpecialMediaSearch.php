<?php
/*
 * Created on Jul 26, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * overwrites the existing special search to add in metavid specific features
 */
if (!defined('MEDIAWIKI'))	die();

function doSpecialSearch($par = null) {
	//list( $limit, $offset ) = wfCheckLimits();
	$MvSpecialSearch = new MV_SpecialMediaSearch();
	$MvSpecialSearch->doSearchPage();
}
//metavid search page (only search video media)
SpecialPage :: addPage(new SpecialPage('MediaSearch', '', true, 'doSpecialSearch', false));

/*
 * adds media results to top of special page: 
 */
class MV_SpecialSearch extends SpecialPage{
	function MV_SpecialSearch( ) {
		global $wgOut, $wgRequest;		
		mvfAddHTMLHeader('search');
		$MvSpecialSearch = new MV_SpecialMediaSearch();				
		$MvSpecialSearch->doSearch( $wgRequest->getVal('search') );
		$wgOut->addHTML($MvSpecialSearch->getResultsHTML());
		SpecialPage::SpecialPage('Search');			
	}
}
/*
 * simple/quick implementation ... 
 * future version should be better integrated with semantic wiki and or 
 * an external scalable search engine ie sphinx or lucene
 * 
 * example get request: filter 0, type match, value = wars 
 * ?f[0]['t']=m&f[0]['v']=wars
 */
class MV_SpecialMediaSearch extends SpecialPage {
	//initial values for selectors ( keys into language as 'mv_search_$val')
	var $sel_filter_types = array (
		'match', 		//full text search
		'spoken_by',	
		'category',	
		'date_range', //search in a given date range
		//not yet active: 
		//'stream_name', //search within a particular stream
		//'layers'	 //specify a specific meta-layer set
		//'smw_property' 
		//'smw_property_numeric'
	);	
	var $sel_filter_andor = array (
		'and',
		'or',
		'not',
	);	
	var $results=array();
	var $mName = 'MediaSearch';	
	var $outputInlineHeader =true;
	var $outputContainer = true;
	var $outputSeqLinks = false;
	
	var $limit = 20;
	var $offset = 0;
	
	function doSearchPage($term='') {		
		global $wgRequest, $wgOut;
		$this->setUpFilters();
		//do the search
		$this->doSearch();
		//page control: 
		$this->outputInlineHeader=false;
		if($wgRequest->getVal('seq_inline')=='true'){
			$this->outputContainer = false;
			$this->outputSeqLinks=true;
			//@@todo add a absolute link to search results
			print $this->getResultsHTML(true);
			//@@todo cleaner exit
			exit();
		}else{
			//add nessesary js to wgOut: 
			mvfAddHTMLHeader('search');	
			//add the search placeholder 
			$wgOut->addWikiText( wfMsg( 'searchresulttext' ) );
			$wgOut->addHTML($this->dynamicSearchControl());		
			//$wgOut->addHTML($this->getResultsBar());			
			$wgOut->addHTML($this->getResultsHTML());			
		}
	}
	function dynamicSearchControl() {
		$title = SpecialPage :: getTitleFor('MediaSearch');
		$action = $title->escapeLocalURL();

		return "\n<form id=\"mv_media_search\" method=\"get\" " .
		"action=\"$action\">\n{$this->list_active_filters()}\n</form>\n";
	}
	function setupFilters($defaultType='empty', $opt=null){
		global $wgRequest;
		
		//first try any key titles: 
		$title_str = $wgRequest->getVal('title');
		$tp = split('/',$title_str);
		if(count($tp)==3){
			switch($tp[1]){
				case 'person':
					$this->filters = array(
						array(
							't'=>'spoken_by',
							'v'=>str_replace('_',' ',$tp[2])
						)
					);
				break;
			}	
		}else{		
			if (isset ($_GET['f'])) {
				//@@todo more input processing
				$this->filters = $_GET['f'];
			} else {			
				switch($defaultType){
					case 'stream':
						$this->filters = array (
							array(
								't' =>'stream_name',
								'v' =>$opt['stream_name']
							)
						);					
					break;				
					case 'empty':
					default:
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
	function doSearch($term='') {
		//force a single term:
		if($term!=''){
			$this->filters = array (
				array (
					't' => 'match',
					'v' => $term
				)
			);
		}
		$mvIndex = new MV_Index();
		$this->results = $mvIndex->doFiltersQuery($this->filters);
		$this->num = $mvIndex->numResults();
		$this->numResultsFound = $mvIndex->numResultsFound();
		if(isset($mvIndex->offset))	$this->offset = $mvIndex->offset;
		if(isset($mvIndex->limit)) $this->limit = $mvIndex->limit;
	}
	/*list all the meta *layer* types */
	function powerSearchOptions() {
		global $mvMVDTypeAllAvailable;
		$opt = array();
		//group track_req
		$opt['tracks']='';
		$coma='';
		foreach( $mvMVDTypeAllAvailable as $n ) {
			$opt['tracks'].= $coma. $n;
			$coma=',';	
		}
		//$opt['redirs'] = $this->searchRedirects ? 1 : 0;
		//$opt['searchx'] = 1;
		return $opt;
	}
	function getResultsCMML(){
		
	}
	function getResultsHTML() {
		global $mvgIP, $wgOut, $mvgScriptPath, $mvgContLang, $wgUser, $wgParser;
		$sk = & $wgUser->getSkin();
		$o = '';							
		if($this->outputContainer)$o.='<div id="mv_search_results_container">';	
			
		//for each stream range:		
		if (count($this->results) == 0) {
			$o.= '<h2><span class="mw-headline">' . wfMsg('mv_search_no_results') . '</span></h2>';
			if($this->outputContainer)$o.='</div>';
			return $o;
		}else{
			if($this->outputInlineHeader){
				$o.='<h2>
						<span class="mw-headline">'. wfMsg('mv_media_matches') . '</span>
					</h2>';
				$title = Title :: MakeTitle(NS_SPECIAL, 'MediaSearch');
				$o.= $sk->makeKnownLinkObj($title, wfMsg('mv_advaced_search'), 
						$this->get_httpd_filters_query() );
			}
		}	
		//media pagging:
		$prevnext = mvViewPrevNext( $this->offset, $this->limit,
				SpecialPage::getTitleFor( 'MediaSearch' ),
					$this->get_httpd_filters_query(),
					($this->num < $this->limit) );
		$o.="<br /><span id=\"mv_search_pagging\">{$prevnext}</span>\n";		
		//add the rss link: 
		$sTitle=Title::MakeTitle(NS_SPECIAL, 'MvExportSearch');
		$o.='<span style="float:right;">';
		$o.=$sk->makeKnownLinkObj($sTitle, 
			'<img border="0" src="' . $mvgScriptPath . '/skins/images/feed-icon-28x28.png">',
			$this->get_httpd_filters_query() );
		$o.='</span>';
		//add the results bar:
		$o.=$this->getResultsBar();
		//print_r($this->results);
		foreach ($this->results as $stream_id => & $stream_set) {			
			$matches = 0;
			$stream_out = $mvTitle = '';			
			foreach ($stream_set as & $srange) {
				$cat_html = $mvd_out = '';
				$range_match=0;						
				foreach ($srange['rows'] as $inx=> & $mvd) {								
					$matches++;			
					$mvTitle = new MV_Title($mvd->wiki_title);

					//retrieve only the first article: 
					//$title = Title::MakeTitle(MV_NS_MVD, $mvd->wiki_title);
					//$article = new Article($title);					
					
					$bgcolor=MV_Overlay::getMvdBgColor($mvd);
					//output indent if not the first and count more than one 
					if(count($srange['rows'])!=1 && $inx!=0)				
						$mvd_out.='&nbsp; &nbsp; &nbsp; &nbsp;';
					//'<img src="'. $mvgScriptPath . '/skins/images/film.png">'					
					//$mvd_out .= '<div class="mv_rtdesc" title="' . wfMsg('mv_expand_play') . '"  '. 
					//				'> ';
					$mvd_out .= '<img style="float:left;width:84px;cursor:pointer;border:solid #'.$bgcolor.'" '.
						' onclick="mv_ex(\'' . $mvd->id . '\')" width="80" height="60" src="'.$mvTitle->getStreamImageURL('icon') . '">';
					$mvd_out.= '</div>';
					$mvd_out.='<b>' .$mvTitle->getTimeDesc() . '</b>&nbsp;';
					$mvd_cnt_links='';
					if(isset($mvd->spoken_by)){											
						$ptitle = Title::MakeTitle(NS_MAIN, $mvd->spoken_by);					
						$mvd_cnt_links.=wfMsg('mv_search_spoken_by').': '.$sk->makeKnownLinkObj($ptitle);
						$mvd_cnt_links.='<br>';
					}
					if($this->outputSeqLinks==true){
						$mvd_cnt_links .='&nbsp;<a href="javascript:mv_add_to_seq({mvclip:\''.
										$mvTitle->getStreamName().'/'.$mvTitle->getTimeRequest().'\','.
										'src:\''.$mvTitle->getWebStreamURL().'\','.
										'img_url:\''.$mvTitle->getStreamImageURL().'\'})">'.
										'<img style="cursor:pointer;" '.
										'title="'.wfMsg('mv_seq_add_end').'" '.
										'src="'.$mvgScriptPath .'/skins/mv_embed/images/application_side_expand.png">'. wfMsg('mv_seq_add_end').'</a>';
					}
					$mvd_cnt_links .= '<a title="' . wfMsg('mv_expand_play') . '" href="javascript:mv_ex(\'' . $mvd->id . '\')">'.
							'<img id="mv_img_ex_'.$mvd->id.'"  src="' . $mvgScriptPath . '/skins/images/closed.png">'.
								'<span id="mv_watch_clip_'.$mvd->id.'">'.wfMsg('mv_watch_clip').'</span>'.
								'<span style="display:none;" id="mv_close_clip_'.$mvd->id.'">'.wfMsg('mv_close_clip').'</span>'.
							'</a>' .
						'&nbsp;&nbsp;';
					//output control links:
					//make stream title link:						
					 
					$mvStreamTitle = Title :: MakeTitle(MV_NS_STREAM, $mvTitle->getNearStreamName());
					//$mvTitle->getStreamName() .'/'.$mvTitle->getStartTime() .'/'. $mvTitle->getEndTime() );
					$mvd_cnt_links .= $sk->makeKnownLinkObj($mvStreamTitle, '<img border="1" src="' . $mvgScriptPath . '/skins/images/run_mv_stream.png"> '.wfMsg('mv_improve_transcript'), '', '', '', '', ' title="' . wfMsg('mv_view_in_stream_interface') . '" ');
					$mvd_cnt_links .= '<br>';			
					//$title = MakeTitle::()
					//don't inclue link to wiki page (too confusing) 
					//$mvd_out .='&nbsp;';
					$mvdTitle = Title::MakeTitle(MV_NS_MVD, $mvd->wiki_title);
					//$mvd_out .= $sk->makeKnownLinkObj($mvdTitle, '<img border="0" src="' . $mvgScriptPath . '/skins/images/run_mediawiki.png">', '', '', '', '', ' title="' . wfMsg('mv_view_wiki_page') . '" ');												
										
					$mvd_out.='<span id="mvr_desc_'.$mvd->id.'">';
										 
					
					if(!isset($mvd->toplq))$mvd->toplq=false;							
					//output short desc send partial regEx: 
					if (!$mvd->toplq){					
						$mvd_out.= $this->termHighlight($mvd->text, implode('|', $this->getTerms()));						
					}else {
						if($mvdTitle->exists() && !isset($mvd->text)){	
							//grab the article text:
							$curRevision = Revision::newFromTitle($mvdTitle);			
							$wikiText = $curRevision->getText();
						}else{
							$wikiText = & $mvd->text;
						}
						//@@todo parse category info if present
						$cat_html = '';					
						//run via parser to add in Category info: 
						$parserOptions = ParserOptions :: newFromUser($wgUser);
						$parserOptions->setEditSection(false);
						$parserOptions->setTidy(true);
						$title = Title :: MakeTitle(MV_NS_MVD, $mvd->wiki_title);
						$parserOutput = $wgParser->parse($wikiText, $title, $parserOptions);
						$cats = $parserOutput->getCategories();
						foreach ($cats as $catkey => $title_str) {
							$catTitle = Title :: MakeTitle(NS_CATEGORY, $catkey);
							$cat_html .= ' ' . $sk->makeKnownLinkObj($catTitle);
						}
						//add category pre-text:
						//if ($cat_html != '')
						//$mvd_out.= wfMsg('Categories') . ':' . $cat_html;
						$mvd_out.=$cat_html;
						
						$mvd_out.= (count($srange['rows'])-1==1)
							? wfMsg('mv_match_text_one')
							: wfMsg('mv_match_text', count($srange['rows'])-1);
						//$wgOut->addCategoryLinks( $parserOutput->getCategories() );						
						//$cat_html = $sk->getCategories();
						//empty out the categories
						//$wgOut->mCategoryLinks = array();	
					}
					$mvd_out.='</span>';
					$mvd_out.='<br>'.$mvd_cnt_links;
					$mvd_out.='<div style="display:block;clear:both;padding-top:4px;padding-bottom:4px;"/>';
					$mvd_out .= '<div id="mvr_' . $mvd->id . '" style="display:none;background:#'.$bgcolor.';" ></div>';					
														
				}			
				$stream_out .= $mvd_out;
				/*if(count($srange['rows'])!=1){					
					$stream_out .= '&nbsp;' . $cat_html . ' In range:' . 
					seconds2ntp($srange['s']) . ' to ' . seconds2ntp($srange['e']) .
					wfMsg('mv_match_text', count($srange['rows'])).'<br />' . "\n";
					$stream_out .= $mvd_out;
				}else{								
					$stream_out .= $mvd_out;
				}*/				
			}
			$nsary = $mvgContLang->getNamespaces();
			//output stream name and mach count
			/*$o.='<br /><img class="mv_stream_play_button" name="'.$nsary[MV_NS_STREAM].':' .
				$mvTitle->getStreamName() .
					'" align="left" src="'.$mvgScriptPath.'/skins/mv_embed/images/vid_play_sm.png">';
			*/					
			$o.= '<h3>' . $mvTitle->getStreamNameText();
			$o.=($matches==1)?wfMsg('mv_match_text_one'):wfMsg('mv_match_text', $matches);
			$o.='</h3>';
			$o.= '<div id="mv_stream_' . $stream_id . '">' . $stream_out . '</div>';
		}
		if($this->outputContainer)$o.='</div>';
		return $o;
	}
	function getTerms(){
		$ret_ary = $cat_ary = array();		
		foreach($this->filters as $filter){
			switch ($filter['t']) {
				case 'match':							
				case 'spoken_by':
				case 'stream_name':
					$ret_ary[] = $filter['v'];
				break;
				case 'category' :
					$cat_ary[] =$filter['v'];
				break;
				case 'smw_property' :
				
				break;
				case 'smw_property_number': 
					//should be special case for numeric values 
				break;
			}
		}
		return $ret_ary+$cat_ary;
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
	function termHighlight( & $text, $terms ) {
		//$fname = 'SpecialSearch::termHighlight';
		//wfProfileIn( $fname );
		global $wgUser, $wgContLang, $wgLang;
		$sk = $wgUser->getSkin();
		$contextlines=1;
		$contextchars=50;

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
			++$lineno;
			$m = array();
			if ( ! preg_match( $pat1, $line, $m ) ) {
				continue;
			}
			--$contextlines;
			$pre = $wgContLang->truncate( $m[1], -$contextchars, '...' );

			if ( count( $m ) < 3 ) {
				$post = '';
			} else {
				$post = $wgContLang->truncate( $m[3], $contextchars, '...' );
			}

			$found = $m[2];

			$line = htmlspecialchars( $pre . $found . $post );
			$pat2 = '/(' . $terms . ")/i";
			$line = preg_replace( $pat2,
			  "<span class='searchmatch'>\\1</span>", $line );

			//$extract .= " <small>{$lineno}: {$line}</small>\n";
			$extract .= " <small>{$line}</small>\n";
		}		
		//if we found no matches just return the first line: 		
		if($extract=='')return ' <small>'. $wgContLang->truncate($text, ($contextchars*2), '...').'</small>';
		//wfProfileOut( "$fname-extract" );
		//wfProfileOut( $fname );
		//return "<li>{$link} ({$size}){$extract}</li>\n";
		return $extract;
	}
	//output expanded request via mvd_id
	function expand_wt($mvd_id, $terms_ary) {
		global $wgOut,$mvgIP;
		global $mvDefaultSearchVideoPlaybackRes;		
		
		$mvd = MV_Index::getMVDbyId($mvd_id);
		if(count($mvd)!=0){			
			$mvTitle = new MV_Title($mvd->wiki_title);
			//validate title and load stream ref:
			if($mvTitle->validRequestTitle()){				
				list($vWidth, $vHeight) = explode('x', $mvDefaultSearchVideoPlaybackRes); 
				$embedHTML='<span style="float:left;width:'.($vWidth+20).'px">' . 
								$mvTitle->getEmbedVideoHtml('vid_'.$mvd_id, $mvDefaultSearchVideoPlaybackRes, '',$autoplay=true) .
							'</span>';
				$wgOut->clearHTML();
				$MvOverlay = new MV_Overlay();	
				$MvOverlay->outputMVD($mvd, $mvTitle);	
				$pageHTML='<span style="padding-top:10px;float:left;width:450px">'.
								$wgOut->getHTML().
						 	'</span>';	
						  							
				//return page html: 									
				return $embedHTML. $pageHTML. '<div style="clear: both;"/>';
			}else{
				return wfMsg('mvBadMVDtitle');
			}
		}else{
			return wfMsg('mv_error_mvd_not_found');
		}
		//$title = Title::MakeTitle(MV_NS_MVD, $wiki_title);
		//$article = new Article($title);
		//output table with embed left, and content right
		//return $wgOut->parse($article->getContent());
	}
	function get_httpd_filters_query(){
		//get all the mvd ns selected: 
		$opt = $this->powerSearchOptions();			
		return http_build_query($opt +array('f'=>$this->filters));
	}
	function list_active_filters() {
		global $mvgScriptPath;
		$s=$so='';	
		$dateObjOut=false;
		$s .= '<div id="mv_active_filters" style="margin-bottom:10px;">';			
		foreach ($this->filters as $i => $filter) {
			if (!isset ($filter['v'])) //value
				$filter['v'] = '';
			if (!isset ($filter['t'])) //type
				$filter['t'] = '';
			if (!isset ($filter['a'])) //and, or, not
				$filter['a']='';				
			
			//output the master selecter per line: 
			$s .= '<span id="mvs_' . $i . '">';		
			$s .= '&nbsp;&nbsp;';						
			//selctor (don't display if i==0')
			$s .= $this->selector($i, 'a', $filter['a'],($i==0)?false:true ); 		
			$s .= $this->selector($i, 't', $filter['t']); //type selector
			$s .= '<span id="mvs_' . $i . '_tc">';
			switch ($filter['t']) {			
				case 'match' :
					$s .= $this->text_entry($i, 'v', $filter['v'], 'mv_hl_text');
					break;
				case 'category' :
					//$s.=$this->get_ref_ac($i, $filter['v']);
					$s .= $this->text_entry($i, 'v', $filter['v']);
				break;
				case 'date_range':
					$s .=wfMsg('mv_time_separator',
							$this->text_entry($i, 'vs', $filter['vs'], 'date-pick_'.$i, 'id="vs_'.$i.'"'),
							$this->text_entry($i, 've', $filter['ve'], 'date-pick_'.$i, 'id="ve_'.$i.'"')
						);
					//also output dateObj (if not already output):
					if(!$dateObjOut){
						global $wgOut;
						//add all date scripts:
						$wgOut->addScript("\n".
							'<!-- required plugins -->
							<script type="text/javascript" src="'.$mvgScriptPath.'/skins/mv_embed/jquery/plugins/date.js"></script>
							<!--[if IE]><script type="text/javascript" src="'.$mvgScriptPath.'/skins/mv_embed/jquery/plugins/jquery.bgiframe.js"></script><![endif]-->
							
							<!-- jquery.datePicker.js -->
							<script type="text/javascript" src="'.$mvgScriptPath.'/skins/mv_embed/jquery/plugins/jquery.datePicker.js"></script>
							<script language="javascript" type="text/javascript">'.
							$this->getJsonDateObj('mvDateInitObj') .
							'</script>');
						$dateObjOut=true;
					}
				break;
				case 'stream_name':
					$s .= $this->text_entry($i, 'v', $filter['v']);
				break;
				case 'spoken_by' :
					$s .= $this->get_ref_person($i, $filter['v'], true);
					break;
				case 'smw_property' :

				break;
			}
			$s .= '</span>';
			if ($i > 0)
				$s .= '&nbsp; <a href="javascript:mv_remove_filter(' .
				$i . ');">' .
				'<img title="' . wfMsg('mv_remove_filter') . '" ' .
				'src="' . $mvgScriptPath . '/skins/images/cog_delete.png"></a>';
			$s .= '</span>';
		}		
		$s .= '</div>';
		//reference remove 
		$s .= '<a id="mv_ref_remove" style="display:none;" ' .
		'href="">' .
		'<img title="' . wfMsg('mv_remove_filter') . '" ' .
		'src="' . $mvgScriptPath . '/skins/images/cog_delete.png"></a>';

		//ref missing person image ref: 							
		$s .= $this->get_ref_person();

		//add link:
		$s .= '<a href="javascript:mv_add_filter();">' .
		'<img border="0" title="' . wfMsg('mv_add_filter') . '" ' .
		'src="' . $mvgScriptPath . '/skins/images/cog_add.png"></a> ';

		$s .= '<input id="mv_do_search" type="submit" ' .
		' value="' . wfMsg('mv_run_search') . '">';				
		
		return $s . $so;
	}
	function getResultsBar(){		
		$o='<div class="mv_result_bar">';
		if($this->numResultsFound){
			$re = ($this->limit+$this->offset > $this->numResultsFound)?$this->numResultsFound:($this->limit+$this->offset);
			$rs = ($this->offset==0)?1:$this->offset;
			$o.=wfMsg('mv_results_found_for',$rs,$re , number_format($this->numResultsFound));
		}
		$o.=$this->getFilterDesc();
		$o.='</div>';
		return $o;
	}
	/*
	 * returns human readable description of filters
	 */
	function getFilterDesc(){
		$o=$a='';
		foreach($this->filters as $inx=>$f){	
			if($inx!=0)$a=wfMsg('mv_search_'.$f['a']).' ';	
			if($f['t']=='date_range'){ //handle special case of date range: 
				$o.=' '.$a.wfMsg('mv_'.$f['t']).' '.wfMsg('mv_time_separator', '<b>'.$f['vs'].'</b>','<b>'.$f['ve'].'</b>');
			}else{
				$o.=' '.$a.wfMsg('mv_'.$f['t']).' <b>'. str_replace('_',' ',$f['v']).'</b> ';
			}
		}
		return $o;
	}
	function get_ref_person($inx = '', $person_name = MV_MISSING_PERSON_IMG, $disp = false) {
		if($disp) {
			$tname = 'f[' . $inx . '][v]';
			$inx = '_' . $inx;
			$disp = 'inline';
		}else{
			$tname = '';
			$inx = '';
			$person_name = '';
			$disp = 'none';
		}		
		//make the missing person image ref: 
		$imgTitle = Title :: makeTitle(NS_IMAGE, $person_name . '.jpg');
		if (!$imgTitle->exists()) {
			$imgTitle = Title :: makeTitle(NS_IMAGE, MV_MISSING_PERSON_IMG);
		}

		$img = wfFindFile($imgTitle);
		if (!$img) {
			$img = wfLocalFile($imgTitle);
		}
		//print "title is: " .$imgTitle->getDBkey() ."IMAGE IS: " . $img->getURL();

		return '<span class="mv_person_ac" id="mv_person' . $inx . '" style="display:' . $disp . ';width:90px;">' .
			'<img id="mv_person_img' . $inx . '" style="padding:2px;" src="' . $img->getURL() . '" width="44">' .
			'<input id="mv_person_input' . $inx . '" class="mv_search_text" style="font-size: 12px;" size="9" ' .
			'type="text" name="' . $tname . '" value="' . $person_name . '" autocomplete="off">' .
			'<div id="mv_person_choices'.$inx.'" class="autocomplete"></div>' .
			'</span>';
	}
	function selector($i, $key, $selected='', $display=true) {
		$disp = ($display)?'':'display:none;';
		$s= '<select id="mvsel_'.$key.'_' . $i . '" class="mv_search_select" style="font-size: 12px;'.$disp.'" name="f['.$i .']['.$key.']" >' . "\n";	
		$items = ($key == 't')?$this->sel_filter_types:$this->sel_filter_andor;		
		if($key=='a' && $selected=='')
			$selected='and';
				
		$sel = ($selected == '') ? 'selected' : '';
		if($key=='t')
			$s .= '<option value="na" ' . $sel . '>' . wfMsg('mv_search_sel_' . $key) . '</option>' . "\n";
		foreach ($items as $item) {
			$sel = ($selected == $item) ? $sel = 'selected' : '';
			$s .= '<option value="' . $item . '" ' . $sel . '>' . wfMsg('mv_search_' . $item) . '</option>' . "\n";
		}
		$s .= '</select>';
		return $s;
	}
	//could be a suggest: 
	function text_entry($i, $key, $val = '', $more_class='', $more_attr='') {
		if($more_class!='')$more_class=' '.$more_class;		
		$s = '<input '.$more_attr.' class="mv_search_text'.$more_class.'" style="font-size: 12px;" onchange="" 
						size="9" type="text" name="f[' . $i . '][' . $key . ']" value="' . $val . '">';
		return $s;
	}
	/*again here is some possibly metavid congress archive specific stuff:*/
	function auto_complete_all($val){
		//everything is db key based so swap space for underscore:
		$val = str_replace(' ','_',$val);				
		
		//make sure people know they can "search" too (formated by  
		$out='do_search|'.wfMsg('mv_search_transcripts_for').' <B>$1</B>|no_image'."\n";
		//get people
		$person_out = MV_SpecialMediaSearch::auto_complete_person($val, 3);
		if($person_out!=''){
			$out.='Category:Person|<h2>People:</h2> |no_image'."\n";
			$out.=$person_out;
		}
		//get bills		
		$bill_out = MV_SpecialMediaSearch::auto_complete_category('Bill', $val, 3);
		if($bill_out!=''){
			$out.='Category:Bill|<h2>Bills:</h2>|no_image'."\n";
			$out.=$bill_out;
		}
		//get intrests
		$intrest_out = MV_SpecialMediaSearch::auto_complete_category('Interest_Group', $val, 3);
		if($intrest_out!=''){
			$out.='Category:Interest Group|<h2>Interest Group:</h2>|no_image'."\n";
			$out.=$intrest_out;
		}
		return $out;
	}
	function auto_complete_category($category, $val,  $result_limit='5'){
		$dbr =& wfGetDB(DB_SLAVE);		
		$result = $dbr->select( 'categorylinks', 'cl_sortkey', 
			array('cl_to'=>$category, 
			'`cl_sortkey` LIKE \'%'.mysql_escape_string($val).'%\'  COLLATE latin1_general_ci'),
			__METHOD__,
			array('LIMIT'=>$result_limit));
		//print 'ran: ' .  $dbr->lastQuery();
		//mention_bill catebory Bill
		if($dbr->numRows($result) == 0)return '';
		$out='';
		while($row = $dbr->fetchObject($result)){
			$page_title = $row->cl_sortkey;
			//bold matching part of title: 
			$bs = stripos($page_title, $val);								
			if($bs!==false){	
					$page_title_bold = substr($page_title, 0, $bs) .
					 '<b>'.substr($page_title, $bs, strlen($val)) .
					 '</b>' . substr($page_title, $bs+strlen($val)); 
			}else{
					$page_title_bold = $page_title;
			} 
			//$page_title_bold = str_ireplace($val, '<b>'.$val.'</b>',$page_title);
			$out.=$page_title.'|'.$page_title_bold.'|no_image'."\n";
		}
		return $out;
	}
	/*@@todo cache result for given values*/
	function auto_complete_person($val, $result_limit='5'){
		$dbr =& wfGetDB(DB_SLAVE);		
		$result = $dbr->select( 'categorylinks', 'cl_sortkey', 
			array('cl_to'=>'Person', 
			'`cl_sortkey` LIKE \'%'.mysql_escape_string($val).'%\' COLLATE latin1_general_ci'),
			__METHOD__,
			array('LIMIT'=>$result_limit));
		//print "ran: " . $dbr->lastQuery();
		if($dbr->numRows($result) == 0)return '';
		//$out='<ul>'."\n";
		$out='';
		while($row = $dbr->fetchObject($result)){
			$person_name = $row->cl_sortkey;
			//make sure the person page exists: 
			$personTitle = Title::makeTitle(NS_MAIN, $person_name);
			if($personTitle->exists()){
				//get person full name from semantic table if available
				$person_result = $dbr->select('smw_attributes', 'value_xsd', array('attribute_title'=>'Full_Name',
										'subject_title'=>$personTitle->getDBkey()),
										__METHOD__);
				if($dbr->numRows($person_result)== 0){
					$person_full_name = $person_name;
				}else{
					$pvalue = $dbr->fetchObject($person_result);
					$person_full_name = $pvalue->value_xsd;
				}			
				//if we have a image toss that in there too 				
				$imgHTML='';
				$imgTitle = Title::makeTitle(NS_IMAGE, $person_name.'.jpg');
				if($imgTitle->exists()){
					$img= wfFindFile($imgTitle);
					if ( !$img ) {
						$img = wfLocalFile( $imgTitle );										
					}										
				}else{
					$imgTitle = Title::makeTitle(NS_IMAGE, MV_MISSING_PERSON_IMG);
					$img= wfFindFile($imgTitle);	
				}
				//$imgHTML="<img src=\"{$img->getURL()}\" width=\"44\">";
				//bold the part of the selected title 
				$sval = str_replace('_', ' ', $val); 
				//$person_name_bold = str_ireplace($val, '<b>'.$val.'</b>', $person_full_name);
				$bs = stripos($person_full_name, $sval);		 
				//print $person_full_name . ' serch for: ' . $val . "<br>";
				if($bs!==false){	
					$person_name_bold = substr($person_full_name, 0, $bs) .
					 '<b>'.substr($person_full_name, $bs, strlen($val)) .
					 '</b>' . substr($person_full_name, $bs+strlen($val)); 
				}else{
					$person_name_bold = $person_full_name;
				} 
				$out.=  $person_name.'|'.$person_name_bold .'|'.$img->getURL() . "\n";
				//$out.="<li name=\"{$person_name}\"> $imgHTML $person_full_name</il>\n";
			} 			
		}
		//$out.='</ul>';
		//return people people in the Person Category
		return $out;
	}
	//return a json date obj 
	//@@todo fix for big sites...(will start to be no fun if number of streams > 2000 )
	function getJsonDateObj($obj_name='mv_result'){
		$dbr =& wfGetDB(DB_SLAVE);		
		$sql = 'SELECT `date_start_time` FROM `mv_streams` ' .
				'WHERE `date_start_time` IS NOT NULL ' .
				'ORDER BY `date_start_time` ASC  LIMIT 0, 2000';
		$res = $dbr->query($sql, 'MV_SpecialMediaSearch:getJsonDateObj');
		$start_day=time();
		$end_day=0;
		$delta=0;
		$sDays = array();
		while($row =  $dbr->fetchObject( $res )){			
			if($row->date_start_time==0)continue; //skip empty / zero values
			if($row->date_start_time < $start_day)$start_day=$row->date_start_time;
			if($row->date_start_time > $end_day)$end_day = $row->date_start_time;			
			list($month,$day, $year) = explode('/',date('m/d/Y',$row->date_start_time));
			$month = trim($month, '0');
			$day = trim($day, '0');
			if(!isset($sDays[$year]))$sDays[$year]=array();
			if(!isset($sDays[$year][$month]))$sDays[$year][$month]=array();	
			if(!isset($sDays[$year][$month][$day])){
				$sDays[$year][$month][$day]=1;	
			}else{
				$sDays[$year][$month][$day]++;	
			}			
		}
		return php2jsObj(array('sd'=>date('m/d/Y', $start_day),
							   'ed'=>date('m/d/Y',$end_day),
							   'sdays'=>$sDays), $obj_name);
	}
}
?>
