<?php
/*
 * MV_SpecialExport.php Created on Oct 23, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * exports Video feeds in a few different queries to machine readable formats
 * initially target: rss, miro  (format attribute)
 * atom etc would be good.  
 * 
 * 
 * Special:MvExport 
 */
if (!defined('MEDIAWIKI')) die();

global $IP, $smwgIP;
//export types:
function doExportStream($par = null){$MvSpecialExport = new MV_SpecialExport('stream',$par);}
function doExportCat($par = null){$MvSpecialExport = new MV_SpecialExport('category',$par);}
function doExportSeq($par = null){$MvSpecialExport = new MV_SpecialExport('sequence',$par);}
function doExportSearch($par = null){$MvSpecialExport = new MV_SpecialExport('search',$par);}
function doExportAsk($par =null){$MvSpecialExport = new MV_SpecialExport('ask',$par);}

SpecialPage::addPage( new SpecialPage('MvVideoFeed','',true,'doExportCat',false) );
SpecialPage::addPage( new SpecialPage('MvExportStream','',true,'doExportStream',false) );
SpecialPage::addPage( new SpecialPage('MvExportSequence','',true,'doExportSeq',false) );
SpecialPage::addPage( new SpecialPage('MvExportSearch','',true,'doExportSearch',false) );
SpecialPage::addPage( new SpecialPage('MvExportAsk','',true,'doExportAsk',false) );

//extend supported feed types:
$wgFeedClasses['cmml']='CmmlFeed';
$wgFeedClasses['podcast']='PodcastFeed';

