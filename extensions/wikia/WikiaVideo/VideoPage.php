<?php
global $wgExtensionMessagesFiles;
$wgExtensionMessagesFiles['WikiaVideo'] = dirname(__FILE__).'/WikiaVideo.i18n.php';

class VideoPage extends Article {

	const V_GAMEVIDEOS = 1;
	const V_GAMESPOT = 2;
	const V_MTVGAMES = 3;
	const V_5MIN = 4;
	const V_YOUTUBE = 5;
	const V_HULU = 6;
	const V_VEOH = 7;
	const V_FANCAST = 8;
	const V_IN2TV = 9;
	const V_BLIPTV = 10;
	const V_METACAFE = 11;
	const V_SEVENLOAD = 12;
	const V_VIMEO = 13;
	const V_CLIPFISH = 14;
	const V_MYVIDEO = 15;
	const V_SOUTHPARKSTUDIOS = 16;
	const V_DAILYMOTION = 18;
	const V_VIDDLER	 = 19;
	const K_VIDDLER = "hacouneo6n6o3nysn0em";
	const V_GAMETRAILERS = 20;
	const V_SCREENPLAY = 21;
	const V_MOVIECLIPS = 22;
	const V_REALGRAVITY = 23;
	const V_WIKIAVIDEO = 24;
	const V_LOCALVIDEO = 25;
	
	const YOUTUBE_FEEDS_VIDEOS_URL = 'http://gdata.youtube.com/feeds/videos';
	const XMLNS_YT = 'http://gdata.youtube.com/schemas/2007';

	const SCREENPLAY_MEDIUM_JPEG_BITRATE_ID = 267;	// 250x200
	const SCREENPLAY_LARGE_JPEG_BITRATE_ID = 382;	// 480x360
	const SCREENPLAY_HIGHDEF_BITRATE_ID = 449;	// 720p
	const SCREENPLAY_STANDARD_43_BITRATE_ID = 455;	// 360, 4:3
	const SCREENPLAY_STANDARD_BITRATE_ID = 461;	// 360, 16:9
	const SCREENPLAY_ENCODEFORMATCODE_JPEG = 9;
	const SCREENPLAY_ENCODEFORMATCODE_MP4 = 20;
	
	const REALGRAVITY_PLAYER_AUTOSTART_ID = 'ac330d90-cb46-012e-f91c-12313d18e962';
	const REALGRAVITY_PLAYER_NO_AUTOSTART_ID = '63541030-a4fd-012e-7c44-1231391272da';
	const REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID = '49321a60-d897-012e-f9bf-12313d18e962';

	const VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID = 'UA-24709745-1';
	
	const DEFAULT_OASIS_VIDEO_WIDTH = 660;
	const DEFAULT_VET_WIDTH = 350;	// defined in VideoEmbedTool_setup.php, but that extension may not be enabled!

	const MAX_TITLE_LENGTH = 240;

	private static $SCREENPLAY_VENDOR_ID = 1893;
	private static $SCREENPLAY_VIDEO_TYPE = '.mp4';
	private static $JWPLAYER_DIR = '/extensions/wikia/JWPlayer/';
	private static $JWPLAYER_JS = 'jwplayer.min.js';
	private static $JWPLAYER_SWF = 'player.swf';
	private static $JWPLAYER_PLUGIN_HD_JS = 'hd-2.1.min.js';
	private static $JWPLAYER_PLUGIN_HD_SWF = 'hd-2.1.swf';
	private static $JWPLAYER_JS_PLUGINS_DIR = 'plugins/js/';
	
	// ad.tag must be initialized somewhere in this class!
	private static $JWPLAYER_GOOGIMA_DATA = 
		array('ad.tag'=>'', 'ad.position'=>'pre', 'ad.bandwidth'=>'high',
			'admessagedynamic'=>'Your video will play in XX seconds', 'admessagedynamickey'=>'XX',
			//'allowadskip'=>'true', 'allowadskippastseconds'=>5,	// wlee 11/1/11: do not skip ads yet
			'scaled_ads'=>'false'
			);

	var	$mName,
		$mVideoName,
		$mId,
		$mProvider,
		$mData,
		$mDataline;

	function __construct(Title $title){
		parent::__construct($title);
	}

	// used when displaying the video page, wrapper for view
	function render() {
		global $wgOut, $wgRequest;
		$wgOut->setArticleBodyOnly(true);
		// this article has no content. simulate a Video tag
		// width, align and caption may be specified as params. let's
		// overload the article title to have a quasi-query string
		$params = array();

		$vars = $wgRequest->getValues();
		if (sizeof($vars)) {
			if (!empty($vars['thumb']) && $vars['thumb']) {
				$params[] = 'thumb';
			}
			if (!empty($vars['width'])) {
				$params[] = $vars['width'];
			}
			if (!empty($vars['align'])) {
				$params[] = $vars['align'];
			}
			if (!empty($vars['caption'])) {
				$params[] = $vars['caption'];
			}
		}

		$paramsStr = '';
		if (sizeof($params)) {
			$paramsStr = '|' . implode('|', $params);
		}

		$this->mContent = '[[' . $this->getTitle()->getFullText() . $paramsStr .']]';
		$this->mContentLoaded = true;

		parent::view();
	}

	function delete() {
		// content moved to doDelete
		parent::delete();
	}

	// wrapper for deletion - two modes, total (deletes article plus all history) or one chosen old history (file) revision
	public function doDelete( $reason, $suppress = false ) {
		global $wgOut, $wgUser, $wgRequest, $wgLang;

		$wgRequest->getVal( 'wpOldVideo' ) ? $oldvideo = $wgRequest->getVal( 'wpOldVideo' ) : $oldvideo = false ;

		if( !$oldvideo ) {
			// move the history to filearchive
			$this->doDBInserts();
			// and clean it up
			$this->doDBDeletes();
			// delete the article itself
			parent::doDelete( $reason, $suppress );

			// clean up cache for all articles that linked to this one
			$title = $this->mTitle;
			if ( $title ) {
				$update = new VideoHTMLCacheUpdate( $title, 'imagelinks' );
				$update->doUpdate();
			}
		} else {
			// delete just this one "file" revision, the article remains intact
			$this->doDBInserts( $oldvideo );
			$this->doDBDeletes( $oldvideo );

			// supply info about what we have done
			$this->load();
			$data = array(
					$this->mProvider,
					$this->mId,
					$this->mData[0]
				     );
			$data = implode( ",", $data ) ;
			$url = self::getUrl( $data );

			$wgOut->addHTML( wfMsgExt(
						"wikiavideo-deleted-old",
						'parse',
						$url,
						$this->mTitle->getText(),
						$wgLang->date( $oldvideo, true ),
						$wgLang->time( $oldvideo, true )
						) );

			$log = new LogPage( 'delete' );
			$logComment = wfMsgForContent( 'deletedrevision', $oldvideo );
			if( trim( $reason ) != '' )
				$logComment .= ": {$reason}";
			$log->addEntry( 'delete', $this->mTitle, $logComment );

			$this->doPurge();
			$wgOut->addReturnTo( $this->mTitle );
		}
	}

