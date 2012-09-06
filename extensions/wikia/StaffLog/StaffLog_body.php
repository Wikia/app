<?php

class StaffLog extends SpecialPage
{
	var $request;
	private $aTypes = array( 'piggyback', 'wikifactor' );

	function __construct(){
		global $wgRequest;
		$this->request = &$wgRequest;
		parent::__construct( "stafflog","stafflog");
		$this->aTypes = array(
			'' => '',
			'block' => wfMsg( 'stafflog-filter-type-block' ),
			'piggyback' => wfMsg( 'stafflog-filter-type-piggyback' ),
			'renameuser' => wfMsg( 'stafflog-filter-type-renameuser' ),
			'wikifactor' => wfMsg( 'stafflog-filter-type-wikifactory' )
		);
	}


	function execute( $par ){
		global $wgOut, $wgUser;
		$this->setHeaders();

		if( !$wgUser->isAllowed( 'stafflog' ) ) {
			throw new PermissionsError( 'stafflog' );
		}

		$pager = new StaffLoggerPager( "" );

		$sTypesDropDown = XML::openElement( 'select', array( 'name' => 'type', 'id' => 'StaffLogFilterType' ) );

		foreach ( $this->aTypes as $k => $v) {
			$sTypesDropDown .= XML::option( $v, $k, ( $k == $this->request->getText( 'type', '' ) ) );
		}

		$sTypesDropDown .= XML::closeElement( 'select' );

		$wgOut->addHTML(
			XML::openElement( 'form', array( 'method' => 'get', 'action' => $this->getTitle()->getLocalURL() ) ) .
				XML::openElement( 'fieldset' ) .
				XML::element( 'legend', null, wfMsg( 'stafflog-filter-label' ), false ) .
				XML::inputLabel(
					wfMsg('stafflog-filter-user'),
					'user',
					'StaffLogFilterUser',
					false,
					htmlspecialchars( $this->request->getText( 'user', '' ), ENT_QUOTES, 'UTF-8' )
				) .
				XML::label( wfMsg( 'stafflog-filter-type' ), 'StaffLogFilterType' ) . ' ' .
				$sTypesDropDown . ' ' .
				XML::submitButton( wfMsg( 'stafflog-filter-apply' ) ) .
				XML::closeElement( 'fieldset' ) .
				XML::closeElement( 'form' ) .
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

		// filtering by type and by user name
		$this->aConds = array();

		$sType = $this->mRequest->getText( 'type', '' );
		if ( !empty( $sType ) ) {
			$this->aConds['slog_type'] = $sType;
		}

		$sUser = $this->mRequest->getText( 'user', '' );
		if ( !empty( $sUser ) ) {
			$this->aConds['slog_user_name'] = $sUser;
		}
	}

	function getQueryInfo() {
		$aOut = array(
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
		if ( !empty( $this->aConds ) ) {
			$aOut['conds'] = $this->aConds;
		}
		return $aOut;
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
			case 'wikifactor':
				$out = $time . ' ' . $result->slog_comment;
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