class MV_SpecialExport {
	var $feed = null;
	function __construct($export_type, $par){
		$this->export_type=$export_type;	
		$this->par = $par;	
		$this->execute();
	}
	//@@todo think about integration into api.php	
	function execute() {
		global $wgRequest, $wgOut, $wgUser, $mvStream_name, $mvgIP;
		$html='';
		//set universal variables: 
		$this->feed_format = $wgRequest->getVal('feed_format');	
		$error_page = '';
		switch($this->export_type){
			case 'stream':
				$this->stream_name = $wgRequest->getVal('stream_name');				
				if($this->stream_name=='')$error_page.=wfMsg('edit_stream_missing').", ";
				$this->req_time = $wgRequest->getVal('t');		
				
				switch($this->feed_format ){
					case 'cmml':
						$this->get_stream_cmml();
					break;
					/* disabled for now
					 * case 'jroe':
						//returns roe stream info in json object for easy DOM injection
						$this->get_roe_json();
					break;*/
					case 'roe':
						$this->get_roe_xml();
					break;
				}				
			break;
			case 'category':
				$this->cat=$wgRequest->getVal('cat'); 	
				if($this->cat==''){
					$error_page.=wfMsg('mv_missing_cat');
				}else{
					$this->get_category_feed();
				}		
			break;
			case 'search':
				$this->get_search_feed();
			break;
			case 'sequence':			
				$this->seq_title = $this->par;				
				$this->get_sequence_xspf();
			break;			
			case 'ask':				
				$this->get_ask_feed();
			break;
		}
		if($error_page==''){
			$wgOut->disable();
		}else{
			$wgOut->addHTML($error_page);
		}	
	}    
	function get_sequence_xspf(){		
		//get the sequence article and export in xspf format: 		
		$seqTitle = Title::newFromText($this->seq_title, MV_NS_SEQUENCE);
		$seqArticle = new MV_SequencePage($seqTitle);	
		header('Content-Type: text/xml');
		$o='<?xml version="1.0" encoding="UTF-8"?>'."\n";
 		$o.='<playlist version="1" xmlns="http://xspf.org/ns/0/">'."\n";
 		$o.='	<title>'.$seqTitle->getText().'</title>'."\n";
 		$o.='	<info>'.$seqTitle->getFullURL().'</info>'."\n";
 		$o.='	<trackList>'."\n";
 		$seqArticle->parsePlaylist(); 	
 		foreach($seqArticle->clips as $clip){
	 		$o.='	<track>'."\n";
	 		$o.='		<title>'.htmlentities($clip['title']).'</title>'."\n";
	 		$o.='		<location>'.htmlentities($clip['src']).'</location>'."\n";
	 		$o.='		<info>'.htmlentities($clip['info']).'</info>'."\n";
	 		$o.='		<image>'.htmlentities($clip['image']).'</image>'."\n";
	 		$o.='		<annotation>'.htmlentities($clip['desc']).'</annotation>'."\n";	 		
	 		$o.='	</track>'."\n";
 		}
 		$o.='	</trackList>'."\n";
 		$o.='</playlist>';
 		print $o;
	}
	function get_row_data(){		
		//returns a high level description with cmml links (or inline-populated upon request)
		$this->mvTitle = new MV_Title($this->stream_name.'/'.$this->req_time);
		if(!$this->mvTitle->doesStreamExist()){
			//@@todo we should output the error in XML friendly manner
			die('stream does not exist');
		}
		$this->streamPageTitle = Title::newFromText($this->stream_name.'/'.$this->req_time, MV_NS_STREAM);
		//get the requested mvd set: 
		$this->mvcp = new MV_Component();
		$this->mvcp->procMVDReqSet($only_requested=true);
		
		//get all track types avaliable in current range: 
		$this->mvd_type_res = MV_Index::getMVDTypeInRange($this->mvTitle->getStreamId(),
				$this->mvTitle->getStartTimeSeconds(), 
				$this->mvTitle->getEndTimeSeconds());		
		
		//get all avaliable files
		$this->file_list =$this->mvTitle->mvStream->getFileList(); 		
	}
	/*function get_roe_json(){
		$fname = 'Mv_SpecialExport::get_roe_json';
		wfProfileIn( $fname );
		$this->get_row_data();		
		//sucks to do big XML page operations ... 
		//@@todo cache it..
		ob_start();
		$this->get_roe_xml(false);
		$xml_page = ob_get_clean();
		include_once('xml2json/xml2json.php');
		$jsonContents = xml2json::transformXmlStringToJson($xml_page);
		print $jsonContents;
		wfProfileOut($fname);
	}*/
	//start high level: 
	function get_roe_xml($header=true){
		global $mvDefaultVideoQualityKey, $wgServer;
		$dbr =& wfGetDB(DB_SLAVE);		
	
		$this->get_row_data();
		//get the stream stream req 
		if($header)
			header('Content-Type: text/xml');
		//print the header:
		print '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		/*
		 @@todo battle IE's XML parsing to make it compatible
		 (THIS xml schema info screw up parsing of the xml (in IE)) 		
		 <!DOCTYPE roe SYSTEM "http://svn.annodex.net/standards/roe/roe_1_0.xsd">		 
		<xs:schema targetNamespace="http://www.xiph.org/roe"
	    xmlns:xs="http://www.w3.org/2001/XMLSchema"
	    xmlns:cmml="http://www.annodex.org/cmml4.0"
	    xmlns:html="http://www.w3.org/1999/xhtml"
	    elementFormDefault="qualified"
	    attributeFormDefault="unqualified">


</xs:schema>
		 */
		?>			
<ROE>
	<head>
		<link id="html_linkback" rel="alternate" type="text/html" href="<?=htmlentities($this->streamPageTitle->getFullURL() )?>" />
		<img id="stream_thumb" src="<?=htmlentities($this->mvTitle->getFullStreamImageURL())?>"/>
		<title><?=htmlentities($this->mvTitle->getTitleDesc())?></title>
	</head>
	<body>
		<track id="v" provides="video">
			<switch distinction="quality">
		<? foreach($this->file_list as $file){ 				
				$dAttr=($file->getNameKey()==$mvDefaultVideoQualityKey)?' default="true"':'';
				$dSrc=($file->getPathType()=='url_anx')?$this->mvTitle->getWebStreamURL($file->getNameKey()):$file->getFullURL();
				//if not ogg include start and end times in the attribute: 
				//@@todo in the future support client side ogg seeking (and don't automaticly put .anx at the end)  
				$startendattr= (htmlentities($file->getContentType())!='video/ogg')?
					'start="ntp:'.htmlentities($this->mvTitle->getStartTime()).'"'. 
					' end="ntp:'.htmlentities($this->mvTitle->getEndTime()).'"':'';				
			?>
				<mediaSource id="<?=htmlentities($file->getNameKey())?>"<?=$dAttr?> src="<?=$dSrc?>" title="<?=htmlentities($file->get_desc())?>" content-type="<?=htmlentities($file->getContentType())?>" <?=$startendattr?>/>	
		<?}?>
	</switch>
		</track>
		<track id="t" provides="text layers">
			<switch distinction="layer">
<?				while($row = $dbr->fetchObject($this->mvd_type_res)){
					//output cmml header: 
					//@@todo lookup language for layer key patterns 
					$sTitle = Title::makeTitle(NS_SPECIAL, 'MvExportStream');
					$query = 'stream_name='.$this->stream_name.'&t='.$this->req_time.'&feed_format=cmml&tracks='.strtolower($row->mvd_type);		
					$clink = $sTitle->getFullURL($query);			
					$inline = (in_array(strtolower($row->mvd_type), $this->mvcp->mvd_tracks))?'true':'false';
					//for now make ht_en the default layer		
					$default_attr = (strtolower($row->mvd_type)=='ht_en')?'default="true"':'';												
?>
				<mediaSource id="<?=$row->mvd_type?>" title="<?=wfMsg($row->mvd_type)?>" <?=$default_attr?> inline="<?=$inline?>" lang="en" content-type="text/cmml" src="<?=htmlentities($clink)?>">
<?					//output inline cmml (if requested): 
					if($inline=='true'){
						$this->get_stream_cmml(true, $row->mvd_type);
					}	
?>
				</mediaSource>
<?			
				}	
			?>		
			</switch>
		</track>
	</body>
</ROE>
<?
		//get all available stream text layers ( inline request CMML (if apropo ))		
	}
	