	// custom deletion confirmation form
	public function confirmDelete( $reason ) {
		global $wgOut, $wgUser, $wgRequest, $wgLang;

		wfDebug( "VideoPage::confirmDelete\n" );

		$wgRequest->getVal( 'oldvideo' ) ? $oldvideo = $wgRequest->getVal( 'oldvideo' ) : $oldvideo = '';

		$wgOut->setSubtitle( wfMsgHtml( 'delete-backlink', $wgUser->getSkin()->makeKnownLinkObj( $this->mTitle ) ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		if( '' == $oldvideo ) {
			$wgOut->addWikiMsg( 'confirmdeletetext' );
		} else {
			// supply info about what we have done
			$this->load();
			$data = array(
					$this->mProvider,
					$this->mId,
					$this->mData[0]
				     );
			$data = implode( ",", $data ) ;
			$url = self::getUrl( $data );

			$wgOut->addHTML( wfMsgExt(
                                "wikiavideo-intro-old",
                                'parse',
                                $url,
                                $wgLang->date( $oldvideo, true ),
                                $wgLang->time( $oldvideo, true ),
				self::getOldUrl( $this->mTitle, $oldvideo ),
				$this->mTitle->getText()
                                ) );
		}

		if( $wgUser->isAllowed( 'suppressrevision' ) ) {
			$suppress = "<tr id=\"wpDeleteSuppressRow\" name=\"wpDeleteSuppressRow\">
				<td></td>
				<td class='mw-input'>" .
				Xml::checkLabel( wfMsg( 'revdelete-suppress' ),
						'wpSuppress', 'wpSuppress', false, array( 'tabindex' => '4' ) ) .
				"</td>
				</tr>";
		} else {
			$suppress = '';
		}
		$checkWatch = $wgUser->getBoolOption( 'watchdeletion' ) || $this->mTitle->userIsWatching();

		$form = Xml::openElement( 'form', array( 'method' => 'post',
					'action' => $this->mTitle->getLocalURL( 'action=delete' ), 'id' => 'deleteconfirm' ) ) .
			Xml::openElement( 'fieldset', array( 'id' => 'mw-delete-table' ) ) .
			Xml::tags( 'legend', null, wfMsgExt( 'delete-legend', array( 'parsemag', 'escapenoentities' ) ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-deleteconfirm-table' ) ) .
			"<tr id=\"wpDeleteReasonListRow\">
			<td class='mw-label'>" .
			Xml::label( wfMsg( 'deletecomment' ), 'wpDeleteReasonList' ) .
			"</td>
			<td class='mw-input'>" .
			Xml::listDropDown( 'wpDeleteReasonList',
					wfMsgForContent( 'deletereason-dropdown' ),
					wfMsgForContent( 'deletereasonotherlist' ), '', 'wpReasonDropDown', 1 ) .
			"</td>
			</tr>
			<tr id=\"wpDeleteReasonRow\">
			<td class='mw-label'>" .
			Xml::label( wfMsg( 'deleteotherreason' ), 'wpReason' ) .
			"</td>
			<td class='mw-input'>" .
			Xml::input( 'wpReason', 60, $reason, array( 'type' => 'text', 'maxlength' => '255',
						'tabindex' => '2', 'id' => 'wpReason' ) ) .
			"</td>
			</tr>
			<tr>
			<td></td>
			<td class='mw-input'>" .
			Xml::checkLabel( wfMsg( 'watchthis' ),
					'wpWatch', 'wpWatch', $checkWatch, array( 'tabindex' => '3' ) ) .
			"</td>
			</tr>
			$suppress
			<tr>
			<td></td>
			<td class='mw-submit'>" .
			Xml::submitButton( wfMsg( 'deletepage' ),
					array( 'name' => 'wpConfirmB', 'id' => 'wpConfirmB', 'tabindex' => '5' ) ) .
			"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::hidden( 'wpOldVideo', $oldvideo ) .
			Xml::closeElement( 'form' );

		if( $wgUser->isAllowed( 'editinterface' ) ) {
			$skin = $wgUser->getSkin();
			$link = $skin->makeLink ( 'MediaWiki:Deletereason-dropdown', wfMsgHtml( 'delete-edit-reasonlist' ) );
			$form .= '<p class="mw-delete-editreasons">' . $link . '</p>';
		}

		$wgOut->addHTML( $form );
		LogEventsList::showLogExtract( $wgOut, 'delete', $this->mTitle->getPrefixedText() );
	}

	// handles main video page viewing - two modes, for existing page and for non-existing (not created, deleted...)
	function view() {
		global $wgOut, $wgUser, $wgRequest;

		if($this->getID()) { // existing video

			$wgOut->addHTML($this->showTOC(''));
			$this->openShowVideo();
			$this->showVideoInfoLine();

			wfRunHooks('WikiaVideo::View:BlueLink');

			Article::view();

			$this->videoHistory();
			$wgOut->addHTML('<br/>');
			$wgOut->addHTML(Xml::element('h2', array('id' => 'filelinks'), wfMsg('wikiavideo-links'))."\n");
			$this->videoLinks();

		} else { // not existing video

			# Just need to set the right headers
			$wgOut->setArticleFlag(true);
			$wgOut->setRobotpolicy('noindex,nofollow');
			$wgOut->setPageTitle($this->mTitle->getPrefixedText());

			wfRunHooks('WikiaVideo::View:RedLink');

			$wgOut->addHTML('<br/>');
			$wgOut->addHTML(Xml::element('h2', array('id' => 'filelinks'), wfMsg('wikiavideo-links'))."\n");
			$this->videoLinks();
			$this->viewUpdates();
		}
	}

	// when we have a non-existing article (deleted) and upload a new video, perform cleanup for earlier image and oldimage versions
	// if necessary
	function doCleanup () {
		global $wgUser;
		$fname = get_class( $this ) . '::' . __FUNCTION__;

		$dbr = wfGetDB( DB_SLAVE );
		// if we had at least one revision in image, that means we have to do this
		// remember, this was deleted
		$row = $dbr->selectRow(
			'image',
			'img_name',
			array(
				'img_name = ' . $dbr->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR img_name = ' . $dbr->addQuotes( $this->mTitle->getPrefixedText() ),
			),
			$fname
		);

		if(!$row) {
			return; // no need to run
		}

		// move anything from image and oldimage into filearchive, because it wasn't moved before
		$this->doDBInserts();
		$this->doDBDeletes();
	}

	// take all given video's records from image and oldimage and put into filearchive or just one single old revision
	// performs old format correction along the way
	function doDBInserts( $oldvideo = false ) {
		global $wgUser;

		$dbw = wfGetDB( DB_MASTER );
		$encTimestamp = $dbw->addQuotes( $dbw->timestamp() );
		$encUserId = $dbw->addQuotes( $wgUser->getId() );
		$encReason = $dbw->addQuotes( $this->reason );
		$encGroup = 'deleted';

		// cater for older format, gather first, insert then

		if( !$oldvideo ) {

			$conditions = array( 'img_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR img_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText() ) );

			$result = $dbw->select( 'image', '*',
					$conditions,
					__METHOD__,
					array( 'ORDER BY' => 'img_timestamp DESC' )
					);

			$insertBatch = array();
			$archiveName = '';
			$first = true;

			while( $row = $dbw->fetchObject( $result ) ) {
				if( $first ) { // this is our new current revision
					$insertCurrent = array(
							'fa_storage_group' => $encGroup,
							'fa_storage_key'   => "",
							'fa_deleted_user'      => $encUserId,
							'fa_deleted_timestamp' => $encTimestamp,
							'fa_deleted_reason'    => $encReason,
							'fa_deleted'               => 0,

							'fa_name'         => self::getNameFromTitle( $this->mTitle ),
							'fa_archive_name' => 'NULL',
							'fa_size'         => $row->img_size,
							'fa_width'        => $row->img_width,
							'fa_height'       => $row->img_height,
							'fa_metadata'     => $row->img_metadata,
							'fa_bits'         => $row->img_bits,
							'fa_media_type'   => $row->img_media_type,
							'fa_major_mime'   => $row->img_major_mime,
							'fa_minor_mime'   => $row->img_minor_mime,
							'fa_description'  => $row->img_description,
							'fa_user'         => $row->img_user,
							'fa_user_text'    => $row->img_user_text,
							'fa_timestamp'    => $row->img_timestamp
								);
				} else {
					$insertBatchImg = array(
							'fa_storage_group' => $encGroup,
							'fa_storage_key'   => "",
							'fa_deleted_user'      => $encUserId,
							'fa_deleted_timestamp' => $encTimestamp,
							'fa_deleted_reason'    => $encReason,
							'fa_deleted'               => 0,

							'fa_name'         => self::getNameFromTitle( $this->mTitle ),
							'fa_archive_name' => $archiveName,
							'fa_size'         => $row->img_size,
							'fa_width'        => $row->img_width,
							'fa_height'       => $row->img_height,
							'fa_metadata'     => $row->img_metadata,
							'fa_bits'         => $row->img_bits,
							'fa_media_type'   => $row->img_media_type,
							'fa_major_mime'   => $row->img_major_mime,
							'fa_minor_mime'   => $row->img_minor_mime,
							'fa_description'  => $row->img_description,
							'fa_user'         => $row->img_user,
							'fa_user_text'    => $row->img_user_text,
							'fa_timestamp'    => $row->img_timestamp
								);
				}
				$deleteIds[] = $row->fa_id;
				$first = false;
			}

			if ( $insertCurrent ) {
				$dbw->insert( 'filearchive', $insertCurrent, __METHOD__ );
			}
			if ( $insertBatchImg ) {
				$dbw->insert( 'filearchive', $insertBatchImg, __METHOD__ );
			}

			$where = array( 'oi_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR oi_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText()) );

		} else { // single old revision to delete
			$where = array(
				'oi_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR oi_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText()),
				'oi_timestamp' => $oldvideo
			);

		}
		$encGroup = $dbw->addQuotes( 'deleted' );

		$dbw->insertSelect( 'filearchive', 'oldimage',
				array(
					'fa_storage_group' => $encGroup,
					'fa_storage_key'   => "''",
					'fa_deleted_user'      => $encUserId,
					'fa_deleted_timestamp' => $encTimestamp,
					'fa_deleted_reason'    => $encReason,
					'fa_name'         => $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ),
					'fa_archive_name' => 'oi_archive_name',
					'fa_size'         => 'oi_size',
					'fa_width'        => 'oi_width',
					'fa_height'       => 'oi_height',
					'fa_metadata'     => 'oi_metadata',
					'fa_bits'         => 'oi_bits',
					'fa_media_type'   => 'oi_media_type',
					'fa_major_mime'   => 'oi_major_mime',
					'fa_minor_mime'   => 'oi_minor_mime',
					'fa_description'  => 'oi_description',
					'fa_user'         => 'oi_user',
					'fa_user_text'    => 'oi_user_text',
					'fa_timestamp'    => 'oi_timestamp',
					'fa_deleted'      => 0
						), $where, __METHOD__ );


	}

	// delete all given video's records from image and oldimage or just one single old revision
	// complementary function for doDBInserts
	function doDBDeletes( $oldvideo = false ) {
		$dbw = wfGetDB( DB_MASTER );

		if (!$oldvideo ) {
			// clear current rev
			$dbw->delete( 'image', array( 'img_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR img_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText()) ), __METHOD__ );
			// clear all old revisions
			$where =  array( 'oi_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR oi_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText())  );
		} else { // clear just one given old revision
			$where =  array(
				'oi_name = ' . $dbw->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR oi_name = ' . $dbw->addQuotes( $this->mTitle->getPrefixedText()),
				'oi_timestamp' => $oldvideo
			);
		}

		// clear old revs
		$dbw->delete( 'oldimage', $where, __METHOD__ );

	}

	// table of contents
	function showTOC($metadata) {
		global $wgLang;
		$r = '<ul id="filetoc"><li><a href="#file">'.$wgLang->getNsText(NS_LEGACY_VIDEO).'</a></li><li><a href="#filehistory">'.wfMsgHtml( 'filehist' ).'</a></li>'.($metadata ? '<li><a href="#metadata">'.wfMsgHtml('metadata').'</a></li>' : '').'</ul>';
		return $r;
	}

	// wrapper
	function getContent() {
		return Article::getContent();
	}

	// generates the video window (for a video embedded on an article page)
	public function generateWindow($align, $width, $caption, $thumb, $frame) {
		global $wgStylePath;

		if ($frame) { // frame has always native width
			$ratios = explode( "x", $this->getTextRatio() );
			$width = intval( trim( $ratios[0] ) );
		}

		$code = $this->getEmbedCode($width, false, false, false);

		if(empty($thumb)) {
			return "<div class=\"t{$align}\" style=\"width:{$width}px\">{$code}</div>";
		}

		$url = $this->mTitle->getLocalURL('');

		$s = <<<EOD
<div class="thumb t{$align}">
	<div class="thumbinner" style="width:{$width}px;">
		{$code}
		<div class="thumbcaption">
			<div class="magnify"><a href="{$url}" class="internal"><img src="{$wgStylePath}/common/images/magnify-clip.png" width="15" height="11" alt="" /></a></div>
			$caption
		</div>
	</div>
</div>
EOD;
		return str_replace("\n", ' ', $s); // TODO: Figure out what for this string replace is
	}

	// generates the video thumb for CKeditor (plain image with RTE meta data)
	public function generateThumbForRTE($wikitext, $title, $align, $width, $caption, $thumb, $frame, $holders) {
		wfProfileIn(__METHOD__);

		// try to resolve internal links in broken image caption (RT #90616)
		if (RTEData::resolveLinksInMediaCaption($wikitext)) {
			// now resolve link markers in caption parsed to HTML
			if (!empty($holders)) {
				$holders->replace($caption);
			}

			RTE::log(__METHOD__ . ': resolved internal link');
		}

		RTE::log(__METHOD__, $wikitext);

		// RT #89713: trigger an edgecase when there's a link / double brackets in video caption
		if (RTEData::checkWikitextForMarkers($wikitext)) {
			RTE::$edgeCases[] = 'COMPLEX.09';
		}

		// render video thumb
		$video = $this->getThumbnailCode($width, false);

		// add extra CSS classes
		$videoClass = array('video');

		switch($align) {
			case 'left':
				$videoClass[] = 'alignLeft';
				break;

			case 'right':
				if (empty($thumb)) {
					$videoClass[] = 'alignRight';
				}
				break;
		}

		if (!empty($thumb)) {
			$videoClass[] = 'thumb';

			// only thumbed (with frame) videos can have captions
			if ($caption != '') {
				$videoClass[] = 'withCaption';
			}
		}

		$class = 'class="' . implode(' ', $videoClass) . '"';

		// add classes and type attribute to rendered video thumb
		$video = substr($video, 0, -2) . $class . ' type="video" />';

		// prepare RTE meta data
		$params = array(
			'href' => !empty($title) ? $title->getPrefixedText() : '',
			'align' => $align,
		);
		if (!empty($width)) {
			$params['width'] = intval($width);
		}

		// macbre: caption contains HTML (but it should contain wikitext)
		if ($caption != '') {
			$wikitextParts = explode('|', trim($wikitext, '[]'));

			// let's assume caption is the last part of image wikitext
			$originalCaption = end($wikitextParts);
			$originalCaption = htmlspecialchars_decode($originalCaption);

			$params['caption'] = $originalCaption;

			// HTML
			$params['captionParsed'] = $caption;
		}
		if (!empty($thumb)) {
			$params['thumb'] = 1;
		}

		// mark rendered video thumbnail with RTE marker
		$data = array(
			'type' => 'video',
			'params' => $params,
			'wikitext' => $wikitext,
		);

		RTE::log(__METHOD__, $data);

		$out = RTEData::addIdxToTag(RTEData::put('data', $data), $video);

		wfProfileOut(__METHOD__);

		return $out;
	}

	// recognize which supported provider we have from a given real life url
	// extract all the necessary data from this url
	public function parseUrl($url, $load = true) { // TODO: Consider renaming to loadFromURL
		global $wgContLang, $wgWikiaVideoRepoPath, $wgServer;
		
		$provider = '';
		$id = '';

		$url = trim($url);

		$fixed_url = strtoupper( $url );
		$test = strpos( $fixed_url, "HTTP://" );
		if( !false === $test ) {
			return false;
		}

		$fixed_url = str_replace( "HTTP://", "", $fixed_url );
		$fixed_parts = explode( "/", $fixed_url );
		$fixed_url = $fixed_parts[0];

		$text = strpos( $fixed_url, "METACAFE.COM" );
		if( false !== $text ) { // metacafe
			$provider = self::V_METACAFE;
			// reuse some NY stuff for now
			$standard_url = strpos( strtoupper( $url ), "HTTP://WWW.METACAFE.COM/WATCH/" );
			if( false !== $standard_url ) {
				$id = substr( $url , $standard_url+ strlen("HTTP://WWW.METACAFE.COM/WATCH/") , strlen($url) );
				$last_char = substr( $id,-1 ,1 );

				if($last_char == "/"){
					$id = substr( $id , 0 , strlen($id)-1 );
				}

				if ( !( false !== strpos( $id, ".SWF" ) ) ) {
					$id .= ".swf";
				}

				$data = explode( "/", $id );
				if (is_array( $data ) ) {
					$this->mProvider = $provider;
					$this->mId = $data[0];
					$this->mData = array( $data[1] );
					return true;
				}
			}
		}

		// YouTube
		if((strpos( $fixed_url, "YOUTUBE.COM" ) !== false) || (strpos( $fixed_url, "YOUTU.BE" ) !== false)){
			$provider = self::V_YOUTUBE;

			$aData = array();

			$id = '';
			$parsedUrl = parse_url( $url );
			if ( !empty( $parsedUrl['query'] ) ){
				parse_str( $parsedUrl['query'], $aData );
			};
			if ( isset( $aData['v'] ) ){
				$id = $aData['v'];
			}

			if( empty( $id ) ){
				$parsedUrl = parse_url( $url );

				$aExploded = explode( '/', $parsedUrl['path'] );
				$id = array_pop( $aExploded );
			}

			if( false !== strpos( $id, "&" ) ){
				$parsedId = explode("&",$id);
				$id = $parsedId[0];
			}
			
			$aData = array( $id );

			$this->mProvider = $provider;
			$this->mId = $id;
			$this->mData = $aData;

			return true;
		}

		$text = strpos( $fixed_url, "SEVENLOAD.COM" );
		if( false !== $text ) { // sevenload
			$provider = self::V_SEVENLOAD;
			$parsed = explode( "/", $url );
			$id = array_pop( $parsed );
			$parsed_id = explode( "-", $id );
			if( is_array( $parsed_id ) ) {
				$this->mProvider = $provider;
				$this->mId = $parsed_id[0];
				array_shift( $parsed_id );
				$this->mData = array(
					'-' . implode( "-", $parsed_id )
				);
				return true;
			}
		}

		$text = strpos( $fixed_url, "MYVIDEO.DE" );
		if( false !== $text ) { // myvideo
			$provider = self::V_MYVIDEO;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$mdata = array_pop( $parsed );
				$this->mProvider = $provider;
				$this->mId = array_pop( $parsed );
				$this->mData = array(
						$mdata
				);
				return true;
			}
		}

		$text = strpos( $fixed_url, "GAMEVIDEOS.1UP.COM" );
		if( false !== $text ) { // gamevideos
			$provider = self::V_GAMEVIDEOS;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$this->mProvider = $provider;
				$this->mId = array_pop( $parsed );
				$this->mData = array();
				return true;
			}
		}


		$text = strpos( $fixed_url, "VIMEO.COM" );
		if( false !== $text ) { // vimeo
			$provider = self::V_VIMEO;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$this->mProvider = $provider;
				$this->mId = array_pop( $parsed );
				$this->mData = array();
				return true;
			}
		}

		$text = strpos( $fixed_url, "5MIN.COM" );
		if( false !== $text ) { // 5min
			$provider = self::V_5MIN;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$this->mProvider = $provider;
				$ids = array_pop( $parsed );
				$parsed_twice = explode( "-", $ids );
				$this->mId = array_pop( $parsed_twice );
				$this->mData = array(
						implode( '-', $parsed_twice ) . '-'
					);
				return true;
			}
		}

		$text = strpos( $fixed_url, "SOUTHPARKSTUDIOS.COM" );
		if( false !== $text ) { // southparkstudios
				$provider = self::V_SOUTHPARKSTUDIOS;
				$parsed = explode( "/", $url );
				if( is_array( $parsed ) ) {
						$mdata = array_pop( $parsed );
						if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
								$this->mId = $mdata;
						} else {
								$this->mId = array_pop( $parsed );
						}
						$this->mProvider = $provider;
						$this->mData = array();
						return true;
				}
		}

		$text = strpos( $fixed_url, "BLIP.TV" );
		if( false !== $text ) { // Blip TV
			$provider = self::V_BLIPTV;
			$blip = '';
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$mdata = array_pop( $parsed );
				if ( '' != $mdata ) {
					$blip = $mdata;
				} else {
					$blip = array_pop( $parsed );
				}
				$this->mProvider = $provider;
				$this->mData = array();
				$last = explode( "?", $blip);
				$this->mId = $last[0];
				return true;
			}
		}

		$text = strpos( $fixed_url, "WWW.DAILYMOTION" );
		if( false !== $text ) { // Dailymotion
			// dailymotion goes like
			// http://www.dailymotion.pl/video/xavqj5_NAME
			// (example for Polish location)
			$provider = self::V_DAILYMOTION;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$mdata = array_pop( $parsed );
				if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
					// TODO: check out for more parameters
					$this->mId = $mdata;
				} else {
						$this->mId = array_pop( $parsed );
				}
				$this->mProvider = $provider;
				$this->mData = array();
				return true;
			}
		}

		$text = strpos( $fixed_url, "VIDDLER.COM" );
		if( false !== $text ) { // Blip TV
			$provider = self::V_VIDDLER;
			$parsed = explode( "/explore/", strtolower($url));
			if( is_array( $parsed ) ) {
				$mdata = array_pop( $parsed );
				if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
					$this->mId = $mdata;
				} else {
					$this->mId = array_pop( $parsed );
				}
				if ( substr( $this->mId, -1, 1) != "/" )
				{
					$this->mId .= "/";
				}
				$this->mProvider = $provider;
				$this->mData = array();
				return true;
			}
		}

