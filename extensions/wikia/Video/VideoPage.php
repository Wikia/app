<?php
class VideoPage extends Article{

	var $title = null;

	function __construct (&$title){
		parent::__construct(&$title);
	}

	function view(){
		global $wgOut, $wgUser, $wgRequest;
		
		$this->video = new Video( $this->getTitle() );
		
		$sk = $wgUser->getSkin();
	
		
		# No need to display noarticletext, we use our own message
		if ( $this->getID() ) {
			parent::view();
		} else {
			# Just need to set the right headers
			$wgOut->setArticleFlag( true );
			$wgOut->setRobotpolicy( 'index,follow' );
			$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );
			
		
		}
		
		if($this->video->exists()){
			//display Flash Video
			$wgOut->addHTML( $this->video->getEmbedCode() );
			
			//force embed this code to have width of 300
			$this->video->setWidth(300); 
			$wgOut->addHTML( $this->getEmbedThisTag() );
			
			$this->videoHistory();
		
		}else{
			//Video Doesn't exist, so give link allowing user to add one with this name
			$title = SpecialPage::getTitleFor( 'AddVideo' );
			$link = $sk->makeKnownLinkObj($title, wfMsgHtml('novideo-linktext'),
				'wpDestName=' . urlencode( $this->video->getName() ) );
			$wgOut->addHTML( wfMsgWikiHtml( 'novideo', $link ) );
		}
		
		
	}
	
	
	function getContent() {
		/*
		if( $this->img && $this->img->fromSharedDirectory && 0 == $this->getID() ) {
			return '';
		}
		*/
		return Article::getContent();
	}
	
	public function getEmbedThisTag(){
		$code = $this->video->getEmbedThisCode();
		$code = preg_replace('/[\n\r\t]/','',$code); // replace any non-space whitespace with a space
		//$code = addslashes($code)
		;
		return "<br/><br/><table cellpadding=\"0\" cellspacing=\"2\" border=\"0\"><tr><td><b>" . wfMsgForContent( 'video_embed') . "</b> </td><td><form name=\"embed_video\"><input name='embed_code' style='width:300px;font-size:10px;' type='text' value='{$code}'  onClick='javascript:document.embed_video.embed_code.focus();document.embed_video.embed_code.select();' readonly='true'></form></td></tr></table>";
	}
	
	/**
	 * If the page we've just displayed is in the "Video" namespace,
	 * we follow it with an upload history of the video and its usage.
	 */
	function videoHistory(){
		global $wgUser, $wgOut;

		$sk = $wgUser->getSkin();

		$line = $this->video->nextHistoryLine();

		if ( $line ) {
			$list = new VideoHistoryList( $sk );
			$s = $list->beginVideoHistoryList() .
				$list->videoHistoryLine( true, wfTimestamp(TS_MW, $line->video_timestamp),
					$this->mTitle->getDBkey(),  $line->video_user_id,
					$line->video_user_name, strip_tags($line->video_url), $line->video_type
				);

			while ( $line = $this->video->nextHistoryLine() ) {
				$s .= $list->videoHistoryLine( false, $line->video_timestamp,
			  		$line->ov_archive_name, $line->video_user_id,
			  		$line->video_user_name, strip_tags($line->video_url), $line->video_type
				);
			}
			$s .= $list->endVideoHistoryList();
		} else { $s=''; }
		$wgOut->addHTML( $s );

		# Exist check because we don't want to show this on pages where an video
		# doesn't exist along with the novideo message, that would suck. -ævar
		if( $this->video->exists() ) {
			$this->uploadLinksBox();
		}

	}
	
	function getAddVideoUrl() {
		global $wgServer;
		$addVideoTitle = SpecialPage::getTitleFor( 'AddVideo' );
		return $wgServer . $addVideoTitle->getLocalUrl( 'wpDestName=' . urlencode( $this->video->getName() ) );
	}
	
	/**
	 * Print out the various links at the bottom of the video page, e.g. reupload,
	 * external editing (and instructions link) etc.
	 */
	function uploadLinksBox() {
		global $wgUser, $wgOut;

		$sk = $wgUser->getSkin();
		
		$wgOut->addHtml( '<br /><ul>' );
		
		# "Upload a new version of this video" link
		if( $wgUser->isAllowed( 'reupload' ) ) {
			$ulink = $sk->makeExternalLink( $this->getAddVideoUrl(), wfMsg( 'uploadnewversion-linktext' ) );
			$wgOut->addHtml( "<li><div class='plainlinks'>{$ulink}</div></li>" );
		}
	 
		$wgOut->addHtml( '</ul>' );
	}
	
	function revert() {
		global $wgOut, $wgRequest, $wgUser;

		$oldvideo = $wgRequest->getText( 'oldvideo' );
		if ( strlen( $oldvideo ) < 16 ) {
			$wgOut->showUnexpectedValueError( 'oldimage', htmlspecialchars($oldvideo) );
			return;
		}
	
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( $wgUser->isAnon() ) {
			$wgOut->showErrorPage( 'uploadnologin', 'uploadnologintext' );
			return;
		}
		if ( ! $this->mTitle->userCan( 'edit' ) ) {
			$wgOut->readOnlyPage( $this->getContent(), true );
			return;
		}
		if ( $wgUser->isBlocked() ) {
			return $this->blockedIPpage();
		}
		if( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ), $oldvideo ) ) {
			$wgOut->showErrorPage( 'internalerror', 'sessionfailure' );
			return;
		}
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`oldvideo`', array( 'ov_url','ov_type'), array( 'ov_archive_name' => urldecode($oldvideo) ), $fname );
		if ( $s !== false ) {
			$url = $s->ov_url;
			$type = $s->ov_type;
		}else{
			$wgOut->showUnexpectedValueError( 'oldimage', htmlspecialchars($oldvideo) );
			return;
		}
		
		$name = substr( $oldvideo, 15 );

		$oldver = wfTimestampNow() . "!{$name}";

		# Record upload and update metadata cache
		$video = Video::newFromName( $name );
		$video->addVideo( $url, $type, $categories );

		$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->addHTML( wfMsg( 'video_revert_success' ) );

		$descTitle = $video->getTitle();
		$wgOut->returnToMain( false, $descTitle->getPrefixedText() );
	}
	
	 

	
}

