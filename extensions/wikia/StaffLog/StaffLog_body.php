<?php

class StaffLog extends SpecialPage {
	private $request;
	private $aTypes = array( 'piggyback', 'wikifactor' );

	function __construct(){
		parent::__construct( "stafflog","stafflog");

		$this->request = $this->getContext()->getRequest();
		$this->aTypes = array(
			'' => '',
			'block' => wfMessage( 'stafflog-filter-type-block' )->text(),
			'piggyback' => wfMessage( 'stafflog-filter-type-piggyback' )->text(),
			'renameuser' => wfMessage( 'stafflog-filter-type-renameuser' )->text(),
			'coppatool' => wfMessage( 'stafflog-filter-type-coppa' )->text(),
			'wikifactor' => wfMessage( 'stafflog-filter-type-wikifactory' )->text()
		);
	}


	function execute( $par ){
		$this->setHeaders();

		if( !$this->getContext()->getUser()->isAllowed( 'stafflog' ) ) {
			throw new PermissionsError( 'stafflog' );
		}

		$pager = new StaffLoggerPager( "" );

		$sTypesDropDown = Xml::openElement( 'select', array( 'name' => 'type', 'id' => 'StaffLogFilterType' ) );

		foreach ( $this->aTypes as $k => $v) {
			$sTypesDropDown .= Xml::option( $v, $k, ( $k == $this->request->getText( 'type', '' ) ) );
		}

		$sTypesDropDown .= Xml::closeElement( 'select' );

		$this->getOutput()->addHTML(
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $this->getTitle()->getLocalURL() ) ) .
				Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( 'stafflog-filter-label' ), false ) .
				Xml::inputLabel(
					wfMsg('stafflog-filter-user'),
					'user',
					'StaffLogFilterUser',
					false,
					htmlspecialchars( $this->request->getText( 'user', '' ), ENT_QUOTES, 'UTF-8' )
				) .
				Xml::label( wfMsg( 'stafflog-filter-type' ), 'StaffLogFilterType' ) . ' ' .
				$sTypesDropDown . ' ' .
				Xml::submitButton( wfMsg( 'stafflog-filter-apply' ) ) .
				Xml::closeElement( 'fieldset' ) .
				Xml::closeElement( 'form' ) .
				Xml::openElement( 'div', array('class' => 'mw-spcontent') ) .
				$pager->getNavigationBar() .
				'<ul>' . $pager->getBody() . '</ul>' .
				$pager->getNavigationBar() .
				Xml::closeElement( 'div' )
		);
	}
}


class StaffLoggerPager extends ReverseChronologicalPager {

	public $mDb, $mOffset;
	private $aConds;

	/**
	 * @param string $from
	 */
	function __construct( $from ) {
		global $wgExternalDatawareDB;
		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
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
			$userid = User::idFromName( $sUser );
			$this->aConds['slog_user'] = $userid;
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
		return 'slog_timestamp';
	}

	function getDefaultQuery() {
		parent::getDefaultQuery();
		unset( $this->mDefaultQuery['from'] );
		return $this->mDefaultQuery;
	}

	protected function getDefaultDirections() {
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
		/* @var Language $wgLang */
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
				$out = wfMessage( 'stafflog-blockmsg' ,
					array($time,
						Linker::userLink($result->slog_user, User::getUsername( $result->slog_user, $result->slog_user_name ) ),
						Linker::userLink($result->slog_userdst, User::getUsername( $result->slog_userdst, $result->slog_user_namedst ) ),
						$siteurl,
						strlen($result->slog_comment) > 0 ? $result->slog_comment:"-" ))->text();
				break;
			case  'piggyback':
				$msg = $result->slog_action == "login" ? "stafflog-piggybackloginmsg" : "stafflog-piggybacklogoutmsg";
				$out = wfMessage( $msg,
					array($time,
						Linker::userLink($result->slog_user, User::getUsername( $result->slog_user, $result->slog_user_name ) ),
						Linker::userLink($result->slog_userdst, User::getUsername($result->slog_userdst, $result->slog_user_namedst ) )
					)
				)->text();
				break;
			case 'wikifactor':
				$out = $time . ' ' . $result->slog_comment;
				break;
			default:
				$out = "";

				// TODO: used by UserRenameToolStaffLogFormatRow only, remove when we get rid of Special:RenameUser
				Hooks::run('StaffLog::formatRow',array($result->slog_type,$result,$time,&$out));
				break;
		}

		return Xml::tags('li', null, $out) . "\n";
	}
}