		$text = strpos( $fixed_url, "GAMETRAILERS" );
		if( false !== $text ) { // Gametrailers
			$provider = self::V_GAMETRAILERS;
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$this->mId = explode("?",array_pop( $parsed ));
				$this->mId = $this->mId[0];
				$this->mProvider = $provider;
				$this->mData = array();
				return true;
			}
		}

		$text = strpos( $fixed_url, "HULU.COM" );
		if( false !== $text ) { // Hulu
			// Hulu goes like
			// http://www.hulu.com/watch/252775/[seo terms]
			$provider = self::V_HULU;
			$url = trim($url, "/");
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				// mId is a number, and it is either last or second to last element of $parsed
				$last = explode('?', array_pop( $parsed ) );
				$last = $last[0];
				if (is_numeric($last)) {
					$this->mId = $last;
				}
				else {
					$this->mId = array_pop($parsed);
					$seo = $last;
				}
				$this->mProvider = $provider;
				$this->mData = null;	// getHuluData() works only if mData is null
				$huluData = $this->getHuluData();
				$this->mData = array();
				if (is_array($huluData)) {
					foreach ($huluData as $key=>$value) {
						$this->mData[] = $value;
					}
				}
				if (!empty($seo)) {
					$this->mData[] = $seo;
				}
				return true;
			}
		}

		$text = strpos( $fixed_url, "TOTALECLIPS.COM" );
		if( false !== $text ) { // Screenplay
			$provider = self::V_SCREENPLAY;
			$qsvars = array();
			parse_str( parse_url($url, PHP_URL_QUERY), $qsvars );
			if( !empty( $qsvars['eclipid'] ) ) {
				$this->mId = $qsvars['eclipid'];
				$this->mProvider = $provider;
				$this->mData = array($qsvars['bitrateid'], 0);	// 2nd param: does HD exist? assume no
				//@todo get name and description
				return true;
			}
		}

		$text = strpos( $fixed_url, "MOVIECLIPS.COM" );
		if ( false !== $text ) { // MovieClips
			$provider = self::V_MOVIECLIPS;
			$url = trim($url, '/');
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$this->mProvider = $provider;
				$this->mId = array_pop( $parsed );
				$this->mData = array();
				return true;
			}
		}
		
		$text = strpos( strtolower($url), $wgWikiaVideoRepoPath );
		if ( false !== $text ) { // Wikia Video
			$provider = self::V_WIKIAVIDEO;
			$url = trim($url, '/');
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$idxNsVideo = strpos($url, $wgContLang->getNsText(NS_LEGACY_VIDEO).':');
				if ($idxNsVideo !== false) {
					$idxQueryStr = strpos($url, '?');
					$startIdx = $idxNsVideo + strlen($wgContLang->getNsText(NS_LEGACY_VIDEO).':');
					$videoTitle = substr($url, $startIdx, ($idxQueryStr !== false) ? $idxQueryStr-$startIdx : strlen($url));
					$this->mProvider = $provider;
					$this->mId = $videoTitle;
					$this->mData = array();
					return true;
				}
			}
		}

		$text = strpos( strtolower($url), $wgServer );
		if ( false !== $text ) { // Local video
			$provider = self::V_LOCALVIDEO;
			$url = trim($url, '/');
			$parsed = explode( "/", $url );
			if( is_array( $parsed ) ) {
				$idxNsVideo = strpos($url, $wgContLang->getNsText(NS_LEGACY_VIDEO).':');
				if ($idxNsVideo !== false) {
					$idxQueryStr = strpos($url, '?');
					$startIdx = $idxNsVideo + strlen($wgContLang->getNsText(NS_LEGACY_VIDEO).':');
					$videoTitle = substr($url, $startIdx, ($idxQueryStr !== false) ? $idxQueryStr-$startIdx : strlen($url));
					$this->mProvider = $provider;
					$this->mId = $videoTitle;
					$this->mData = array();
					return true;
				}
			}
		}
				
		// 9/9/11 wlee: no support for Real Gravity yet

		return false;
	}

	// gets the standard ratio for a current provider (as fraction)
	public function getRatio() {
		$ratio = 0;
		switch( $this->mProvider ) {
			case self::V_METACAFE:
				$ratio =  (40 / 35);
				break;
			case self::V_YOUTUBE:
				$ratio =  (640 / 363);
				break;
			case self::V_SEVENLOAD:
				$ratio =  (500 / 408);
				break;
			case self::V_GAMEVIDEOS:
				$ratio = (500 / 319);
				break;
			case self::V_5MIN:
				$ratio = (480 / 401);
				break;
			case self::V_VIMEO:
				$ratio = (400 / 225);
				break;
			case self::V_MYVIDEO:
				$ratio = (470 / 406);
				break;
            case self::V_SOUTHPARKSTUDIOS:
                $ratio = ( 480 / 400 );
				break;
			case self::V_BLIPTV:
				$ratio = (480 / 350);
				break;
			case self::V_DAILYMOTION:
				$ratio = (420 / 339);
				break;
			case self::V_VIDDLER:
				$ratio = (437 / 288);
				break;
			case self::V_GAMETRAILERS:
				$ratio = (480 / 392);
				break;
			case self::V_HULU:
				$ratio = (512 / 296);
				break;
			case self::V_SCREENPLAY:
				$ratio = (480 / 360);
				if (!empty($this->mData[0])) {
					if ($this->mData[0] == self::SCREENPLAY_STANDARD_BITRATE_ID) {
						$ratio = 480 / 270;
					}
				}
				break;
			case self::V_MOVIECLIPS:
				$ratio = (560 / 304);
				break;
			case self::V_REALGRAVITY:
				$ratio = (640 / 360);
				if (!empty($this->mData[0])) {
					list($width, $height) = explode('x', $this->mData[0]);
					$ratio = $width / $height;
				}
				break;
			case self::V_WIKIAVIDEO:
			case self::V_LOCALVIDEO:
				// not applicable
				break;
			default:
				$ratio = 1;
				break;
		}
		return $ratio;
	}

	// gets the standard ratio for a current provider (as text)
	public function getTextRatio() {
		$ratio = '';
			switch( $this->mProvider ) {
			case self::V_METACAFE:
				$ratio = "400 x 350";
				break;
			case self::V_YOUTUBE:
				$ratio = "640 x 363";
				break;
			case self::V_SEVENLOAD:
				$ratio = "500 x 408";
				break;
			case self::V_GAMEVIDEOS:
				$ratio = "500 x 319";
				break;
			case self::V_5MIN:
				$ratio = "480 x 401";
				break;
			case self::V_VIMEO:
				$ratio = "400 x 225";
				break;
            case self::V_SOUTHPARKSTUDIOS:
				$ratio = "480 x 400";
				break;
			case self::V_BLIPTV:
				$ratio = "480 x 350";
				break;
			case self::V_DAILYMOTION:
				$ratio = "420 x 339";
				break;
			case self::V_VIDDLER:
				$ratio = "437 x 288";
				break;
			case self::V_GAMETRAILERS:
				$ratio = "480 x 392";
				break;
			case self::V_MYVIDEO:
				$ratio = "470 x 406";
				break;
			case self::V_HULU:
				$ratio = "512 x 296";
				break;
			case self::V_SCREENPLAY:
				$ratio = "480 x 360";
				if (!empty($this->mData[0])) {
					if ($this->mData[0] == self::SCREENPLAY_STANDARD_BITRATE_ID) {
						$ratio = "480 x 270";
					}
				}
				break;
			case self::V_MOVIECLIPS:
				$ratio = "560 x 304";
				break;
			case self::V_REALGRAVITY:
				$ratio = "640 x 360";
				if (!empty($this->mData[0])) {
					list($width, $height) = explode('x', $this->mData[0]);
					if ($width > self::DEFAULT_OASIS_VIDEO_WIDTH) {
						$scalingRatio = self::DEFAULT_OASIS_VIDEO_WIDTH / $width;
						$width = self::DEFAULT_OASIS_VIDEO_WIDTH;
						$height = round($height * $scalingRatio);
					}
					$ratio = $width . ' x ' . $height;
				}				
				break;
			case self::V_WIKIAVIDEO:
			case self::V_LOCALVIDEO:
				// not applicable
				break;
			default:
				$ratio = "300 x 300";
				break;
		}
		return $ratio;
	}
	// run a check from provided api or elsewhere
	// to see if we can go to details page or not
	public function checkIfVideoExists() {
		$exists = false;
		switch( $this->mProvider ) {
			case self::V_METACAFE:
				$file = @Http::get( "http://www.metacafe.com/api/item/" . $this->mId, FALSE );
				if ($file) {
					$doc = new DOMDocument( '1.0', 'UTF-8' );
					@$doc->loadHTML( $file );
					if( $item = $doc->getElementsByTagName('item')->item( 0 ) ) {
						$this->mVideoName = trim( $item->getElementsByTagName('title')->item(0)->textContent );
						$exists = true;
					}
				}
				break;
			case self::V_YOUTUBE:
				$file = @Http::get( "http://gdata.youtube.com/feeds/api/videos/" . $this->mId, FILE_TEXT );
				if ($file) {
					$doc = new DOMDocument( '1.0', 'UTF-8' );
					@$doc->loadXML( $file );
					$this->mVideoName = trim( $doc->getElementsByTagName('title')->item(0)->textContent );
					$exists = true;
				}
				break;
			case self::V_SEVENLOAD:
				// needs an API key - to be done last
				// 1. create a token
				// http://api.sevenload.com/rest/1.0/tokens/create with user and password

				// 2. load the data using the token
				// http://api.sevenload.com/rest/1.0/items/A2C4E6G \
				//  ?username=XYZ&token-id=8b8453ca4b79f500e94aac1fc7025b0704f3f2c7

				$exists = true;
				break;
			case self::V_GAMEVIDEOS:
				$exists = true;
				break;
			case self::V_5MIN:
				$file = @Http::get( "http://api.5min.com/video/" . $this->mId . '/info.xml', FALSE );
				if ($file) {
					$doc = new DOMDocument( '1.0', 'UTF-8' );
					@$doc->loadXML( $file );
					if( $item = $doc->getElementsByTagName('item')->item( 0 ) ) {
						$this->mVideoName = trim( $item->getElementsByTagName('title')->item(0)->textContent );
						$exists = true;
					}
				}
				break;
			case self::V_VIMEO:
				$file = @Http::get( "http://vimeo.com/api/v2/video/" . $this->mId . '.php', FALSE );
				if ($file) {
					$data = unserialize( $file );
					$this->mVideoName = trim( $data[0]["title"] );
					$exists = true;
				}
				break;
			case self::V_MYVIDEO:
				// entire site is in German? I need help here
				$exists = true;
				break;
			case self::V_SOUTHPARKSTUDIOS: // todo verify if exists
				$exists = true;
				break;
			case self::V_BLIPTV: // todo verify if exists
				$exists = $this->getBlipTVData() != false ;
				break;
			case self::V_DAILYMOTION:
				$file = @Http::get( 'http://www.dailymotion.com/video/' . $this->mId );
				if (strpos($file,$this->mId) > -1)
				{
					return true;
				}
				return false;
				break;
			case self::V_VIDDLER:
				$exists = $this->getViddlerTrueID() != false ;
				break;
			case self::V_GAMETRAILERS: // todo verify if exists
				$url = $this->getUrl(self::V_GAMETRAILERS.",".$this->mId);
				$file = @Http::get($url); // if 404 file is empty
				if( strlen($file) < 100 ){
					return false;
				}
				return true;
				break;
			case self::V_HULU:
				$exists = $this->getHuluData() != false;
				break;
			case self::V_SCREENPLAY:
				//@todo verify if exists
				$exists = true;
				break;
			case self::V_MOVIECLIPS:
				//@todo verify if exists
				$exists = true;
				break;
			case self::V_REALGRAVITY:
				//@todo verify if exists
				$exists = true;
				break;
			case self::V_WIKIAVIDEO:
				$rvs = new RelatedVideosService();
				$videoData = $rvs->getRelatedVideoData( array( 'articleId' => 0, 'title' => $this->mId, 'source' => true ));
				$exists = !empty($videoData['title']);
				if ($exists) {
					$this->mVideoName = $videoData['title'];
				}
				break;
			case self::V_LOCALVIDEO:
				$rvs = new RelatedVideosService();
				$videoData = $rvs->getRelatedVideoData( array( 'articleId' => 0, 'title' => $this->mId, 'source' => false ) );
				$exists = !empty($videoData['title']);
				if ($exists) {
					$this->mVideoName = $videoData['title'];
				}
				break;
			default:
				break;
		}
		
		return $exists;
	}


	function loadFromPars( $provider, $id, $data ) { // TODO: Consider renameing
		$this->mProvider = $provider;
		$this->mId = $id;
		$this->mData = $data;
	}

	public function setName( $name ) { // TODO: Maybe redundant - check!
		$this->mName = $name;
	}

	// return provider url
	public function getProviderUrl() {
		switch( $this->mProvider ) {
			case self::V_METACAFE:
				return 'http://www.metacafe.com';
			case self::V_YOUTUBE:
				return 'http://www.youtube.com';
			case self::V_SEVENLOAD:
				return 'http://www.sevenload.com';
			case self::V_GAMEVIDEOS:
				return 'http://gamevideos.1up.com';
			case self::V_5MIN:
				return 'http://www.5min.com';
			case self::V_MYVIDEO:
				return 'http://www/myvideo.de';
			case self::V_VIMEO:
				return 'http://www.vimeo.com';
			case self::V_SOUTHPARKSTUDIOS:
				return 'http://www.southparkstudios.com';
			case self::V_BLIPTV:
				return 'http://blip.tv';
			case self::V_DAILYMOTION:
				return 'http://www.dailymotion.com';
			case self::V_VIDDLER:
				return 'http://www.viddler.com';
			case self::V_GAMETRAILERS:
				return 'http://www.gametrailers.com';
			case self::V_HULU:
				return 'http://www.hulu.com';
			case self::V_SCREENPLAY:
				return 'http://www.screenplayinc.com';
			case self::V_MOVIECLIPS:
				return 'http://movieclips.com';
			case self::V_REALGRAVITY:
				return 'http://www.realgravity.com';
			case self::V_WIKIAVIDEO:
			case self::V_LOCALVIDEO:
				// not applicable
				return;
			default:
				return '';
		}
	}

	// return video name
	public function getVideoName() {
		$vname = '';
		isset( $this->mVideoName ) ? $vname = $this->mVideoName : $vname = '';
		return $vname;
	}

	// return url for the video file
	public static function getUrl( $metadata ) {
		$meta = explode( ",", $metadata );
		if ( is_array( $meta ) ) {
			$provider = $meta[0];
			$id = $meta[1];
			array_splice( $meta, 0, 2 );
			if ( count( $meta ) > 0 ) {
				foreach( $meta as $data  ) {
					$mData[] = $data;
				}
			}
		}
		$url = '';
		switch( $provider ) {
			case self::V_METACAFE:
				$url = 'http://www.metacafe.com/watch/' . $id . '/' . $mData[0];
				break;
			case self::V_YOUTUBE:
				$url = 'http://www.youtube.com/watch?v=' . $id;
				break;
			case self::V_SEVENLOAD:
				$url = 'http://www.sevenload.com/videos/' . $id;
				break;
			case self::V_GAMEVIDEOS:
				$url = 'http://gamevideos.1up.com/video/id/' . $id;
				break;
			case self::V_5MIN:
				$url = 'http://www.5min.com/Video/' . $mData[0] . $id;
				break;
			case self::V_MYVIDEO:
				$url = 'http://www/myvideo.de/watch/' . $id;
				break;
			case self::V_VIMEO:
				$url = 'http://www.vimeo.com/' . $id;
				break;
			case self::V_SOUTHPARKSTUDIOS:
				$url = 'http://www.southparkstudios.com/clips/' . $id;
				break;
			case self::V_BLIPTV:
				$url = 'http://blip.tv/file/' . $id;
				break;
			case self::V_DAILYMOTION:
				$url = 'http://www.dailymotion.com/video/' . $id;
				break;
			case self::V_VIDDLER:
				$url = 'http://www.viddler.com/explore/' . $id;
				break;
			case self::V_GAMETRAILERS:
				$url = 'http://www.gametrailers.com/video/play/' . $id;
				break;
			case self::V_HULU:
				$url = 'http://www.hulu.com/watch/' . $id;
				break;
			case self::V_SCREENPLAY:
				$url = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$id.'&bitrateid='.$mData[0].'&vendorid='.self::$SCREENPLAY_VENDOR_ID.'&type='.self::$SCREENPLAY_VIDEO_TYPE;
				break;
			case self::V_MOVIECLIPS:
				$url = 'http://movieclips.com/' . $id . '/';
				break;
			case self::V_REALGRAVITY:
				// not provided by realgravity api
				$url = '';
				break;
			case self::V_WIKIAVIDEO:
				// not applicable
				$url = '';
				break;
			default:
				$url = '';
				break;
		}
		return $url;
	}

	// return the provider from instance
	public function getProvider() {
		return $this->mProvider;
	}

	// return the video id (provider's, not ours!) from instance
	public function getVideoId() {
		return $this->mId;
	}

	// return additional metadata (if any) from instance
	public function getData() {
		return $this->mData;
	}

	// return normalized name for db purposes
	public static function getNameFromTitle( $title ) {
		global $wgCapitalLinks;
		if ( !$wgCapitalLinks ) {
			$name = $title->getUserCaseDBKey();
		} else {
			$name = $title->getDBkey();
		}
		return ":" . $name;
	}

	/*
	 * Save video in DB. Handles overwrite.
	 * @param string $addlWikitext for new articles, additional wiki text to include in article (meant for adding categories)
	 */
	public function save($addlWikitext='') {
		global $wgUser, $wgContLang;

		$desc = wfMsg( 'wikiavideo-added', $this->mTitle->getText() );

		$dbw = wfGetDB( DB_MASTER );
		$now = $dbw->timestamp();

		switch( $this->mProvider ) {
			case self::V_METACAFE:
			case self::V_SEVENLOAD:
			case self::V_MYVIDEO:
			case self::V_5MIN:
				$metadata = $this->mProvider . ',' . $this->mId . ',' . $this->mData[0];
				break;
			case self::V_GAMEVIDEOS:
			case self::V_VIMEO:
			case self::V_SOUTHPARKSTUDIOS:
			case self::V_BLIPTV:
			case self::V_DAILYMOTION:
			case self::V_VIDDLER:
			case self::V_GAMETRAILERS:
				$metadata = $this->mProvider . ',' . $this->mId . ',';
				break;
			case self::V_HULU:
			case self::V_SCREENPLAY:
			case self::V_MOVIECLIPS:
			case self::V_REALGRAVITY:
			case self::V_YOUTUBE:
				$metadata = $this->mProvider . ',' . $this->mId . ',' . implode(',', $this->mData);
				break;
			// do not allow these providers to be saved
			case self::V_WIKIAVIDEO:
			case self::V_LOCALVIDEO:
				return;
			default:
				$metadata = '';
				break;
		}

		if( $this->mTitle->isDeleted() ) {
			$this->doCleanup(); // if the article was previously deleted, and we're inserting a new one
		}

		$dbw->insert( 'image',
			array(
				'img_name' => self::getNameFromTitle( $this->mTitle ),
				'img_size' => 300,
				'img_description' => '',
				'img_user' => $wgUser->getID(),
				'img_user_text' => $wgUser->getName(),
				'img_timestamp' => $now,
				'img_metadata'	=> $metadata,
				'img_media_type' => 'VIDEO',
				'img_major_mime' => 'video',
				'img_minor_mime' => 'swf',
			),
			__METHOD__,
			'IGNORE'
		);

		$cat = $wgContLang->getFormattedNsText( NS_CATEGORY );
		$saved_text = '[[' . $cat . ':' . wfMsgForContent( 'wikiavideo-category' ) . ']]';
		if ($addlWikitext) {
			$saved_text .= $addlWikitext;
		}

		if( $dbw->affectedRows() == 0 ) {
			// we are updating
			$desc = wfMsgForContent( 'wikiavideo-updated', $this->mTitle->getPrefixedText() );
			$dbw->insertSelect( 'oldimage', 'image',
				array(
					'oi_name' => 'img_name',
					'oi_archive_name' => 'img_name',
					'oi_size' => 'img_size',
					'oi_width' => 'img_width',
					'oi_height' => 'img_height',
					'oi_bits' => 'img_bits',
					'oi_timestamp' => 'img_timestamp',
					'oi_description' => 'img_description',
					'oi_user' => 'img_user',
					'oi_user_text' => 'img_user_text',
					'oi_metadata' => 'img_metadata',
					'oi_media_type' => 'img_media_type',
					'oi_major_mime' => 'img_major_mime',
					'oi_minor_mime' => 'img_minor_mime',
					'oi_sha1' => 'img_sha1'
				), array( 'img_name' => self::getNameFromTitle( $this->mTitle ) ), __METHOD__
			);

			// update the current image row
			$dbw->update( 'image',
				array( /* SET */
					'img_timestamp' => $now,
					'img_user' => $wgUser->getID(),
					'img_user_text' => $wgUser->getName(),
					'img_metadata' => $metadata,
				), array( /* WHERE */
					'img_name' => self::getNameFromTitle( $this->mTitle )
					), __METHOD__
			);
			$log = new LogPage( 'upload' );
			$log->addEntry( 'overwrite', $this->mTitle, $desc );
		}

		$this->doEdit( $saved_text, $desc );
		$dbw->immediateCommit();
	}

	// load old video
	public static function getOldUrl( $title, $oldvideo ) {
		$fname = 'VideoPage' . '::' . __FUNCTION__;
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow(
			'oldimage',
			'oi_metadata',
			array(
				'oi_name = ' . $dbr->addQuotes( self::getNameFromTitle( $title ) ) .' OR oi_name = ' . $dbr->addQuotes( $title->getPrefixedText() ),
				'oi_timestamp' => $oldvideo
			),
			$fname
		);
		if ($row) {
			$metadata = explode( ",", $row->oi_metadata );
			if ( is_array( $metadata ) ) {
				$provider = $metadata[0];
				$id = $metadata[1];
				array_splice( $metadata, 0, 2 );
				if ( count( $metadata ) > 0 ) {
					foreach( $metadata as $data  ) {
						$tdata[] = $data;
					}
				}
			}
		}

		$ldata = array(
				$provider,
				$id,
				$tdata[0]
			     );


		$ldata = implode( ",", $ldata ) ;
		$url = self::getUrl( $ldata );
		return $url;
	}


	// load the data for an empty video object (constructed from article name)
	public function load($useMaster = false) {
		$fname = get_class( $this ) . '::' . __FUNCTION__;
		$dbr = wfGetDB( $useMaster ? DB_MASTER : DB_SLAVE );
		$row = $dbr->selectRow(
			'image',
			'img_metadata',
			'img_name = ' . $dbr->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR img_name = ' . $dbr->addQuotes( $this->mTitle->getPrefixedText() ),
			$fname
		);
		if ($row) {
			$metadata = explode( ",", $row->img_metadata );
			if ( is_array( $metadata ) && count( $metadata ) > 1 ) {
				$this->mProvider = $metadata[0];
				$this->mId = $metadata[1];
				array_splice( $metadata, 0, 2 );
				foreach( $metadata as $data  ) {
					$this->mData[] = $data;
				}
			}
		}
	}

	// handle video page revert
	function revert() {
		global $wgOut, $wgRequest, $wgUser;

		// is the target protected?
		$permErrors = $this->mTitle->getUserPermissionsErrors( 'edit', $wgUser );
		$permErrorsUpload = $this->mTitle->getUserPermissionsErrors( 'upload', $wgUser );

		if( $permErrors || $permErrorsUpload ) {
			$wgOut->addHTML( wfMsg( 'wikiavideo-unreverted', '<b>' . $this->mTitle->getText() . '</b>' ) );
			return ;
		}

		$timestamp = $wgRequest->getVal( 'oldvideo' );
		$fname = get_class( $this ) . '::' . __FUNCTION__;
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow(
			'oldimage',
			'oi_metadata AS img_metadata',
			array(
				'oi_name' => self::getNameFromTitle( $this->mTitle ),
				'oi_timestamp' => $timestamp
			),
			$fname
		);
		if ($row) {
			$metadata = explode( ",", $row->img_metadata );
			if ( is_array( $metadata ) ) {
				$this->mProvider = $metadata[0];
				$this->mId = $metadata[1];
				array_splice( $metadata, 0, 2 );
				if ( count( $metadata ) > 0 ) {
					foreach( $metadata as $data  ) {
						$this->mData[] = $data;
					}
				}
			}
		}
		$sk = $wgUser->getSkin();
		$link_back = $sk->makeKnownLinkObj( $this->mTitle );
		$this->setName( $this->mTitle->getText() );
		$this->save();
		$wgOut->addHTML( wfMsg( 'wikiavideo-reverted', '<b>' . $this->mTitle->getText() . '</b>', $link_back ) );
	}

	// main wrapper for displaying video history for video page
	function videoHistory() {
		global $wgOut;
		$dbr = wfGetDB( DB_SLAVE );
		$list = new VideoHistoryList( $this );
		$s = $list->beginVideoHistoryList();
		$s .= $list->videoHistoryLine( true );
		$s .= $list->videoHistoryLine();
		$s .= $list->endVideoHistoryList();
		$wgOut->addHTML( $s );
	}

	// display pages linking to that video (on video page)
       function videoLinks() {
                global $wgUser, $wgOut;
                $limit = 100;

                $dbr = wfGetDB( DB_SLAVE );

                $res = $dbr->select(
                        array( 'imagelinks', 'page' ),
                        array( 'page_namespace', 'page_title' ),
			'(il_to = ' . $dbr->addQuotes( self::getNameFromTitle( $this->mTitle ) ) .' OR il_to = ' . $dbr->addQuotes( $this->mTitle->getPrefixedText() ) . ') AND il_from = page_id',
                        __METHOD__,
                        array( 'LIMIT' => $limit + 1)
                );
                $count = $dbr->numRows( $res );
                if ( $count == 0 ) {
                        $wgOut->addHTML( "<div id='mw-imagepage-nolinkstoimage'>\n" );
                        $wgOut->addWikiMsg( 'nolinkstoimage' );
                        $wgOut->addHTML( "</div>\n" );
                        return;
                }
                $wgOut->addHTML( "<div id='mw-imagepage-section-linkstoimage'>\n" );
                $wgOut->addWikiMsg( 'linkstoimage', $count );
                $wgOut->addHTML( "<ul class='mw-imagepage-linktoimage'>\n" );

                $sk = $wgUser->getSkin();
                $count = 0;
                while ( $s = $res->fetchObject() ) {
                        $count++;
                        if ( $count <= $limit ) {
                                // We have not yet reached the extra one that tells us there is more to fetch
                                $name = Title::makeTitle( $s->page_namespace, $s->page_title );
                                $link = $sk->makeKnownLinkObj( $name, "" );
                                $wgOut->addHTML( "<li>{$link}</li>\n" );
                        }
                }
                $wgOut->addHTML( "</ul></div>\n" );
                $res->free();

                // Add a links to [[Special:Whatlinkshere]]
                if ( $count > $limit )
                        $wgOut->addWikiMsg( 'morelinkstoimage', $this->mTitle->getPrefixedDBkey() );
        }

    /* for get Viddler id by api and hold in cache */

	private function getViddlerTrueID()
	{
		global $wgMemc,$wgTranscludeCacheExpiry;
		$cacheKey = wfMemcKey( "wvi", "viddlerid",$this->mId );
		$obj  = $wgMemc->get( $cacheKey );

		if (isset($obj))
		{
			return 	$obj;
		}
		$url =  "http://api.viddler.com/rest/v1/?method=viddler.videos.getDetailsByUrl&api_key=".
					self::K_VIDDLER . "&url=http://www.viddler.com/explore/" . $this->mId;
		$file = @Http::get($url );
		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $file );
		$mTrueID = trim( $doc->getElementsByTagName('id')->item(0)->textContent );
		if (empty($mTrueID))
		{
			return false;
		}
		$wgMemc->set( $cacheKey, $mTrueID,60*60*24 );
		return $mTrueID;
	}
	 /* for get BlipTV data (true id and avatar url) by api and hold in cache */
	private function getBlipTVData()
	{
		global $wgMemc,$wgTranscludeCacheExpiry;
		$cacheKey = wfMemcKey( "wvi", "bliptv",$this->mId );
		$obj  = $wgMemc->get( $cacheKey );

		if (isset($obj))
		{
			return $obj;
		}

		$url = "http://blip.tv/file/" . $this->mId . "?skin=rss&version=3";

		$file = @Http::get($url );
	 	if (empty($file))
	 	{
	 		return false;
	 	}
		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $file );

		$mTrueIDNode = $doc->getElementsByTagNameNS('http://blip.tv/dtd/blip/1.0',"embedLookup")->item(0);
		$thumbnailUrlNode  = $doc->getElementsByTagNameNS('http://search.yahoo.com/mrss/',"thumbnail")->item(0);
		$mTypeNode = $doc->getElementsByTagNameNS('http://blip.tv/dtd/blip/1.0',"embedUrl")->item(0);

		if ( (empty($mTypeNode) || trim($mTypeNode->getAttribute("type")) !== "application/x-shockwave-flash") || empty($mTrueIDNode) || empty($thumbnailUrlNode))
		{
			return false;
		}

		$obj = array(
			'mTrueID' => trim($mTrueIDNode->textContent),
			'thumbnailUrl' => trim($thumbnailUrlNode->getAttribute("url"))
		);
		
		$wgMemc->set( $cacheKey, $obj,60*60*24 );
		return $obj;
	}

	private function getHuluData() {
		$huluData = array();
		if (!empty($this->mData)) {
			// metadata could be a one-element array, expressed in serialized form.
			// If so, deserialize
			if (sizeof($this->mData) == 1) {
				$this->mData = explode(',', $this->mData[0]);
			}
			$huluData['embedId'] = $this->mData[0];
			$huluData['thumbnailUrl'] = $this->mData[1];
			$huluData['videoName'] = $this->mData[2];
			if (sizeof($this->mData) > 3) {
				$huluData['seo'] = $this->mData[3];
			}
		}
		else {
			$file = @Http::get( "http://www.hulu.com/api/oembed.xml?url=" . urlencode("http://www.hulu.com/watch/".$this->mId), FALSE );
			if ($file) {
				$doc = new DOMDocument( '1.0', 'UTF-8' );
				@$doc->loadXML( $file );
				$embedUrl = trim( $doc->getElementsByTagName('embed_url')->item(0)->textContent );
				$embedUrlParts = explode('/', $embedUrl);
				$huluData['embedId'] = array_pop($embedUrlParts);
				$huluData['thumbnailUrl'] = trim( $doc->getElementsByTagName('thumbnail_url')->item(0)->textContent );
				$huluData['videoName'] = trim( $doc->getElementsByTagName('title')->item(0)->textContent );
			}
		}
		$this->mVideoName = $huluData['videoName'];

		return $huluData;
	}

	public function getUrlToEmbed() {

		// todo switch through providers, make an API call and return proper stuff
		// basically this is for Blip.tv and Viddler for now, since they are using
		// some custom conversion between their ids and src values
		$converted_id = '';
		switch( $this->mProvider ) {
			case self::V_BLIPTV:
			 	$result = $this->getBlipTVData();
			 	return "http://blip.tv/play/".$result['mTrueID'];
				break;
			case self::V_VIDDLER:
				return "http://www.viddler.com/player/" . $this->getViddlerTrueID() . "/";
				break;
			case self::V_HULU:
				$huluData = $this->getHuluData();
				return "http://www.hulu.com/embed/" . $huluData['embedId'];
			default:
				// no other providers up to date will make use of this function anyway...
				break;
		}
		// very temporary
		return $converted_id;
	}

	// return embed code for the particular video per provider
	public function getEmbedCode( $width = 300, $autoplay = false, $useJWPlayer = false, $asJSON = false, $cityShort='life', $height='', $inAjaxResponse=false ) {
		// init jwplayer vars
		$jwplayerData = array();
		$jwplayerData['jwplayerjs'] = AssetsManager::getInstance()->getOneCommonURL( trim(self::$JWPLAYER_DIR . self::$JWPLAYER_JS, '/'), false );
		$jwplayerData['player'] = AssetsManager::getInstance()->getOneCommonURL( trim(self::$JWPLAYER_DIR . self::$JWPLAYER_SWF, '/'), false );
		$jwplayerData['playerId'] = 'player-'.$this->mId.'-'.mt_rand();
		$jwplayerData['plugins'] = array('gapro-1' => array('accountid'=>self::VIDEO_GOOGLE_ANALYTICS_ACCOUNT_ID), 
                            'timeslidertooltipplugin-2' => array(), 
                            // wlee 2012/4/14: disabling because of conflict with preroll ads (https://wikia.fogbugz.com/default.asp?20871)
                            //(self::$JWPLAYER_DIR.self::$JWPLAYER_JS_PLUGINS_DIR .'infobox.js') => array( 'title'=>htmlspecialchars( $this->mTitle->getText() ) )
                            );
		if ($width < 330) {
			$wikiaSkinZip = 'wikia-small.zip';
		}
		elseif ($width >= 660) {
			$wikiaSkinZip = 'wikia.zip';			
		}
		else {
			$wikiaSkinZip = 'wikia-medium.zip';			
		}
		$jwplayerData['skin'] = AssetsManager::getInstance()->getOneCommonURL( trim(self::$JWPLAYER_DIR . 'skins/wikia/'.$wikiaSkinZip, '/'), false );
		
		$embed = "";
		$url = "";
		$code = 'standard';
		if (!$height) {
			if ($this->getRatio()) {
				// certain providers may not have width and height
				// defined, like V_WIKIAVIDEO. This is ok.
				$height = round( $width / $this->getRatio() );
			}
		}


		switch( $this->mProvider ) {
			case self::V_METACAFE:
				$url = 'http://www.metacafe.com/fplayer/' . $this->mId . '/' . $this->mData[0];
				$code = 'custom';
				$autoplay ? $auto = 'flashVars="playerVars=autoPlay=yes"' : $auto = '';
				$embed = '<embed ' . $auto . ' src="' . $url . '" width="' . $width . '" height="' . $height . '" wmode="transparent"" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>';
				break;
			case self::V_YOUTUBE:
				$hd = false;
				// mData either has mId (string), related (string), duration (int), description (string), hd (int), noembed (int)
				// or mId, duration, description, hd, noembed
				$this->getYoutubeData();
				if (sizeof($this->mData) >= 6) {
					if (!empty($this->mData[4])) {
						$hd = true;
					} 	
				}
				elseif (sizeof($this->mData) >= 5) {
					if (!empty($this->mData[3])) {
						$hd = true;
					}
				}
				
				$url = 'http://www.youtube.com/v/' . $this->mId . '&enablejsapi=1&fs=1' . ($autoplay ? '&autoplay=1' : '') . ( !empty($hd) ? '&hd=1' : '');
				if ($useJWPlayer) {
					$code = 'custom';
					$jwplayerData['file'] = $url;
					if ($hd) {
						$jwplayerData['plugins'][self::$JWPLAYER_DIR.self::$JWPLAYER_PLUGIN_HD_SWF] = array();
					}
				}
				break;
			case self::V_SEVENLOAD:
				$code = 'custom';
				$embed = '<object style="visibility: visible;" id="sevenloadPlayer_' . $this->mId . '" data="http://static.sevenload.com/swf/player/player.swf" type="application/x-shockwave-flash" height="' . $height . '" width="' . $width . '"><param name="wmode" value="transparent"><param value="always" name="allowScriptAccess"><param value="true" name="allowFullscreen"><param value="configPath=http%3A%2F%2Fflash.sevenload.com%2Fplayer%3FportalId%3Den%26autoplay%3D0%26itemId%3D' . $this->mId . '&amp;locale=en_US&amp;autoplay=0&amp;environment=" name="flashvars"></object>';
				break;
			case self::V_MYVIDEO:
				$code = 'custom';
				$embed = "<object style='width:{$width}px;height:{$height}px;' type='application/x-shockwave-flash' data='http://www.myvideo.de/movie/{$this->mId}'><param name='wmode' value='transparent'><param name='movie' value='http://www.myvideo.de/movie/{$this->mId}' /> <param name='AllowFullscreen?' value='true' /> </object>";
				break;
			case self::V_GAMEVIDEOS:
				$code = 'custom';
				$embed = '<embed wmode="transparent" type="application/x-shockwave-flash" width="' . $width . '" height="' . $height . '" src="http://gamevideos.1up.com/swf/gamevideos12.swf?embedded=1&amp;fullscreen=1&amp;autoplay=0&amp;src=http://gamevideos.1up.com/do/videoListXML%3Fid%3D' . $this->mId . '%26adPlay%3Dtrue" align="middle"></embed>';
				break;
			case self::V_5MIN:
				$code = 'custom';
				$embed = "<object width='{$width}' height='{$height}' id='FiveminPlayer' classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'><param name='allowfullscreen' value='true'/><param name='wmode' value='transparent'><param name='allowScriptAccess' value='always'/><param name='movie' value='http://www.5min.com/Embeded/{$this->mId}/'/><embed src='http://www.5min.com/Embeded/{$this->mId}/' type='application/x-shockwave-flash' width='{$width}' height='{$height}' allowfullscreen='true' allowScriptAccess='always'></embed></object>";
				break;
			case self::V_VIMEO:
				$code = 'custom';
				$auto = $autoplay ? '&amp;autoplay=1' : '';
				$embed = '<object width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true" /><param name="wmode" value="transparent"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$this->mId.'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1'.$auto.'" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$this->mId.'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1'.$auto.'" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed></object>';
				break;
			case self::V_SOUTHPARKSTUDIOS:
				$code = 'custom';
				$embed = '<embed src="http://media.mtvnservices.com/mgid:cms:item:southparkstudios.com:' . $this->mId . '" width="' . $width . '" height="' . $height . '" type="application/x-shockwave-flash" wmode="window" flashVars="autoPlay=false&dist=http://www.southparkstudios.com&orig=" allowFullScreen="true" allowScriptAccess="always" allownetworking="all" bgcolor="#000000"></embed>';
				break;
			case self::V_BLIPTV:
				$url = $this->getUrlToEmbed();
				break;
			case self::V_DAILYMOTION:
				$url = 'http://www.dailymotion.com/swf/' . $this->mId;
				break;
			case self::V_VIDDLER:
				// this needs to take from their API, since they're doing some conversion on their side
				// URL id -> embedding id
				$url = $this->getUrlToEmbed();
				break;
			case self::V_GAMETRAILERS:
				$code = 'custom';
				// note: object and embed tags must be on one 
				// line, or else MW parser will inject <p> tags 
				// and do other weird things!
				$embed =
				'<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" id="gtembed" width="'.$width.'" height="'.$height.'">
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="allowFullScreen" value="true" />
					<param name="movie" value="http://www.gametrailers.com/remote_wrap.php?mid='.$this->mId.'"/>
					<param name="quality" value="high" />
					<embed src="http://www.gametrailers.com/remote_wrap.php?mid='.$this->mId.'" swLiveConnect="true" name="gtembed" align="middle" allowScriptAccess="sameDomain" allowFullScreen="true" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed> ]
				</object>' ;
				break;
			case self::V_HULU:
				$url = $this->getUrlToEmbed();
				break;
			case self::V_SCREENPLAY:				
				$useJWPlayer = true;	// always use JW Player
				$jwplayerData['file'] = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$this->mId.'&bitrateid='.$this->mData[0].'&vendorid='.self::$SCREENPLAY_VENDOR_ID.'&type='.self::$SCREENPLAY_VIDEO_TYPE;
				$jwplayerData['hdfile'] = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$this->mId.'&bitrateid='.self::SCREENPLAY_HIGHDEF_BITRATE_ID.'&vendorid='.self::$SCREENPLAY_VENDOR_ID.'&type='.self::$SCREENPLAY_VIDEO_TYPE;
				$jpegBitrateId = !empty($this->mData[3]) ? $this->mData[3] : self::SCREENPLAY_MEDIUM_JPEG_BITRATE_ID;
				if (empty($autoplay)) {
					$jwplayerData['image'] = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$this->mId.'&bitrateid='. $jpegBitrateId .'&vendorid='.self::$SCREENPLAY_VENDOR_ID.'&type=.jpg';
				}
				$jwplayerData['provider'] = 'video';

				if ($this->mData[1]) {
					$jwplayerData['plugins'][self::$JWPLAYER_DIR.self::$JWPLAYER_PLUGIN_HD_SWF] = array('file'=>$jwplayerData['hdfile'], 'state'=>'false');  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior
				}
				
				// preroll
//				$jwplayerData['plugins']['http://lp.longtailvideo.com/5/adtvideo/adtvideo.swf'] = array('config'=>'/extensions/wikia/WikiaVideo/wikia_exclusive.xml');

				// ads
				self::$JWPLAYER_GOOGIMA_DATA['ad.tag'] = $this->initGoogleIMAAdTag($cityShort);
				if (self::$JWPLAYER_GOOGIMA_DATA['ad.tag']) {
					$jwplayerData['plugins']['googima'] = self::$JWPLAYER_GOOGIMA_DATA;
				}
				
				$code = 'custom';
				break;
			case self::V_MOVIECLIPS:
				$code = 'custom';
				// note: object and embed tags must be on one 
				// line, or else MW parser will inject <p> tags 
				// and do other weird things!
				$embed = '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/'.$this->mId.'/%3Floc%3DPL&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" style="display:block; overflow:hidden;">
					<param name="movie" value="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/'.$this->mId.'/%3Floc%3DPL&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" />
					<param name="wmode" value="transparent" />
					<param name="allowscriptaccess" value="always" />
					<param name="allowfullscreen" value="true" />
					<param name="FlashVars" value="autoPlay='.($autoplay ? 'true' : 'false').'" />
					<embed src="http://static.movieclips.com/embedplayer.swf?config=http://config.movieclips.com/player/config/embed/'.$this->mId.'/%3Floc%3DPL&endpoint=http://movieclips.com/api/v1/player/test/action/&start=0&v=1.0.15" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" FlashVars="autoPlay='.($autoplay ? 'true' : 'false').'"></embed>
					</object>';
				break;
			case self::V_REALGRAVITY:
				if ($width == self::DEFAULT_VET_WIDTH) {
					$playerId = self::REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID;
				}
				elseif ($autoplay) {
					$playerId = self::REALGRAVITY_PLAYER_AUTOSTART_ID;
				}
				else {
					$playerId = self::REALGRAVITY_PLAYER_NO_AUTOSTART_ID;
				}

				// note: object and embed tags must be on one 
				// line, or else MW parser will inject <p> tags 
				// and do other weird things!
				$embed = 
					'<object id="rg_player_'.$playerId.'" name="rg_player_'.$playerId.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" classid="clsid:'.$playerId.'" style="visibility: visible;" data="http://anomaly.realgravity.com/flash/player.swf">
					  <param name="allowscriptaccess" value="always"></param>
					  <param name="allowNetworking" value="all"></param>
					  <param name="menu" value="false"></param>
					  <param name="wmode" value="transparent"></param>
					  <param name="allowFullScreen" value="true"></param>
					  <param name="flashvars" value="&config=http://mediacast.realgravity.com/vs/api/playerxml/'.$playerId.'"></param>
					  <embed id="'.$playerId.'" name="'.$playerId.'" width="'.$width.'" height="'.$height.'" allowNetworking="all" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/'.$playerId.'/'.$this->mId.'.xml" src="http://anomaly.realgravity.com/flash/player.swf"></embed>
					 </object>';
				$code = 'custom';
				break;
			case self::V_WIKIAVIDEO:
				// load the real Video Page referred to by this object,
				// and get the embed code from there
				$rvs = new RelatedVideosService();
				$videoData = $rvs->getRelatedVideoData( array( 'articleId' => 0, 'title' => $this->mId, 'source' => true ), $width, '', 0, '', $useJWPlayer, $autoplay, $inAjaxResponse);	// fifth param is empty to suppress ads
				$embed = $videoData['embedCode'];
				return $embed;
				break;
			case self::V_LOCALVIDEO:
				// load the real Video Page referred to by this object,
				// and get the embed code from there
				$rvs = new RelatedVideosService();
				$videoData = $rvs->getRelatedVideoData( array( 'articleId' => 0, 'title' => $this->mId, 'source' => false ), $width, '', 0, '', $useJWPlayer, $autoplay, $inAjaxResponse);	// fifth param is empty to suppress ads
				$embed = $videoData['embedCode'];
				return $embed;
				break;
			default:
				break;
		}

		$sJSON = '';

		if( 'custom' != $code ) {
			$embed = "<embed src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" wmode=\"transparent\" allowScriptAccess=\"always\" allowfullscreen=\"true\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\"> </embed>";
		}
		elseif ($useJWPlayer && $this->isJWPlayerSupported()) {
			// jwplayer embed code
			$sJSON = '{'
				. '"flashplayer": "'.$jwplayerData['player'].'",'
				. '"id": "'.$jwplayerData['playerId'].'",'
				. '"width": "'.$width.'",'
				. '"height": "'.$height.'",'
				. '"file": ' . $this->initJWPlayerURL($jwplayerData['file'], $asJSON) . ','
				. (!empty($jwplayerData['image']) ? '"image": ' . $this->initJWPlayerURL($jwplayerData['image'], $asJSON) . ',' : '')
				. (!empty($jwplayerData['provider']) ? '"provider": "' . $jwplayerData['provider'] . '",' : '')
				. '"autostart": "' . ($autoplay ? 'true' : 'false') . '",'
				. '"stretching": "uniform",'
				. '"controlbar.position": "over",'
				. '"dock": false,'
				. '"skin": "' . $jwplayerData['skin'] . '",';
			$sJSON .= '"plugins": {';
			$pluginTexts = array();
			foreach ($jwplayerData['plugins'] as $plugin=>$options) {
				$pluginText = '"'.$plugin.'": {';
				$pluginOptionTexts = array();
				foreach ($options as $key=>$val) {
					$text = '"'.$key.'": ';
					if (startsWith($val, 'http://')
					|| startsWith($val, 'https://')) {
						$text .= $this->initJWPlayerURL($val, $asJSON);
					}
					else {
						$text .= '"'.$val.'"';
					}
					$pluginOptionTexts[] = $text;
				}
				$pluginText .= implode(',', $pluginOptionTexts);
				$pluginText .= '}';
				$pluginTexts[] = $pluginText;
			}
			$sJSON .= implode(',', $pluginTexts)
				. '}'	// end plugins
				. '}';
			
			$embed  = '<div id="'.$jwplayerData['playerId'].'"></div>'
				. '<script type="text/javascript">'
				. (empty($inAjaxResponse) ? 'wgAfterContentAndJS.push( function() {' : '')
				. '	$.getScript("'.$jwplayerData['jwplayerjs'].'", function() { jwplayer("'.$jwplayerData['playerId'].'").setup('.$sJSON.'); });'
				. (empty($inAjaxResponse) ? '});' : '')
				. '</script>';
		}

		return $asJSON ? $sJSON : $embed;
	}
	
	/**
	 * MediaWiki parser tries to linkify any URL it encounters.
	 * This method escapes URLs for use in JW Player to avoid this linkification.
	 * @param string $url
	 * @param boolean $useJSON
	 * @return string 
	 */
	protected function initJWPlayerURL($url, $useJSON) {
		if (!empty($useJSON)) {
			return '"' . $url . '"';
		}
		else {
			return 'decodeURIComponent("' . urlencode($url) . '")';  // when player embedded in action=render page, the file URL is automatically linkified. prevent this behavior
		}
	}
	
	/**
	 * @return string 
	 */
	protected function initGoogleIMAAdTag($cityShort='life') {
		global $wgDBname, $wgTitle;
		//@todo use logic in AdConfig.js to construct tag

		if ($cityShort) {
			$url = "http://ad.doubleclick.net/pfadx/wka.{$cityShort}/_{$wgDBname};sz=320x240;artid={$wgTitle->getArticleId()}";
			return $url;
		}
		
		return '';
	}

	public function isJWPlayerSupported(){
		switch( $this->mProvider ) {
			case self::V_YOUTUBE:
			case self::V_SCREENPLAY:
				return true;
			default:
				return false;
		}
	}

	public function getJWPlayerJSON( $width = 300, $autoplay = false, $cityShort='life', $height='' ){
		if ( $this->isJWPlayerSupported() ){
			$JSON = $this->getEmbedCode( $width, $autoplay, true, true, $cityShort, $height );
			return json_decode( $JSON, true );
		}
	}

	public function getThumbnailParams( $width ){

		global $wgExtensionsPath;

		$thumb = $wgExtensionsPath . '/wikia/VideoEmbedTool/images/vid_thumb.jpg';
		switch( $this->mProvider ) {
			case self::V_METACAFE:
				$thumb = 'http://www.metacafe.com/thumb/' . $this->mId . '.jpg';
				break;
			case self::V_YOUTUBE:
				$thumb = 'http://img.youtube.com/vi/' . $this->mId . '/0.jpg';
				break;
			case self::V_VIMEO:
				$file = @Http::get( "http://vimeo.com/api/clip/" . $this->mId . '.php', FALSE );
				if ($file) {
					$data = unserialize( $file );
					$thumb = trim( $data[0]["thumbnail_large"] );
				}
				break;
			case self::V_5MIN:
				break;
				/* todo test
				$file = @Http::get( "http://api.5min.com/video/" . $this->mId . '/info.xml', FALSE );
					if ($file) {
						$doc = new DOMDocument;
						@$doc->loadHTML( $file );
						if( $item = $doc->getElementsByTagName('item')->item( 0 ) ) {
							$thumb = trim( $item->getElementsByTagNameNS('media', 'thumbnail')->item(0)->getAttribute('url') );
						}
					}
				break;
				*/
			case self::V_SEVENLOAD:
			case self::V_MYVIDEO:
			case self::V_GAMEVIDEOS:
			case self::V_SOUTHPARKSTUDIOS: // no API
			case self::V_DAILYMOTION: // todo check if there is way to get thumbnail
				break;
			case self::V_BLIPTV:
				$thumb =  $this->getBlipTVData();
				$thumb = $thumb['thumbnailUrl'] ;
				break;
			case self::V_VIDDLER:
				$thumb =  "http://cdn-thumbs.viddler.com/thumbnail_2_".$this->getViddlerTrueID().".jpg";
				break;
			case self::V_HULU:
				$huluData = $this->getHuluData();
				$thumb = $huluData['thumbnailUrl'];
				break;
			case self::V_SCREENPLAY:
				$bitrateId = self::SCREENPLAY_MEDIUM_JPEG_BITRATE_ID;
				if (!empty($this->mData[3])) {
					$bitrateId = $this->mData[3];
				}
				$thumb = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$this->mId.'&bitrateid='.$bitrateId.'&vendorid='.self::$SCREENPLAY_VENDOR_ID.'&type=.jpg';
				break;
			case self::V_MOVIECLIPS:
				$thumb = $this->mData[0];
				break;
			case self::V_REALGRAVITY:
				$thumb = $this->mData[1];
				break;
			case self::V_WIKIAVIDEO:
				// not applicable
				break;
			default:
				break;
		}

		$height = round( $width / $this->getRatio() );
		return array(
			'width' => $width,
			'height' => $height,
			'thumb' => $thumb
		);
	}

	public function getThumbnailCode($width, $addCover = true) {

		$aParams = $this->getThumbnailParams( $width );

		$thumb = $aParams['thumb'];
		$height = $aParams['height'];
		$width = $aParams['width'];

		if ( '' != $thumb) {
			$image = "<img src=\"$thumb\" height=\"$height\" width=\"$width\" alt=\"\" />";
		} else {
			$image = '';
		}

		if (!empty($addCover)) {
	 		return "$image<div style=\"width: {$width}px; height: {$height}px; background: transparent url({$wgExtensionsPath}/wikia/Wysiwyg/fckeditor/editor/plugins/video/video.png) no-repeat 50% 50%; position: absolute; top: 0; left: 0\"><br /></div>";
		}
		else {
			return $image;
		}
	}

	function openShowVideo() {
		global $wgOut;
		$this->getContent();
		$this->load();

		$s = '<div id="file">';
		$s .= $this->getEmbedCode( 400);
		$s .= '</div>';

		$wgOut->addHTML( $s );
	}

	function showVideoInfoLine() {
		global $wgOut, $wgWikiaVideoProviders;
		$data = array(
			$this->mProvider,
			$this->mId
		);

		if ( is_array( $this->mData ) ){
			$data = array_merge($data, $this->mData);
		}
		$data = implode( ",", $data ) ;
		$url = self::getUrl( $data );
		$provider = $wgWikiaVideoProviders[$this->mProvider];
		$purl = $this->getProviderUrl();
		$ratio = $this->getTextRatio();
		$link = '<a href="' . $url . '">' . $this->mTitle->getText() . '</a>';
		$s = '<div id="VideoPageInfo">' . wfMsgExt( 'wikiavideo-details', array( 'parsemag' ), $link, $ratio, $purl, $provider ) . '</div>';
		$wgOut->addHTML( $s );
	}
	
	private function getYoutubeData() {
		// do not connect from maintenance script
		// this is TEMPORARY until video migration is finish, afterwards this can be removed
		global $wgCommandLineMode;
		if ( $wgCommandLineMode ) return;

		// We are using a non-standard version of the API for 
		// getting details for a single video. This is because this
		// version returns a proper RSS feed. YouTube's recommended
		// version (https://gdata.youtube.com/feeds/api/videos/<id>) 
		// does not return a proper RSS feed, which means we can't use 
		// SimplePie to parse it!
		
		if (sizeof($this->mData) >= 6) {	// mData has mId, the four fields below, and maybe the "related" value
			// we already got the data
			return;
		}
		else {
			if (sizeof($this->mData) >= 2) {
				// mData could have mId (string), related (string), duration (int)
				// or mId (string), duration (int)
				// Truncate after mId (and related, if it exists)
				if (is_numeric($this->mData[1])) {
					// mData[1] is duration
					$this->mData = array_slice($this->mData, 0, 1);
				}
				else {
					// assume mData[1] is related and mData[2] is duration
					$this->mData = array_slice($this->mData, 0, 2);
				}
			}
		}
		
		$file = @Http::get( self::YOUTUBE_FEEDS_VIDEOS_URL."?vq=" . $this->mId, FILE_TEXT );
		if ($file) {
			$feed = new SimplePie();
			$feed->set_raw_data($file);
			$feed->init();
			$feed->handle_content_type();
			if ($feed->error()) {
				return;
			}

			foreach ($feed->get_items() as $key=>$item) {
				if ($item->get_id() == self::YOUTUBE_FEEDS_VIDEOS_URL.'/'.$this->mId) {
					if ($enclosure = $item->get_enclosure()) {
						// duration
						$duration = $enclosure->get_duration();
						$this->mData[] = $duration;

						// description
						$description = $enclosure->get_description();
						$this->mData[] = html_entity_decode($description);

						// hd?
						$hdTags = $item->get_item_tags(self::XMLNS_YT, 'hd');
						$this->mData[] = !empty($hdTags) ? 1 : 0;
						
						// noembed?
						$noembedTags = $item->get_item_tags(self::XMLNS_YT, 'noembed');
						$this->mData[] = !empty($noembedTags) ? 1 : 0;
					}
				}
			}
		}		
		
		return;
	}
	
	function getDuration() {
		switch ($this->mProvider) {
			case self::V_SCREENPLAY:
				if (sizeof($this->mData) >= 3) {
					return $this->mData[2];
				}
				break;
			case self::V_MOVIECLIPS:
				if (sizeof($this->mData) >= 2) {
					return $this->mData[1];
				}
				break;
			case self::V_REALGRAVITY:
				if (sizeof($this->mData) >= 3) {
					return $this->mData[2];
				}
				break;
			case self::V_YOUTUBE:
				$this->getYoutubeData();
				// mData either has mId (string), related (string), duration (int), description (string), hd (int), noembed (int)
				// or mId, duration, description, hd, noembed
				if (sizeof($this->mData) >= 6) {
					if (is_numeric($this->mData[2]) && $this->mData[2] > 0) {
						return $this->mData[2];
					} 	
				}
				elseif (sizeof($this->mData) >= 5) {
					if (is_numeric($this->mData[1]) && $this->mData[1] > 0) {
						return $this->mData[1];
					}
				}
				return '';
				break;
			default:
				// duration unknown
				
		}
		
		return null;
	}
	
	function getDescription() {
		switch ($this->mProvider) {
			case self::V_YOUTUBE:
				// mData either has mId (string), related (string), duration (int), description (string), hd (int), noembed (int)
				// or mId, duration, description, hd, noembed
				$this->getYoutubeData();
				if (sizeof($this->mData) >= 6) {
					if (!empty($this->mData[3])) {
						return $this->mData[3];
					} 	
				}
				elseif (sizeof($this->mData) >= 5) {
					if (!empty($this->mData[2])) {
						return $this->mData[2];
					}
				}
				return '';
				break;
			case self::V_SCREENPLAY:
				// no description
				break;
			case self::V_MOVIECLIPS:
				if (sizeof($this->mData) >= 3) {
					return $this->mData[2];
				}
				break;
			case self::V_REALGRAVITY:
				if (sizeof($this->mData) >= 4) {
					return $this->mData[3];
				} 
				break;
			default:
		}
		
		return null;
	}
	
}

