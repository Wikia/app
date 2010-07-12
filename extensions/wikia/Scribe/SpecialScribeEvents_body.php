<?php

class ScribeeventsSpecialPage extends SpecialPage {
    private $sep = null;
    var $mName = 'Scribeevents';
    var $mRights = 'scribeevents';

	function __construct() {
		parent::__construct( $this->mName, $this->mRights );
	}

	function execute($type = null, $limit = 0, $offset = "", $show = true) {
		global $wgRequest, $wgUser, $wgOut;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( $this->mRights ) ) {
			$this->displayRestrictionError();
			return;
		}

		wfLoadExtensionMessages( $this->mName );

		if ( is_null($type) ) {
			$type = $wgRequest->getVal('type', $type);
		}
		if (empty($limit) && empty($offset)) { 
            list( $limit, $offset ) = wfCheckLimits(20);
        }
        $this->sep = new ScribeeventsPage($this->mName, $type, $limit, $offset);
        
		if (!empty($show)) {
            $this->setHeaders();
        } else {
            // return data as array - not like <LI> list
            $this->sep->setShow(false);
        }
        $this->sep->showForm();
    }
    
    function getResult() { return $this->sep->getResult(); }
}

class ScribeeventsPage {
	private $data = array();
	private $mShow = true;
	var $mType = 0;
	var $mTypeTxt = null;
	var $mValidType = false;
	var $mPageTitle = "";
	var $mPageNS = 0;
	var $mTitle = "";

	function __construct($name, $type, $limit = 20, $offset = 0) { 
		$this->mName = $name;
		$this->mTypeTxt = $type;

		if ( !empty($type) ) {
			switch ( $type ) {
				case 'edit' 		: $this->mType = ScribeProducer::EDIT_CATEGORY_INT; break;
				case 'create' 		: $this->mType = ScribeProducer::CREATEPAGE_CATEGORY_INT; break;
				case 'delete' 		: $this->mType = ScribeProducer::DELETE_CATEGORY_INT; break;
				case 'undelete'		: $this->mType = ScribeProducer::UNDELETE_CATEGORY_INT; break;
			}
		}
		$this->mValidType = ( !is_null( $this->mType ) );
		$this->offset = $offset;
		$this->limit =  $limit;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
	}

	function linkParameters() { 
		$res = array();
		if ( $this->mValidType ) {
			$res = array('type' => $this->mTypeTxt);	
		}
		return $res; 
	}
	function setShow( $bool ) { $this->mShow = $bool; }

	function getPageHeader() { 
		return "";
	}

	public function getResult() { return $this->data; }

	function showForm() {
		global $wgOut;

        wfProfileIn( __METHOD__ );
		$wgOut->addHTML( $this->getPageHeader() );
		
		if ( $this->mValidType ) {
			$this->showResults();
		}
        wfProfileOut( __METHOD__ );
	}
	
