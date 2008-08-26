<?php
/*
 * MV_CategoryPage.php Created on Oct 17, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 //$wgHooks['CategoryPageView'][] = 'fnMyHook';
 //display all MVD category members as thumbnails... 
 //display link to rss/playlist
class MV_CategoryPage extends CategoryPage{	
 	function closeShowCategory() {
		global $wgOut, $wgRequest;
		$from = $wgRequest->getVal( 'from' );
		$until = $wgRequest->getVal( 'until' );		
		$viewer = new MvCategoryViewer( $this->mTitle, $from, $until );
		$wgOut->addHTML( $viewer->getHTML() );
	}
}
class MvCategoryViewer extends CategoryViewer {
	var $show_mv_links=false;
	private $already_named_resource = array();
			
	function getHTML(){
		$s='';
		return $s .parent::getHTML(); 
	}
	function doCategoryQuery() {
		$dbr = wfGetDB( DB_SLAVE );
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
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_title', 'page_namespace', 'page_len', 'page_is_redirect', 'cl_sortkey' ),
			array( $pageCondition,
			       'cl_from          =  page_id',
			       'cl_to'           => $this->title->getDBkey()),
			       #'page_is_redirect' => 0),
			#+ $pageCondition,
			__METHOD__,
			array( 'ORDER BY' => $this->flip ? 'cl_sortkey DESC' : 'cl_sortkey',
			       'USE INDEX' => 'cl_sortkey', 
			       'LIMIT'    => $this->limit + 1 ) );

		$count = 0;
		$this->nextPage = null;
		while( $x = $dbr->fetchObject ( $res ) ) {
			if( ++$count > $this->limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->nextPage = $x->cl_sortkey;
				break;
			}

			$title = Title::makeTitle( $x->page_namespace, $x->page_title );

			if( $title->getNamespace() == NS_CATEGORY ) {
				$this->addSubcategory( $title, $x->cl_sortkey, $x->page_len );
			} elseif( $this->showGallery && $title->getNamespace() == NS_IMAGE ) {
				$this->addImage( $title, $x->cl_sortkey, $x->page_len, $x->page_is_redirect );
			} elseif( $title->getNamespace() == MV_NS_MVD ||
				 $title->getNamespace() ==  MV_NS_STREAM ||
				 $title->getNamespace() ==  MV_NS_SEQUENCE ){				 	
				$this->show_mv_links=true;				
				
				//make sure we don't do duplicate stream links:
				$mvTitle = new MV_Title($title);
				if(!isset($this->already_named_resource[$mvTitle->getStreamName().'/'.$mvTitle->getTimeRequest()])){
					$this->already_named_resource[$mvTitle->getStreamName().'/'.$mvTitle->getTimeRequest()]=true;	
					$this->addMVThumb($title,  $x->cl_sortkey, $x->page_len, $x->page_is_redirect);				
				}	 					 				
			} else {
				$this->addPage( $title, $x->cl_sortkey, $x->page_len, $x->page_is_redirect );
			}
		}
		$dbr->freeResult( $res );
	}
	function clearCategoryState() {
		$this->articles = array();
		$this->articles_start_char = array();
		$this->children = array();
		$this->children_start_char = array();
		if( $this->showGallery ) {			
			$this->gallery = new MV_ImageGallery();
			$this->gallery->setHideBadImages();
		}
	}
	function addMVThumb(Title $title, $sortkey, $pageLength, $isRedirect = false ){	
		if ( $this->showGallery ) {			
			$image = new MV_Image( $title );
			if( $this->flip ) {
				$this->gallery->insert( $image );
			} else {
				$this->gallery->add( $image );
			}
		}else{
			$this->addPage( $title, $sortkey, $pageLength, $isRedirect );
		}
	}
	function getImageSection() {
		global $wgUser, $wgTitle;
		$sk = $wgUser->getSkin();
		$s = ($this->show_mv_links)?$this->getRssLinks():'';
		if( $this->showGallery && ! $this->gallery->isEmpty() ) {
			$title = Title::MakeTitle(NS_SPECIAL, 'MediaSearch');			
			$query = 'f[0][t]='.urlencode('category').'&f[0][v]='.$wgTitle->getDBkey();
			$search_link = $sk->makeKnownLinkObj($title,wfMsg('mv_search_category').":".$wgTitle->getText(), $query);			
			
			return "<div id=\"mw-category-media\">\n" .
			$s . 
			'<h2>' . wfMsg( 'category-media-header', htmlspecialchars($this->title->getText()) ) . "</h2>\n" .
			wfMsgExt( 'category-media-count', array( 'parse' ), $this->gallery->count() ) .
			wfMsg('mv_cat_search_note', $search_link) . 			
			$this->gallery->toHTML() . "\n</div>";
		} else {
			return '';
		}
	}
	function getRssLinks(){
		global $wgUser, $mvgScriptPath;
		$sk = $wgUser->getSkin();
		$query = 'feed_format=rss&cat='. $this->title->getDBkey();
		$nt = Title::makeTitle(NS_SPECIAL, 'MvVideoFeed');
		$img = '<img border="0" width="28" height="28" src="'.$mvgScriptPath . '/skins/images/feed-icon-28x28.png">';
		return '<span style="float:right;">' . 
				$sk->makeKnownLinkObj($nt, $img, $query, '', '' ,  '',' title="'.wfMsg('video_feed_cat').' '.$this->title->getText(). '" ').
				'</span>';
	}
}

?>