global $wgWikiaVideoProviders;
$wgWikiaVideoProviders = array(
		VideoPage::V_GAMETRAILERS => 'gametrailers',
		VideoPage::V_GAMEVIDEOS => 'gamevideos',
		VideoPage::V_GAMESPOT => 'gamespot',
		VideoPage::V_MTVGAMES => 'mtvgames',
		VideoPage::V_5MIN => '5min',
		VideoPage::V_YOUTUBE => 'youtube',
		VideoPage::V_HULU => 'hulu',
		VideoPage::V_VEOH => 'veoh',
		VideoPage::V_FANCAST => 'fancast',
		VideoPage::V_IN2TV => 'in2tv',
		VideoPage::V_BLIPTV => 'bliptv',
		VideoPage::V_METACAFE => 'metacafe',
		VideoPage::V_SEVENLOAD => 'sevenload',
		VideoPage::V_VIMEO => 'vimeo',
		VideoPage::V_CLIPFISH => 'clipfish',
		VideoPage::V_MYVIDEO => 'myvideo',
		VideoPage::V_SOUTHPARKSTUDIOS => 'southparkstudios',
		VideoPage::V_DAILYMOTION => 'dailymotion',
		VideoPage::V_VIDDLER => 'viddler',
		VideoPage::V_SCREENPLAY => 'Screenplay, Inc.',
		VideoPage::V_MOVIECLIPS => 'MovieClips Inc.',
		VideoPage::V_REALGRAVITY => 'RealGravity'
		// don't need V_WIKIAVIDEO
		// don't need V_LOCALVIDEO
		);