/**
 * @todo document
 */
class VideoHistoryList {
	function VideoHistoryList( &$skin ) {
		$this->skin =& $skin;
	}

	function beginVideoHistoryList() {
		$s = "\n" .
			Xml::element( 'h2', array( 'id' => 'filehistory' ), wfMsg( 'video_history' ) ) .
			"\n<p>" . wfMsg( 'video_histlegend' ) . "</p>\n".'<ul class="special">';
		return $s;
	}

	function endVideoHistoryList() {
		$s = "</ul>\n";
		return $s;
	}

	function videoHistoryLine( $iscur, $timestamp, $video, $user_id, $user_name, $url, $type  ) {
		global $wgUser, $wgLang, $wgTitle, $wgContLang;

		$datetime = $wgLang->timeanddate( $timestamp, true );
		$cur = wfMsgHtml( 'cur' );

		if ( $iscur ) {
			$rlink = $cur;
		} else {
			if( $wgUser->getID() != 0 && $wgTitle->userCan( 'edit' ) ) {
				$token = urlencode( $wgUser->editToken( $video ) );
				$rlink = $this->skin->makeKnownLinkObj( $wgTitle,
				           wfMsgHtml( 'video_revert' ), 'action=revert&oldvideo=' .
				           urlencode( $video ) . "&wpEditToken=$token" );
				
			} else {
				# Having live active links for non-logged in users
				# means that bots and spiders crawling our site can
				# inadvertently change content. Baaaad idea.
				$rlink = wfMsgHtml( 'video_revert' );
				$dlink = $del;
			}
		}
		
		$userlink = $this->skin->userLink( $user_id, $user_name ) . $this->skin->userToolLinks( $user_id, $user_name );
 
		 
		$style = $this->skin->getInternalLinkAttributes( $url, $datetime );

		$s = "<li>({$rlink}) <a href=\"{$url}\"{$style}>{$datetime}</a> . . ({$type}) . . {$userlink}";

		$s .= $this->skin->commentBlock( $description, $wgTitle );
		$s .= "</li>\n";
		return $s;
	}

}

class CategoryWithVideoViewer extends CategoryViewer{
	

	
	function clearCategoryState() {
		$this->articles = array();
		$this->articles_start_char = array();
		$this->children = array();
		$this->children_start_char = array();
		if( $this->showGallery ) {
			$this->gallery = new ImageGallery();
		}
		#if( $this->showVideoGallery ) {
			$this->videogallery = new VideoGallery();
			$this->videogallery->setParsing();
		#}
	}
	
	/**
	 * Format the category data list.
	 *
	 * @param string $from -- return only sort keys from this item on
	 * @param string $until -- don't return keys after this point.
	 * @return string HTML output
	 * @private
	 */
	function getHTML() {
		global $wgOut, $wgCategoryMagicGallery, $wgCategoryPagingLimit;
		wfProfileIn( __METHOD__ );

		$this->showGallery = $wgCategoryMagicGallery && !$wgOut->mNoGallery;

		$this->clearCategoryState();
		$this->doCategoryQuery();
		$this->finaliseCategoryState();

		$r = $this->getCategoryTop() .
			$this->getSubcategorySection() .
			$this->getPagesSection() .
			$this->getImageSection() .
			$this->getVideoSection() .
			$this->getCategoryBottom();

		wfProfileOut( __METHOD__ );
		return $r;
	}
	
	function getVideoSection() {
		if(  ! $this->videogallery->isEmpty() ) {
			return "<div id=\"mw-category-media\">\n" .
			'<h2>' . wfMsg( 'category-video-header', htmlspecialchars($this->title->getText()) ) . "</h2>\n" .
			wfMsgExt( 'category-video-count', array( 'parse' ), $this->videogallery->count() ) .
			$this->videogallery->toHTML() . "\n</div>";
		} else {
			return '';
		}
	}
	
	/**
	 * Add a page in the image namespace
	 */
	function addVideo( $title, $sortkey, $pageLength ) {
		$video = new Video( $title );
		if( $this->flip ) {
			$this->videogallery->insert( $video );
		} else {
			$this->videogallery->add( $video );
		}
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
			array( 'page_title', 'page_namespace', 'page_len', 'cl_sortkey' ),
			array( $pageCondition,
			       'cl_from          =  page_id',
			       'cl_to'           => $this->title->getDBKey()),
			       #'page_is_redirect' => 0),
			#+ $pageCondition,
			__METHOD__,
			array( 'ORDER BY' => $this->flip ? 'cl_sortkey DESC' : 'cl_sortkey',
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
			} elseif( $title->getNamespace() == NS_IMAGE ) {
				$this->addImage( $title, $x->cl_sortkey, $x->page_len );
			}  elseif( $title->getNamespace() == NS_VIDEO ) {
				$this->addVideo( $title, $x->cl_sortkey, $x->page_len );
			} else {
				$this->addPage( $title, $x->cl_sortkey, $x->page_len );
			}
		}
		$dbr->freeResult( $res );
	}
}
?>