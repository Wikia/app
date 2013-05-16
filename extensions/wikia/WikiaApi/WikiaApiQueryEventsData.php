<?php

/**
 * WikiaApiQueryEventsData
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 */

global $IP;  // This is weird but necessary for unit tests
require_once( $IP . '/lib/vendor/simplehtmldom/simple_html_dom.php' );

class WikiaApiQueryEventsData extends ApiQueryBase {

	const
		REGEX = '@<(?P<tag>%s)(?P<parameters>\s[^>]+)?(\s*/?>)|((.*)</(?P=tag)>)@xsi',
		REGEX_PARAMS = '@(?P<name>\w+)\s*=\s*((?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)|(?P<value_unquoted>[^\s"\']+?)(?:\s+|$))@xsi';

	private
		$mPageId		= false,
		$mLogid			= false,
		$mRevId 		= false,
		$mDetails		= false,
		$mTimestamp		= false,
		$mSize 			= false,
		$mIsNew			= false,
		$mCityId		= 0,
		$mTitle			= null,
		$mContent		= '';
	private
		$mediaNS = array(NS_IMAGE, NS_FILE);

	private $stripTags = array(
		"/\{\{#dpl(.*)\}\}/siU",
		"/\{\{#dplchapter(.*)\}\}/siU",
		"/<(dpl|dynamicpagelist)(.*)>(.*)<\/(dpl|dynamicpagelist)>/siU",
		"/<(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)(.*)>(.*)<\/(youtube|gvideo|aovideo|aoaudio|wegame|tangler|gtrailer|nicovideo|ggtube)>/siU",
		"/<(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet|gallery)(.*)>(.*)<\/(inputbox|widget|googlemap|imagemap|poll|rss|math|googlespreadsheet|gallery)>/siU",
	);