class VideoHistoryList {
	var $mTitle;

        function __construct( $article ) {
		$this->mTitle = $article->mTitle;
        }

        public function beginVideoHistoryList() {
                global $wgOut, $wgUser;
                return Xml::element( 'h2', array( 'id' => 'filehistory' ), wfMsg( 'filehist' ) )
                        . Xml::openElement( 'table', array( 'class' => 'filehistory' ) ) . "\n"
                        . '<tr>'
			. '<th>&nbsp;</th>'
			. ( ( $wgUser->isAllowed( 'delete' ) || $wgUser->isAllowed( 'deleterevision' ) ) ? '<th>&nbsp;</th>' : '' )
                        . '<th>' . wfMsgHtml( 'filehist-datetime' ) . '</th>'
                        . '<th>' . wfMsgHtml( 'filehist-user' ) . '</th>'
                        . "</tr>\n";
        }

	public function videoHistoryLine( $iscur = false ) {
		global $wgOut, $wgUser, $wgLang;

		$dbr = wfGetDB( DB_SLAVE );
		$sk = $wgUser->getSkin();

		if ( $iscur ) {
			// load from current db
			$history = $dbr->select( 'image',
					array(
						'img_metadata',
						'img_name',
						'img_user',
						'img_user_text',
						'img_timestamp',
						'img_description',
						"'' AS ov_archive_name"
					     ),
					'img_name = ' . $dbr->addQuotes( VideoPage::getNameFromTitle( $this->mTitle ) ) .' OR img_name = ' . $dbr->addQuotes( $this->mTitle->getPrefixedText() ),
					__METHOD__
					);
			if ( 0 == $dbr->numRows( $history ) ) {
				return '';
			} else {
				$row = $dbr->fetchObject( $history );
				$user = $row->img_user;
				$usertext = $row->img_user_text;
				$url = VideoPage::getUrl( $row->img_metadata );

			        $q = array();
                                $q[] = 'action=delete';
				if( $wgUser->isAllowed('delete') || $wgUser->isAllowed('deleterevision') ) {
					$delete = '<td>' . $sk->makeKnownLinkObj( $this->mTitle,
							wfMsgHtml( 'filehist-deleteall' ),
							implode( '&', $q ) ) . '</td>';
				} else {
					$delete = '';
				}


				$line = '<tr>' . $delete . '<td>' . wfMsgHtml( 'filehist-current' ) . '</td><td><a href="' . $url . '" class="link-video" target="_blank">' . $wgLang->timeAndDate( $row->img_timestamp, true ) . '</a></td>' . '<td>';
				$line .= $sk->userLink( $user, $usertext ) . " <span style='white-space: nowrap;'>" . $sk->userToolLinks( $user, $usertext ) . "</span>";
				$line .= '</td></tr>';
				return $line;
			}
		} else {
			// load from old video db
			$history = $dbr->select( 'oldimage',
					array(
						'oi_metadata AS img_metadata',
						'oi_name AS img_name',
						'oi_user AS img_user',
						'oi_user_text AS img_user_text',
						'oi_timestamp AS img_timestamp',
						'oi_description AS img_description',
					     ),
					'oi_name = ' . $dbr->addQuotes( VideoPage::getNameFromTitle( $this->mTitle ) ) .' OR oi_name = ' . $dbr->addQuotes( $this->mTitle->getPrefixedText() ),
					__METHOD__,
					array( 'ORDER BY' => 'oi_timestamp DESC' )
					);
			$s = '';
			while( $row = $dbr->fetchObject( $history ) ) {
				$user = $row->img_user;
				$usertext = $row->img_user_text;
				$url = VideoPage::getUrl( $row->img_metadata );
			        $q = array();
                                $q[] = 'action=revert';
                                $q[] = 'oldvideo=' . urlencode( $row->img_timestamp );
                                $revert = $sk->makeKnownLinkObj( $this->mTitle,
                                        wfMsgHtml( 'filehist-revert' ),
                                        implode( '&', $q ) );

                                $q[0] = 'action=delete';
				if( $wgUser->isAllowed('delete') || $wgUser->isAllowed('deleterevision') ) {
					$delete = '<td>' . $sk->makeKnownLinkObj( $this->mTitle,
							wfMsgHtml( 'filehist-deleteone' ),
							implode( '&', $q ) ) . '</td>';
				} else {
					$delete = '';
				}

				$s .= '<tr>' . $delete . '<td>' . $revert . '</td><td><a href="' . $url . '" class="link-video" target="_blank">' . $wgLang->timeAndDate( $row->img_timestamp, true ) . '</a></td>' . '<td>';
				$s .= $sk->userLink( $user, $usertext ) . " <span style='white-space: nowrap;'>" . $sk->userToolLinks( $user, $usertext ) . "</span>";
				$s .= '</td></tr>';
			}
			return $s;
		}
	}

