<?php

class StaffLog extends SpecialPage
{
	var $request;
	function __construct(){
		global $wgRequest;
		$this->request = &$wgRequest;
		parent::__construct( "stafflog","stafflog");
		wfLoadExtensionMessages( 'StaffLog' );
	}
	

	function execute( $par ){
		global $wgOut, $wgUser;
		$this->setHeaders();
		
		if( !$wgUser->isAllowed( 'stafflog' ) ) {
			$wgOut->permissionRequired( 'stafflog' );
			return;
		}

		$pager = new StaffLoggerPager( "" );
		$wgOut->addHTML(
			XML::openElement( 'div', array('class' => 'mw-spcontent') ) .
			$pager->getNavigationBar() .
			'<ul>' . $pager->getBody() . '</ul>' .
			$pager->getNavigationBar() .
			XML::closeElement( 'div' )
		);
	}
}


class StaffLoggerPager extends ReverseChronologicalPager {
	
	function __construct( $from ) {
		global $wgExternalDatawareDB;
		parent::__construct();
		$this->mDb = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$from = str_replace( ' ', '_', $from );
		if( $from !== '' ) {
			global $wgCapitalLinks, $wgContLang;
			if( $wgCapitalLinks ) {
				$from = $wgContLang->ucfirst( $from );
			}
			$this->mOffset = $from;
		}
	}
	
	function getQueryInfo() {
		return array(
			'tables' => array( 'wikiastaff_log' ),
			'fields' => array(	'slog_user_name',
								'slog_user_namedst',
								'slog_user',
								'slog_userdst',
								'slog_timestamp',
								'slog_action',
								'slog_type',
								'slog_comment',
								'slog_site',
								'slog_city' ),
			//'conds' => array( 'cat_pages > 0' ), 
			'options' => array( 'USE INDEX' => 'slog_time' ),
		);
	}

	function getIndexField() {
#		return array( 'abc' => 'cat_title', 'count' => 'cat_pages' );
		return 'slog_timestamp';
	}

	function getDefaultQuery() {
		parent::getDefaultQuery();
		unset( $this->mDefaultQuery['from'] );
		return $this->mDefaultQuery;
	}
#	protected function getOrderTypeMessages() {
#		return array( 'abc' => 'special-categories-sort-abc',
#			'count' => 'special-categories-sort-count' );
#	}

	protected function getDefaultDirections() {
#		return array( 'abc' => false, 'count' => true );
		return false;
	}

	/* Override getBody to apply LinksBatch on resultset before actually outputting anything. */
	public function getBody() {
		if (!$this->mQueryDone) {
			$this->doQuery();
		}
		$batch = new LinkBatch;

		$this->mResult->rewind();

		while ( $row = $this->mResult->fetchObject() ) {
			$batch->addObj( Title::makeTitleSafe( NS_CATEGORY, $row->cat_title ) );
		}
		$batch->execute();
		$this->mResult->rewind();
		return parent::getBody();
	}

	function formatRow($result) {
		global $wgLang;
		$linker = $this->getSkin();
       	$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $result->slog_timestamp), true );
		/* switch for different type of log message */ 
		switch ($result->slog_type)
		{
			case 'block':				
				$domains = WikiFactory::getDomains( $result->slog_city );
				$siteurl = $result->slog_site;
				if (!empty($domains))
				{
					$siteurl =  Xml::tags('a', array("href" => "http://".$domains[0] ), $siteurl);
				}
				$out = wfMsg( 'stafflog-blockmsg' ,
						array($time,
							  $linker->userLink($result->slog_user, $result->slog_user_name),
							  $linker->userLink($result->slog_userdst, $result->slog_user_namedst),
							  $siteurl,
							  strlen($result->slog_comment) > 0 ? $result->slog_comment:"-" ));			
				break;
			case  'piggyback':
				$msg = $result->slog_action == "login" ? "stafflog-piggybackloginmsg" : "stafflog-piggybacklogoutmsg";
				$out = wfMsg( $msg,
						array($time,
							  $linker->userLink($result->slog_user, $result->slog_user_name),
							  $linker->userLink($result->slog_userdst, $result->slog_user_namedst)));
				break;
			default:
				$out = "";
				wfRunHooks('StaffLog::formatRow',array($result->slog_type,$result,$time,$linker,&$out));
			break;
		}

/*		$title = Title::makeTitle( NS_CATEGORY, $result->cat_title );
		$titleText = $this->getSkin()->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );
		$count = wfMsgExt( 'nmembers', array( 'parsemag', 'escape' ),
				$wgLang->formatNum( $result->cat_pages ) ); */
		 //;
		return Xml::tags('li', null, $out) . "\n";
	}
}