	function showResults( ) {
		global $wgUser, $wgOut, $wgCityId, $wgLang, $wgContLang, $wgMemc, $wgStatsDB;

        wfProfileIn( __METHOD__ );
		$wgOut->setSyndicated( false );

		$num = 0;
		$key = wfMemcKey( "Scribeevents", intval($this->mType), $this->limit, $this->offset );
		$data = $wgMemc->get( $key );
		
		if ( empty($data) || 
			( isset($data) && ( 0 == intval($data['numrec'] ) ) ) 
		) {
			$where = array( 
				'wiki_id' 	=> $wgCityId,
			);
			if ( $this->mValidType && $this->mType > 0 ) {
				$where['event_type'] = $this->mType;
			}
						
			$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB ); 
			$oRes = $dbr->select(
				'events',
				array( 
					'wiki_id', 
					'page_id', 
					'rev_id', 
					'log_id', 
					'user_id', 
					'user_is_bot', 
					'page_ns', 
					'is_content', 
					'is_redirect', 
					'ip', 
					'rev_timestamp',
					'image_links',
					'video_links',
					'total_words',
					'rev_size',
					'wiki_lang_id',
					'wiki_cat_id',
					'event_type',
					'event_date',
					'media_type' 
				),
				$where,
				__METHOD__, 
				array(
					'SQL_CALC_FOUND_ROWS',
					'ORDER BY' => 'event_date DESC',
					'LIMIT' => $this->limit,
					'OFFSET' => $this->offset
				)
			);

			# nbr all records 
			$res = $dbr->query('SELECT FOUND_ROWS() as rowcount');
			$oRow = $dbr->fetchObject ( $res );
			$num = $oRow->rowcount;

			$data = array( 'numrec' => 0, 'rows' => array() );
			$loop = 0;
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data['rows'][ ] = array( 
					$oRow->page_id,
					$oRow->rev_id,
					$oRow->log_id, 
					$oRow->user_id, 
					$oRow->user_is_bot, 
					$oRow->page_ns, 
					$oRow->is_content, 
					$oRow->is_redirect, 
					$oRow->ip, 
					$oRow->rev_timestamp,
					$oRow->image_links,
					$oRow->video_links,
					$oRow->total_words,
					$oRow->rev_size,
					$oRow->wiki_lang_id,
					$oRow->wiki_cat_id,
					$oRow->event_type,
					$oRow->event_date,
					$oRow->media_type 
				);
				$data['order'][ ] = $oRow->rev_timestamp;
				$data['numrec']++;
			}
			