	/**
	 * constructor
	 */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, "");
	}

	private function getRevisionCount() {
		wfProfileIn( __METHOD__ );
		$this->mRevId = 0;
		if ( isset($this->params['revid']) ) {
			$this->mRevId = intval($this->params['revid']);
		}
		$count = $this->mRevId > 0;
		wfProfileOut( __METHOD__ );
		return $count;
	}

	private function getPageCount() {
		wfProfileIn( __METHOD__ );
		$this->mPageId = 0;
		if ( isset($this->params['pageid']) ) {
			$this->mPageId = intval($this->params['pageid']);
		}
		$count = $this->mPageId > 0;
		wfProfileOut( __METHOD__ );
		return $count;
	}

	private function getLoggingCount() {
		wfProfileIn( __METHOD__ );
		$this->mLogid = 0;
		if ( isset($this->params['logid']) ) {
			$this->mLogid = intval($this->params['logid']);
		}
		$count = $this->mLogid > 0;
		wfProfileOut( __METHOD__ );
		return $count;
	}

	private function getDetailsCount() {
		wfProfileIn( __METHOD__ );
		$this->mDetails = false;
		if ( isset($this->params['details']) ) {
			$this->mDetails = (bool)$this->params['details'];
		}
		wfProfileOut( __METHOD__ );
		return $this->mDetails === true;
	}

	private function getArchivePage($oRC) {
		wfProfileIn( __METHOD__ );

		if ( empty($this->mPageId) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !is_object($oRC) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = $this->getDB();

		$fields = array(
			'ar_namespace as page_namespace',
			'ar_title as page_title',
			'ar_comment as rev_comment',
			'ar_user as rev_user',
			'ar_user_text as rev_user_text',
			'ar_timestamp as rev_timestamp',
			'ar_minor_edit as rev_minor_edit',
			'ar_rev_id as rev_id',
			'ar_text_id as rev_text_id',
			'ar_len as rev_len',
			'ar_page_id as page_id'
		);

		$this->profileDBIn();
		$oRow = $db->selectRow(
			'archive',
			$fields,
			array(
				'ar_title'		=> $oRC->getAttribute('rc_title'),
				'ar_namespace'	=> $oRC->getAttribute('rc_namespace'),
				'ar_page_id'	=> $this->mPageId
			),
			__METHOD__,
			array(
				'ORDER BY' => 'ar_timestamp desc'
			)
		);
		$this->profileDBOut();

		$result = false;
		if ( is_object($oRow) && isset($oRow) && ( $oRow->page_id == $this->mPageId ) ) {
			$rc_user_id = $oRC->getAttribute('rc_user');
			$rc_user_text = $oRC->getAttribute('rc_user_text');
			if ( isset($rc_user_id) ) {
				$oRow->rev_user = $rc_user_id;
			}
			if ( isset($rc_user_text) ) {
				$oRow->rev_user_text = $rc_user_text;
			}
			$result = $oRow;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function getRecentchangePage($oRC) {
		wfProfileIn( __METHOD__ );

		if ( empty($this->mPageId) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !is_object($oRC) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = $this->getDB();

		$fields = array(
			'rc_namespace as page_namespace',
			'rc_title as page_title',
			'rc_comment as rev_comment',
			'rc_user as rev_user',
			'rc_user_text as rev_user_text',
			'rc_timestamp as rev_timestamp',
			'rc_minor as rev_minor_edit',
			'rc_cur_id as rev_id',
			'0 as rev_text_id',
			'rc_new_len as rev_len',
			$this->mPageId . ' as page_id'
		);

		$this->profileDBIn();
		$oRow = $db->selectRow(
			'recentchanges',
			$fields,
			array(
				'rc_title'		=> $oRC->getAttribute('rc_title'),
				'rc_namespace'	=> $oRC->getAttribute('rc_namespace'),
				'rc_logid'		=> $oRC->getAttribute('rc_logid'),
			),
			__METHOD__,
			array(
				'ORDER BY' => 'rc_timestamp desc'
			)
		);
		$this->profileDBOut();

		$result = false;
		if ( is_object($oRow) && isset($oRow) && ( $oRow->page_id == $this->mPageId ) ) {
			$rc_user_id = $oRC->getAttribute('rc_user');
			$rc_user_text = $oRC->getAttribute('rc_user_text');
			if ( isset($rc_user_id) ) {
				$oRow->rev_user = $rc_user_id;
			}
			if ( isset($rc_user_text) ) {
				$oRow->rev_user_text = $rc_user_text;
			}
			$result = $oRow;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function getLoggingArchivePage() {
		wfProfileIn( __METHOD__ );

		if ( empty($this->mPageId) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( empty($this->mLogid) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = $this->getDB();

		$fields = array(
			'log_namespace as page_namespace',
			'log_title as page_title',
			'log_comment as rev_comment',
			'log_user as rev_user',
			'\'\' as rev_user_text',
			'log_timestamp as rev_timestamp',
			'ar_minor_edit as rev_minor_edit',
			'ar_minor_edit as rev_id',
			'ar_text_id as rev_text_id',
			'ar_len as rev_len',
			$this->mPageId . ' as page_id'
		);

		$this->profileDBIn();
		$oRow = $db->selectRow(
			array('archive', 'logging'),
			$fields,
			array(
				'log_title = ar_title',
				'log_namespace = ar_namespace',
				'ar_page_id' => $this->mPageId,
				'log_id' => $this->mLogid
			),
			__METHOD__,
			array(
				'ORDER BY' => 'log_timestamp DESC, ar_timestamp DESC'
			)
		);
		$this->profileDBOut();

		$result = false;
		if ( is_object($oRow) ) {
			$oUser = User::newFromId($oRow->rev_user);
			if ( is_object($oUser) ) {
				$oRow->rev_user_text = $oUser->getName();
			}
			$result = $oRow;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function getRevisionFromArchive() {
		wfProfileIn( __METHOD__ );

		$result = false;
		$db = $this->getDB();

		$fields = array(
			'ar_namespace as page_namespace',
			'ar_title as page_title',
			'ar_comment as rev_comment',
			'ar_user as rev_user',
			'ar_user_text as rev_user_text',
			'ar_timestamp as rev_timestamp',
			'ar_minor_edit as rev_minor_edit',
			'ar_rev_id as rev_id',
			'ar_text_id as rev_text_id',
			'ar_len as rev_len',
			'ar_page_id as page_id',
			'ar_page_id as rev_page',
			'ar_deleted as rev_deleted',
			'0 as rev_parent_id'
		);

		$conditions = array(
			'ar_page_id'	=> $this->mPageId ,
			'ar_rev_id'		=> $this->mRevId
		);

		$this->profileDBIn();
		$oRow = $db->selectRow(
			'archive',
			$fields,
			$conditions,
			__METHOD__
		);
		$this->profileDBOut();
		if ( is_object($oRow) ) {
			$result = $oRow;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function getRevisionFromLog() {
		wfProfileIn( __METHOD__ );

		$this->addTables   ( 'logging' );
		$this->addFields   ( 'recentchanges.*' );
		$this->addTables   ( 'recentchanges' );
		$this->addWhere    ( 'log_id = rc_logid' );
		$this->addWhere    ( 'log_title = rc_title' );
		$this->addWhere    ( 'log_namespace = rc_namespace' );
		$this->addWhereFld ( 'log_id', $this->mLogid );

		$res = $this->select(__METHOD__);

		$count = 0;
		$oRC = false;
		$db = $this->getDB();
		if ( $row = $db->fetchObject($res) ) {
			$oRC = RecentChange::newFromRow( $row );
		}
		$db->freeResult($res);

		$res = ( is_object($oRC) ) ? $this->getArchivePage($oRC) : false;

		if ( empty($res) && is_object($oRC) ) {
			$res = $this->getRecentchangePage($oRC);
		}

		if ( empty($res) && !is_object($oRC) ) {
			$res = $this->getLoggingArchivePage();
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	private function getRevisionFromPage() {
		wfProfileIn( __METHOD__ );
		$this->addTables	( 'revision' );
		$this->addFields	( 'page_id' );
		$this->addFields	( Revision::selectPageFields() );
		$this->addFields	( Revision::selectFields() );
		$this->addTables	( 'page' );
		$this->addWhere		( 'page_id = rev_page' );
		$this->addWhereFld	( 'rev_id', $this->mRevId );
		$this->addWhereFld	( 'page_id', $this->mPageId );

		$result = false;
		$res = $this->select(__METHOD__);
		$db = $this->getDB();
		if ( $oRow = $db->fetchObject($res) ) {
			if ( is_object($oRow) ) {
				$result = $oRow;
			}
		}
		$db->freeResult($res);

		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function checkIsNew($archive = 0) {
		wfProfileIn( __METHOD__ );

		$db = $this->getDB();
		$this->profileDBIn();
		if ( empty($archive) ) {
			$oRow = $db->selectRow(
				'revision',
				'rev_id',
				array(
					"rev_id < '{$this->mRevId}'",
					'rev_page' => $this->mPageId,
				),
				__METHOD__
			);
		} else {
			$oRow = $db->selectRow(
				'archive',
				'ar_rev_id as rev_id',
				array(
					"ar_rev_id < '{$this->mRevId}'",
					'ar_page_id' => $this->mPageId,
				),
				__METHOD__
			);
		}
		$this->profileDBOut();
		$this->mIsNew = ( isset( $oRow->rev_id ) ) ? false : true;

		wfProfileOut( __METHOD__ );
		return intval($this->mIsNew);
	}

	public function execute() {
		global $wgCityId, $wgUser, $wgTheSchwartzSecretToken;
		wfProfileIn( __METHOD__ );

		$mStartTime = $this->_get_microtime();
		# extract request params
		$this->mCityId = $wgCityId;
		$this->params = $this->extractRequestParams(false);

		if( ! ( isset($this->params[ "token" ] ) && $this->params[ "token" ] === $wgTheSchwartzSecretToken ) ) {
			if (!$wgUser->isAllowed('scribeevents')) {
				$this->dieUsageMsg(array('readrequired'));
			}
		}

		// Error results should not be cached
		$this->getMain()->setCacheMaxAge(0);

		# check "pageid" param
		$pageCount = $this->getPageCount();

		# check "revid" param
		$revCount = $this->getRevisionCount();

		# check "logid" param
		$logCount = $this->getLoggingCount();

		# check "details" param
		$showDetails = $this->getDetailsCount();

		if ( $revCount === 0 && $pageCount === 0 && $logCount == 0 ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( $pageCount == 0 ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The pageid parameter can not be empty', 'pageid');
		}

		if ( $logCount > 0 && $revCount > 0 ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The logid parameter may not be used with the revid parameter', 'logid');
		}

		if ( $pageCount > 0 && ( $revCount == 0 && $logCount == 0 ) ) {
			wfProfileOut( __METHOD__ );
			$this->dieUsage('The pageid parameter may not be used without the revid= or logid= parameter', 'logid');
		}

		# if logids is set
		$deleted = 0;
		if ( $logCount > 0 ) {
			$oRow = $this->getRevisionFromLog();
			$deleted = 1;
			if ( $oRow === false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		} else {
			$oRow = $this->getRevisionFromPage();
			if ( $oRow === false ) {
				$oRow = $this->getRevisionFromArchive();
				if ( $oRow === false ) {
					wfProfileOut( __METHOD__ );
					return false;
				}
				$oRow->is_archive = 1;
			}
		}

		$vals = $this->extractRowInfo($oRow, $deleted);

		$details = array();
		if ( $showDetails ) {
			$details = $this->getDetailsInfo( $oRow );
		}

		$mEndTime = $this->_get_microtime();
		$pageInfo = array(
			'id' => $oRow->page_id,
			'title' => $oRow->page_title,
			'namespace' => $oRow->page_namespace,
			'lctitle' => mb_strtolower( $oRow->page_title ),
			'latest' => intval($vals['page_latest']),
			'parsed' => bcsub($mEndTime, $mStartTime, 4)
		);

		$this->getResult()->setIndexedTagName($vals, 'events');
		$this->getResult()->addValue('query', 'page', $pageInfo);
		$this->getResult()->addValue('query', 'revision', $vals);

		if ( $showDetails ) {
			$this->getResult()->setIndexedTagName($details, 'details');
			$this->getResult()->addValue('query', 'details', $details);
		}

		wfProfileOut( __METHOD__ );
	}

	private function _get_user_ip($user_id, $page_title, $page_namespace) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		$db = $this->getDB();

		$key = __METHOD__ . ":rec:" . $user_id . ":" .md5($page_title.$page_namespace) . "\n";
		$oRow = $wgMemc->get(md5($key));

		if ( empty($oRow) ) {
			$this->profileDBIn();
			$oRow = $db->selectRow(
				'recentchanges',
				'rc_ip',
				array(
					'rc_user'	   => $user_id,
					'rc_title'     => $page_title,
					'rc_namespace' => $page_namespace
				),
				__METHOD__,
				array(
					'ORDER BY' => 'rc_id DESC'
				)
			);
			$this->profileDBOut();
			$wgMemc->set($key, $oRow, 60*60);
		}

		$ip = '';
		if ( is_object($oRow) && isset($oRow->rc_ip) ) {
			$ip = $oRow->rc_ip;
		}

		if ( empty($ip) ) {
			$key = __METHOD__ . ":cu:" . intval($user_id);
			$oRow = $wgMemc->get(md5($key));

			if ( empty($oRow) ) {
				$this->profileDBIn();
				$oRow = $db->selectRow(
					'cu_changes',
					'cuc_user, cuc_ip, cuc_timestamp',
					array(
						'cuc_user'	=> $user_id
					),
					__METHOD__,
					array(
						'ORDER BY' => 'cuc_user desc, cuc_ip desc, cuc_timestamp desc'
					)
				);
				$this->profileDBOut();
				$wgMemc->set($key, $oRow, 60*60);
			}

			$ip = '';
			if ( is_object($oRow) && isset($oRow->cuc_ip) ) {
				$ip = $oRow->cuc_ip;
			}
		}

		wfProfileOut( __METHOD__ );
		return $ip;
	}

	private function _user_is_bot($user_text) {
		$user_is_bot = false;
		$oUser = User::newFromName($user_text);
		if ( $oUser instanceof User ) {
			$user_is_bot = $oUser->isAllowed( 'bot' );
		}
		return $user_is_bot;
	}

	private function _revision_is_redirect() {
		$titleObj = Title::newFromRedirect( $this->mContent );
		$rev_is_redirect = is_object($titleObj) ;
		return $rev_is_redirect;
	}

	private function _revision_is_content() {
		global $wgEnableBlogArticles;
		$is_content_ns = 0;
		if ( $this->mTitle instanceof Title ) {
			$is_content_ns = $this->mTitle->isContentPage();
			/*if ( empty($is_content_ns) && $wgEnableBlogArticles ) {
				$is_content_ns = (in_array($this->mTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)));
			}*/
		}
		return (int) $is_content_ns;
	}

	private function _make_links() {
		$links = array(
			'image' => 0,
			'video' => 0
		);

		$content = $this->mContent;
		$oArticle = Article::newFromId($this->mPageId);

		if ( $oArticle instanceof Article ) {

			if (!empty($this->stripTags)) {
				/* skip some special tags  */
				foreach ($this->stripTags as $id => $tag) {
					$content = preg_replace($tag, '', $content);
				}
			}

			$content = str_replace("{{", "", $content);
			global $wgParser;
			$wgParser->clearTagHooks();
			$editInfo = $oArticle->prepareTextForEdit( $content, $this->mRevId );
			$images = $editInfo->output->getImages();
			if ( !empty($images) ) {
				foreach ($images as $iname => $dummy) {
					if ( substr($iname, 0, 1) == ':' ) {
						$links['video']++;
					} else {
						$links['image']++;
					}
				}
			}
		}
		return $links;
	}

	private function extractRowInfo( $oRow, $deleted = 0 ) {
		wfProfileIn( __METHOD__ );

		$vals = array ();
		if ( $deleted == 0 ) {
			$oRevision = new Revision($oRow);
			if ( isset($oRow->is_archive) && ($oRow->is_archive == 1) ) {
				$this->mTitle = Title::makeTitle( $oRow->page_namespace, $oRow->page_title );
			} else {
				$this->mTitle = $oRevision->getTitle();
			}
			$this->mContent = $oRevision->getText( Revision::FOR_THIS_USER );

			# revision id
			$vals['revid'] = intval($oRevision->getId());
			# username
			$vals['username'] = $oRevision->getUserText();
			# user id
			$vals['userid'] = $oRevision->getUser();
			# user ip
			$vals['user_ip'] = ( IP::isIPAddress($vals['username']) ) ? $vals['username'] : $this->_get_user_ip($vals['userid'], $oRow->page_title, $oRow->page_namespace);
			# user is bot
			$vals['userisbot'] = intval( $this->_user_is_bot( $vals['username'] ) );
			# is new
			$is_archive = isset($oRow->is_archive);
			$vals['isnew'] = $this->checkIsNew($is_archive);
			# timestamp
			$vals['timestamp'] = wfTimestamp( TS_DB, $oRevision->getTimestamp() );
			$vals['date'] = gmdate( 'Y-m-d', wfTimestamp( TS_UNIX, $oRevision->getTimestamp() ) );
			# size
			$vals['size'] = intval($oRevision->getSize());
			#words
			$vals['words'] = str_word_count( $this->mContent );
			# revision is redirect
			$vals['isredirect'] = intval( $this->_revision_is_redirect() );
			# revision is content
			$vals['iscontent'] = intval( $this->_revision_is_content() );
			# is deleted
			$vals['isdeleted'] = $deleted;
			# links
			$links = $this->_make_links();
			$vals['imagelinks'] = $links['image'];
			$vals['video'] = $links['video'];
		} else {
			$this->mTitle = Title::makeTitle( $oRow->page_namespace, $oRow->page_title );
			# revision id
			$vals['revid'] = intval($oRow->rev_id);
			# username
			$vals['username'] = $oRow->rev_user_text;
			# user id
			$vals['userid'] = intval($oRow->rev_user);
			# user ip
			$vals['user_ip'] = ( IP::isIPAddress($vals['username']) ) ? $vals['username'] : $this->_get_user_ip($vals['userid'], $oRow->page_title, $oRow->page_namespace);
			# user is bot
			$vals['userisbot'] = intval( $this->_user_is_bot( $vals['username'] ) );
			# is new
			$vals['isnew'] = 0;
			# timestamp
			$vals['timestamp'] = wfTimestamp( TS_DB, $oRow->rev_timestamp );
			# size
			$vals['size'] = intval( $oRow->rev_len );
			# words
			$vals['words'] = 0;
			# revision is redirect
			$vals['isredirect'] = 0;
			# revision is content
			$vals['iscontent'] = intval( $this->_revision_is_content() );
			# is deleted
			$vals['isdeleted'] = $deleted;
			# links
			$vals['imagelinks'] = 0;
			$vals['video'] = 0;
		}
		$vals['media_type'] = $this->getMediaType($oRow->page_namespace);
		$vals['page_latest'] = $this->mTitle->getLatestRevID();

		wfProfileOut( __METHOD__ );
		return $vals;
	}

	private function getMediaType($ns) {
		wfProfileIn( __METHOD__ );
		$result = 0;

		$oTitle = $this->mTitle;
		if ( in_array($ns, $this->mediaNS) ) {
			$mediaType = MEDIATYPE_UNKNOWN;
			$oLocalFile = LocalFile::newFromTitle( $oTitle, RepoGroup::singleton()->getLocalRepo() );
			if ( $oLocalFile instanceof LocalFile ) {
				$mediaType = $oLocalFile->getMediaType();
				if ( empty($mediaType) ) {
					$mediaType = MEDIATYPE_UNKNOWN;
				}
			}
			switch ( $mediaType ) {
				case MEDIATYPE_BITMAP		: $result = 1; break;
				case MEDIATYPE_DRAWING		: $result = 2; break;
				case MEDIATYPE_AUDIO		: $result = 3; break;
				case MEDIATYPE_VIDEO		: $result = 4; break;
				case MEDIATYPE_MULTIMEDIA	: $result = 5; break;
				case MEDIATYPE_OFFICE		: $result = 6; break;
				case MEDIATYPE_TEXT			: $result = 7; break;
				case MEDIATYPE_EXECUTABLE	: $result = 8; break;
				case MEDIATYPE_ARCHIVE		: $result = 9; break;
				default 					: $result = 1; break;
			}
		}
		wfProfileOut( __METHOD__ );

		return $result;
	}

	private function _get_metrics_types() {
		global $wgMemc;

		$key = "metrics:types:v1";
		$metricsTypes = $wgMemc->get( $key );
		if ( empty( $metricsTypes ) ) {
			$dbr = 	wfGetDB( DB_SLAVE, array(), 'metrics' );
			$oRes = $dbr->select(
				array( 'event_type' ),
				array( 'type_id, type_name' ),
				array(),
				__METHOD__,
				array( 'ORDER BY' => 'type_id')
			);
			$metricsTypes = array();
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				$metricsTypes[ $oRow->type_id ] = $oRow->type_name;
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $key, $metricsTypes, 60*60 );
		}

		return $metricsTypes;
	}

	private function getDetailsInfo( $oRow ) {
		$details = array();

		if ( empty($this->mContent) ) {
			return $details;
		}

		/* use SimpleHTMLDom extensions here ( include in lib/vendor/simplehtmldom ) */
		$oHtmlDom = str_get_html( $this->mContent );

		$metricsTypes = $this->_get_metrics_types();

		foreach ( $metricsTypes as $id => $name ) {
			$res = 0;
			switch ( $id ) {
				case 1: /* mainpage */
					$res = $this->_is_main_page();
					break;
				case 2: /* gallery */
					if ( !empty( $oHtmlDom ) ) {
						$gallery = count( $oHtmlDom->find("gallery") );
						$slider = count( $oHtmlDom->find("gallery[type=slider]") );
						$slideshow = count( $oHtmlDom->find("gallery[type=slideshow]") );
						$res = $gallery - $slider - $slideshow;
						if ( $res < 0 ) $res = 0;
					}
					break;
				case 3: /* slider */
					if ( !empty( $oHtmlDom ) ) {
						$res = count( $oHtmlDom->find("gallery[type=slider]") );
					}
					break;
				case 4: /* slideshow */
					if ( !empty( $oHtmlDom ) ) {
						$res = count( $oHtmlDom->find("gallery[type=slideshow]") );
					}
					break;
				case 5: /* mainpage tag */
					if ( !empty( $oHtmlDom ) ) {
						$left_column = count( $oHtmlDom->find("mainpage-leftcolumn-start") );
						$end_column = count( $oHtmlDom->find("mainpage-endcolumn") );
						$right_column = count( $oHtmlDom->find("mainpage-rightcolumn-start") );
						$res = $left_column + $end_column + $right_column;
					}
					break;
				default:
					break;
			}

			if ( $res > 0 ) {
				$details[] = array( 'id' => $id, 'name' => $name, 'count' => $res );
			}
		}

		return $details;
	}

	private function _get_microtime() {
		list($utime, $time) = explode(" ", microtime());
		return ((float)$utime + (float)$time);
	}

	private function _is_main_page() {
		$is_main_page = $this->mTitle->getArticleId() == Title::newMainPage()->getArticleId() && $this->mTitle->getArticleId() != 0;
		return intval($is_main_page);
	}

	public function getAllowedParams() {
		return array (
			'pageid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			),
			'revid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			),
			'logid' => array (
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_ISMULTI => false
			),
			'token'	=> array (
				ApiBase :: PARAM_TYPE => 'string',
				ApiBase :: PARAM_ISMULTI => false
			),
			'details' => array (
				ApiBase :: PARAM_TYPE => 'boolean',
				ApiBase :: PARAM_ISMULTI => false
			),
		);
	}

	public function getParamDescription() {
		return array (
			'pageid' 	=> 'Identifier of page',
			'revid' 	=> 'Identifier of revision',
			'logid' 	=> 'Identifier of log (from logging)',
			'token'		=> 'Used for internal communication',
			'details'	=> 'Show event details'
		);
	}

	public function getDescription() {
		return array (
			'Get informations needed to fill events table.'
		);
	}

	public function getExamples() {
		return array (
			'Get information about page and revision for page_id and rev_id',
			'  api.php?action=query&prop=wkevinfo&pageid=28734&revid=120844&meta=siteinfo&siprop=wikidesc',
			'Get information for removed page (page_id and log_id needed)',
			'  api.php?action=query&prop=wkevinfo&pageid=28712&logid=14235&meta=siteinfo&siprop=wikidesc',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryEventsData.php 48642 2010-06-09 16:21:38Z moli $';
	}
};