	/*get stream CMML */
	function get_stream_cmml($inline=false, $force_track=null){		
		$dbr =& wfGetDB(DB_SLAVE);		
		//set cmml name space if inline: 
		$ns = ($inline)?'cmml:':'';
		$ns='';
		$encap=false;//if we should have a parent cmml tag
		if(!$force_track){
			//check the request to get trac set:
			$mvcp = new MV_Component();
			$mvcp->procMVDReqSet();
			$tracks = $mvcp->mvd_tracks;
			if(count($mvcp->mvd_tracks)>1)$encap=true;
		}else{
			$tracks = $force_track;
			$encap=false;
		}
		
		//get the stream title	
		$streamTitle = new MV_Title($this->stream_name.'/'.$this->req_time);		
		$wgTitle = Title::newFromText($this->stream_name.'/'.$this->req_time, MV_NS_STREAM);
		//do mvd_index query:
		$mvd_res = MV_Index::getMVDInRange($streamTitle->getStreamId(),
				$streamTitle->getStartTimeSeconds(), 
				$streamTitle->getEndTimeSeconds(), $tracks);
		//get the stream stream req 
		if(!$inline)header('Content-Type: text/xml');
		//print the header:
		if(!$inline)print '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n";		
		//if(!$inline)print '<!DOCTYPE cmml SYSTEM "http://svn.annodex.net/standards/cmml_2_0.dtd">'."\n";		
		$tracks=array();
		if(count($dbr->numRows($mvd_res))!=0){ 
			global $wgOut;
			$MV_Overlay = new MV_Overlay();				
			while($mvd = $dbr->fetchObject($mvd_res)){	
			
				if(!isset($tracks[$mvd->mvd_type]))$tracks[$mvd->mvd_type]='';			
				$tracks[$mvd->mvd_type].='						
						<'.$ns.'clip id="mvd_'.$mvd->id.'" start="ntp:'.seconds2ntp($mvd->start_time).'" end="ntp:'.seconds2ntp($mvd->end_time).'">
							<'.$ns.'img src="'.htmlentities($streamTitle->getFullStreamImageURL(null, seconds2ntp($mvd->start_time))).'"/>
							<'.$ns.'body><![CDATA[
									'.	$MV_Overlay->getMVDhtml($mvd, $absolute_links=true).'
								]]></'.$ns.'body> 
						</'.$ns.'clip>';			 					
				//clear wgOutput				
			}
		}		
		if($encap)print '<cmml_set>';
 	    //based on: http://trac.annodex.net/wiki/CmmlChanges
		foreach($tracks as $role=>$body_string){ ?>
					<cmml lang="en" id="<?=$role?>" role="<?=wfMsg($role)?>" xmlns="http://svn.annodex.net/standards/cmml_2_0.dtd">		
						<<?=$ns?>head>
							<<?=$ns?>title><?=wfMsg($role)?></<?=$ns?>title>	
							<<?=$ns?>description><?=htmlentities(wfMsg($role.'_desc'))?></<?=$ns?>description>				
						</<?=$ns?>head>
						<?=$body_string?>												
					</cmml>
<?
		}
		if($encap)print '</cmml_set>';
	}
	//this is dependent on semantic wiki ASK functionality
	function get_ask_feed(){
		global $wgSitename, $wgTitle;
		//check for semantic wiki: 
		if(!defined('SMW_VERSION')){
			return new WikiError( "Export Ask is dependent on semantic media wiki" );
		}			
		//bootstrap off of SMWAskPage: 				
		$SMWAskPage = new SMWAskPage();		
		$SMWAskPage->extractQueryParameters($this->par);
		
		//print 'query string: ' . $SMWAskPage->m_querystring . "\n<br>";
		//print 'm_params: ' . print_r($SMWAskPage->m_params) . "\n<br>";
		//print 'print outs: ' .print_r($SMWAskPage->m_printouts) . "\n<br>";
		//set up the feed: 
		$this->feed = new mvRSSFeed(
			$wgSitename . ' - ' .wfMsg('mediasearch'). ' : '. strip_tags($SMWAskPage->m_querystring), //title 
			strip_tags($SMWAskPage->m_querystring), //description
			$wgTitle->getFullUrl() //link 
		);		
		$this->feed->outHeader();
						
		$queryobj = SMWQueryProcessor::createQuery($SMWAskPage->m_querystring, $SMWAskPage->m_params, false, '', $SMWAskPage->m_printouts);
		$res = smwfGetStore()->getQueryResult($queryobj);
		$row = $res->getNext();
		while ( $row !== false ) {
			$wikititle = $row[0]->getNextObject();		
			$this->feed->outPutItem($wikititle->getTitle());
			$row = $res->getNext();
		}
		$this->feed->outFooter();
	}
	// @@todo integrate cache query (similar to SpecialRecentChanges::rcOutputFeed ))
	function get_category_feed(){
		global $wgSitename, $wgRequest, $wgOut, $wgCategoryPagingLimit;		
		//get the category article: 
		$title = Title::makeTitle( NS_CATEGORY,  $this->cat);		
		$article = new Article($title);
		
		$this->limit = $wgCategoryPagingLimit;	
		
		$this->feed = new mvRSSFeed(
			$wgSitename . ' - ' . wfMsgForContent( 'video_feed_cat' ) .$this->cat, //title 
			$article->getContent(), //description
			$title->getFullUrl() //link 
		);
		$this->feed->outHeader();
		
		$this->from = $wgRequest->getVal( 'from' );
		$this->until = $wgRequest->getVal( 'until' );
		
		//do a query (get all video items in this category) 
		if( $this->from != '' ) {
			$pageCondition = 'cl_sortkey >= ' . $dbr->addQuotes( $this->from );
			$this->flip = false;
		} elseif( $this->until != '' ) {
			$pageCondition = 'cl_sortkey < ' . $dbr->addQuotes( $this->until );
			$this->flip = true;
		} else {
			$pageCondition = '1 = 1';
			$this->flip = false;
		}
		$dbr = wfGetDB( DB_SLAVE );				
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_title', 'page_namespace', 'page_len', 'page_is_redirect', 'cl_sortkey' ),
			$pageCondition . " AND (
				  `page_namespace`  =  ".MV_NS_MVD." OR 
				  `page_namespace`  =  ".MV_NS_STREAM." OR 
				  `page_namespace`  = ".MV_NS_SEQUENCE." )
				   AND `cl_from`=  `page_id`
			       AND `cl_to` = '{$title->getDBkey()}'
			       AND `page_is_redirect`=0",
			#+ $pageCondition,
			__METHOD__,
			array( 'ORDER BY' => $this->flip ? 'cl_sortkey DESC' : 'cl_sortkey',
			       'USE INDEX' => 'cl_sortkey', 
			       'LIMIT'    => $this->limit + 1 ) );
		
		//echo 'last query: ' . $dbr->lastQuery();
		$count = 0;
		$this->nextPage = null;
		while( $x = $dbr->fetchObject ( $res ) ) {
			if( ++$count > $this->limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->nextPage = $x->cl_sortkey;
				break;
			}
			//@@link mvd namespace to stream:
			/*if($x->page_namespace == MV_NS_MVD){
				$mvTitle = new MV_Title($x->page_title);
				$title = Title::makeTitle( MV_NS_STREAM, $mvTitle->getStreamName().'/'.$mvTitle->getTimeRequest());
			}else{	
				
			}*/	
			$title = Title::makeTitle( $x->page_namespace, $x->page_title );		
			$this->feed->outPutItem($title);
		}				
		$this->feed->outFooter();
		//$this->rows =  
	}
	function get_search_feed(){	
		global $wgSitename, $wgOut;	
		//set up search obj: 
		$sms = new MV_SpecialMediaSearch();
		//setup filters:
		$sms->setUpFilters();
		//do the search:
		$sms->doSearch();
		//get the search page title:
		$msTitle = Title::MakeTitle(NS_SPECIAL, 'MediaSearch');
		
		$this->feed = new mvRSSFeed(
			$wgSitename . ' - ' .wfMsg('mediasearch'). ' : '. strip_tags($sms->getFilterDesc()), //title 
			strip_tags($sms->getFilterDesc()), //description
			$msTitle->getFullUrl().'?'.$sms->get_httpd_filters_query() //link 
		);
		$this->feed->outHeader();	
		$MV_Overlay = new MV_Overlay();				
		//for each search result: 		
		foreach ($sms->results as $stream_id => & $stream_set) {			
			$matches = 0;
			$stream_out = $mvTitle = '';			
			foreach ($stream_set as & $srange) {				
				$cat_html = $mvd_out = '';
				$range_match=0;						
				foreach ($srange['rows'] as $inx=> & $mvd) {								
					$matches++;			
					//get Stream title for mvd match: 
					$mvTitle = new MV_Title($mvd->wiki_title);
					$stremTitle = Title::MakeTitle(MV_NS_STREAM, $mvTitle->getStreamName().'/'.$mvTitle->getTimeRequest() );
					$this->feed->outPutItem($stremTitle, $MV_Overlay->getMVDhtml($mvd, $absolute_links=true));
				}
			}
		}
		$this->feed->outFooter();		
	}      
}
class mvRSSFeed extends ChannelFeed{
	function outHeader() {
		$this->outXmlHeader();
		?>
<rss version="2.0"
	xmlns:creativeCommons="http://backend.userland.com/creativeCommonsRssModule"
	xmlns:media="http://search.yahoo.com/mrss/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
	xmlns:blip="http://blip.tv/dtd/blip/1.0"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:amp="http://www.adobe.com/amp/1.0"
	xmlns:dcterms="http://purl.org/dc/terms"
	xmlns:gm="http://www.google.com/schemas/gm/1.1">
	<channel>
	<title><?=$this->getTitle()?></title>
	<link><?=$this->getUrl()?></link>
	<description><?=$this->getDescription()?></description>	
	<?
	}
	function outPutItem($wikiTitle, $desc_html=''){
		global $wgOut;		
		$mvTitle = new MV_Title($wikiTitle);
		$mStreamTitle = Title::makeTitle(MV_NS_STREAM, ucfirst($mvTitle->getStreamName()) . '/'.$mvTitle->getTimeRequest());
		
		//only output media RSS item if its valid media: 
		if(!$mvTitle->doesStreamExist())return ;

		//@@todo this should be cached 	
		$thumb_ref = $mvTitle->getStreamImageURL('320x240');
		if($desc_html==''){			
			$article = new Article($wikiTitle);
			$wgOut->clearHTML(); 			
			$wgOut->addWikiText($article->getContent() );
			$desc_html = $wgOut->getHTML();		
			$wgOut->clearHTML();					
		}
		$desc_xml ='<![CDATA[				
			<center class="mv_rss_view_only">
				<a href="'.$mStreamTitle->getFullUrl().'"><img src="'.$thumb_ref.'" border="0" /></a>
			</center>
			<br />'.
			$desc_html. 
			']]>';
				
		$stream_url = $mvTitle->getWebStreamURL();			
		$talkpage = $wikiTitle->getTalkPage();			
					
		$type_desc = ($mvTitle->getMvdTypeKey())?wfMsg($mvTitle->getMvdTypeKey()):'';			
		$time_desc = ($mvTitle->getTimeDesc())?$mvTitle->getTimeDesc():'';					
		?>	
		<item>
		<link><?=mvRSSFeed::xmlEncode($mStreamTitle->getFullUrl())?></link>
		<title><?=mvRSSFeed::xmlEncode(
			$mvTitle->getStreamNameText() . ' ' .  $time_desc)?></title>
		<description><?=$desc_xml?></description>
		<enclosure type="video/ogg" url="<?=mvRSSFeed::xmlEncode($stream_url)?>"/>
		<comments><?=mvRSSFeed::xmlEncode($talkpage->getFullUrl())?></comments>
		<media:thumbnail url="<?=mvRSSFeed::xmlEncode($thumb_ref)?>"/>
		<? /*todo add in alternate streams HQ, lowQ archive.org etc: 
		<media:group>
    		<media:content blip:role="Source" expression="full" fileSize="2702848" height="240" isDefault="true" type="video/msvideo" url="http://blip.tv/file/get/Conceptdude-EroticDanceOfANiceBabe266.avi" width="360"></media:content>
    		<media:content blip:role="web" expression="full" fileSize="3080396" height="240" isDefault="false" type="video/x-flv" url="http://blip.tv/file/get/Conceptdude-EroticDanceOfANiceBabe266.flv" width="360"></media:content>
  		</media:group>
  		*/ ?> 
		</item>
		<?
	}
	function outFooter(){
		?>
		</channel>
</rss>
		<?
	}
}
?>