			$dbr->freeResult( $oRes );
			$wgMemc->set( $key, $data, 30 );
		} 

		$num = $this->outputResults( $wgUser->getSkin(), $data );

        wfProfileOut( __METHOD__ );
		return $num;
	}
	
	private function getRevisionFromArchive($page_id, $rev_id) {
		wfProfileIn( __METHOD__ );

		$result = false;
		$dbr = wfGetDB( DB_SLAVE );

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

		$oRow = $dbr->selectRow( 
			'archive', 
			$fields, 
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$result = $oRow;
		}
		
		wfProfileOut( __METHOD__ );
		return $result;
	}	
	
	public function outputResults( $skin, $data ) {
		global $wgContLang, $wgOut;

        wfProfileIn( __METHOD__ );

		$num = 0;		
		$html = array();
		if ( $this->mShow ) {
			$wgOut->addHTML( XML::openElement( 'div', array('class' => 'mw-spcontent') ) );
		}	

		if ( isset($data) && $data['numrec'] > 0 ) {
			$num = $data['numrec'];
			
			if ( $this->mShow ) {
				$html[] = XML::openElement( 'ol', array('start' => $this->offset + 1, 'class' => 'special' ) );
			}

			$loop = 0; $skip = 0;
			foreach ( $data['order'] as $key => $ordered ) {
				# check loop
				list( 
					$page_id, 
					$rev_id, 
					$log_id, 
					$user_id, 
					$user_is_bot, 
					$page_ns, 
					$is_content, 
					$is_redirect,
					$ip, 
					$rev_timestamp, 
					$image_links, 
					$video_links, 
					$total_words,
					$rev_size,
					$wiki_lang_id,
					$wiki_cat_id,
					$event_type,
					$event_date,
					$media_type
				) = $data['rows'][$key];	
					
				$oTitle = Title::newFromId( $page_id );
				$page_url = "";
				if ( is_object($oTitle) ) {
					$page_url = $oTitle->getLocalURL();
				} else {
					$archive = $this->getRevisionFromArchive($page_id, $rev_id);
					if ( is_object($archive) ) {
						$oTitle = Title::makeTitle( $archive->page_namespace, $archive->page_title );
						$page_url = $oTitle->getLocalURL();
					}
				}
				if (empty($this->mShow)) {
					$res = "";
					$this->data[$key] = array();
				} else {
					$addInfo = array();
					if ( $page_url ) {
						$res = wfSpecialList( Xml::openElement( 'a', array('href' => $page_url) ) . $page_url . Xml::closeElement( 'a' ), "" );
					} else {
						$res = "Page not found ( page_id: " .  $page_id . ", log_id: $log_id ) ";
					}
					if ( $rev_id > 0 ) 
						$addInfo[] = "Revision: $rev_id";
					if ( $log_id > 0 ) 
						$addInfo[] = "Log ID from RC: $log_id";
					$oUser = User::newFromID($user_id);
					if ( $oUser ) {
						$addInfo[] = "User: " . $oUser->getName() . " (uid: $user_id)";
					} else {
						$addInfo[] = "Uid: $user_id";
					}
					$addInfo[] = "user is bot: $user_is_bot";
					$addInfo[] = "page is content: $is_content";
					$addInfo[] = "page is redirect: $is_redirect";
					$addInfo[] = "user IP: $ip"; 
					$addInfo[] = "revision TS: $rev_timestamp"; 
					$addInfo[] = "number of image links: $image_links";
					$addInfo[] = "number of video: $video_links";
					$addInfo[] = "words: $total_words";
					$addInfo[] = "size: $rev_size";
					$addInfo[] = "lang ID: $wiki_lang_id";
					$addInfo[] = "cat ID: $wiki_cat_id";
					$addInfo[] = "event date: $event_date";
					
					$type = "";
					switch ( $event_type ) {
						case ScribeProducer::EDIT_CATEGORY_INT			: $type = ScribeProducer::EDIT_CATEGORY; break;
						case ScribeProducer::CREATEPAGE_CATEGORY_INT 	: $type = ScribeProducer::CREATEPAGE_CATEGORY; break;
						case ScribeProducer::DELETE_CATEGORY_INT 		: $type = ScribeProducer::DELETE_CATEGORY; break;
						case ScribeProducer::UNDELETE_CATEGORY_INT		: $type = ScribeProducer::UNDELETE_CATEGORY; break;
					}
					$addInfo[] = "event type: $type";

					$mtype = ' - ';
					switch ( $media_type ) {
						case 1 : $mtype = MEDIATYPE_BITMAP; break;
						case 2 : $mtype = MEDIATYPE_DRAWING; break;
						case 3 : $mtype = MEDIATYPE_AUDIO; break;
						case 4 : $mtype = MEDIATYPE_VIDEO; break;
						case 5 : $mtype = MEDIATYPE_MULTIMEDIA; break;
						case 6 : $mtype = MEDIATYPE_OFFICE; break;
						case 7 : $mtype = MEDIATYPE_TEXT; break;
						case 8 : $mtype = MEDIATYPE_EXECUTABLE; break;
						case 9 : $mtype = MEDIATYPE_ARCHIVE; break;
					}
					$addInfo[] = "media type (for NS_FILE): $mtype ($media_type)";						
					
					$html[] = $this->mShow ? Xml::openElement( 'li' ) . $res . "<br />" . implode("<br />", $addInfo) . Xml::closeElement( 'li' ) : "";
				}
				$loop++;
			}

			$num = $num - $skip;

			if( $this->mShow ) {
				$html[] = XML::closeElement( 'ol' );
			}

		}

		# Top header and navigation
		if ( $this->mShow ) {
			$wgOut->addHTML( '<p>' . wfMsgExt('scribeeventsrecords', array(), $num) . '</p>' );
			if( $num > 0 ) {
				$wgOut->addHTML( '<p>' . wfShowingResults( $this->offset, $num ) . '</p>' );
				# Disable the "next" link when we reach the end
				$paging = wfViewPrevNext( 
					$this->offset, 
					$this->limit, 
					$wgContLang->specialPage( $this->mName ), 
					wfArrayToCGI( $this->linkParameters() ), 
					( $num < $this->limit ) 
				);
				$wgOut->addHTML( '<p>' . $paging . '</p>' );
			} else {
				$wgOut->addHTML( XML::closeElement( 'div' ) );
				return;
			}
		}

		$html = $this->mShow ? implode( '', $html ) : $wgContLang->listToText( $html );
		$wgOut->addHTML( $html );
		
		# Repeat the paging links at the bottom
		if( $this->mShow ) {
			$wgOut->addHTML( '<p>' . $paging . '</p>' );
		}

		$wgOut->addHTML( XML::closeElement( 'div' ) );
		
        wfProfileOut( __METHOD__ );
		return $num;
	}
}