        public function endVideoHistoryList() {
                return "</table>\n";
        }
}

class VideoHTMLCacheUpdate extends HTMLCacheUpdate {

	function getToCondition() {
		$prefix = $this->getPrefix();
		switch ( $this->mTable ) {
			case 'pagelinks':
			case 'templatelinks':
			case 'redirect':
				return array(
						"{$prefix}_namespace" => $this->mTitle->getNamespace(),
						"{$prefix}_title" => $this->mTitle->getDBkey()
					    );
			case 'imagelinks':
				return array( 'il_to' => ':' . $this->mTitle->getDBkey() );
			case 'categorylinks':
				return array( 'cl_to' => $this->mTitle->getDBkey() );
		}
		throw new MWException( 'Invalid table type in ' . __CLASS__ );
	}
}

class VideoPageArchive extends PageArchive {

	function listFiles() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'filearchive',
				array(
					'fa_id',
					'fa_name',
					'fa_archive_name',
					'fa_storage_key',
					'fa_storage_group',
					'fa_size',
					'fa_width',
					'fa_height',
					'fa_bits',
					'fa_metadata',
					'fa_media_type',
					'fa_major_mime',
					'fa_minor_mime',
					'fa_description',
					'fa_user',
					'fa_user_text',
					'fa_timestamp',
					'fa_deleted' ),
				array( 'fa_name' => VideoPage::getNameFromTitle( $this->title ) ),
				__METHOD__,
				array( 'ORDER BY' => 'fa_timestamp DESC' ) );
		$ret = $dbr->resultObject( $res );
		return $ret;
	}

	function undelete( $timestamps, $comment = '', $fileVersions = array(), $unsuppress = false ) {
		global $wgUser;
		if(  $this->title->exists()) { // we currently restore only whole deleted videos, a restore link from log could take us here...
			return;
		}
		$dbw = wfGetDB( DB_MASTER );

		$conditions = array( 'fa_name' => VideoPage::getNameFromTitle( $this->title ) );

		$result = $dbw->select( 'filearchive', '*',
				$conditions,
				__METHOD__,
				array( 'ORDER BY' => 'fa_timestamp DESC' )
				);

		$insertBatch = array();
		$insertCurrent = false;
		$deleteIds = array();
		$archiveName = '';
		$first = true;

		while( $row = $dbw->fetchObject( $result ) ) {
			if( $first ) { // this is our new current revision
				$insertCurrent = array(
						'img_name'        => $row->fa_name,
						'img_size'        => $row->fa_size,
						'img_width'       => $row->fa_width,
						'img_height'      => $row->fa_height,
						'img_metadata'    => $row->fa_metadata,
						'img_bits'        => $row->fa_bits,
						'img_media_type'  => $row->fa_media_type,
						'img_major_mime'  => $row->fa_major_mime,
						'img_minor_mime'  => $row->fa_minor_mime,
						'img_description' => $row->fa_description,
						'img_user'        => $row->fa_user,
						'img_user_text'   => $row->fa_user_text,
						'img_timestamp'   => $row->fa_timestamp,
						'img_sha1'        => ''
						);
			} else { // older revisions, they could be even elder current ones from ancient deletions
				$insertBatch[] = array(
						'oi_name'         => $row->fa_name,
						'oi_archive_name' => $archiveName,
						'oi_size'         => $row->fa_size,
						'oi_width'        => $row->fa_width,
						'oi_height'       => $row->fa_height,
						'oi_bits'         => $row->fa_bits,
						'oi_description'  => $row->fa_description,
						'oi_user'         => $row->fa_user,
						'oi_user_text'    => $row->fa_user_text,
						'oi_timestamp'    => $row->fa_timestamp,
						'oi_metadata'     => $row->fa_metadata,
						'oi_media_type'   => $row->fa_media_type,
						'oi_major_mime'   => $row->fa_major_mime,
						'oi_minor_mime'   => $row->fa_minor_mime,
						'oi_deleted'      => $this->unsuppress ? 0 : $row->fa_deleted,
						'oi_sha1'         => '' );
			}
			$deleteIds[] = $row->fa_id;
			$first = false;
		}

		unset( $result );

		if ( $insertCurrent ) {
			$dbw->insert( 'image', $insertCurrent, __METHOD__ );
		}
		if ( $insertBatch ) {
			$dbw->insert( 'oldimage', $insertBatch, __METHOD__ );
		}
		if ( $deleteIds ) {
			$dbw->delete( 'filearchive',
					array( 'fa_id IN (' . $dbw->makeList( $deleteIds ) . ')' ),
						__METHOD__ );
					}

		// run parent version, because it uses a private function inside
		// files will not be touched anyway here, because it's not NS_FILE
		parent::undelete( $timestamps, $comment, $fileVersions, $unsuppress );

		return array('', '', '');
	}

}
