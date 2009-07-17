<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


/**
 * @addtogroup SpecialPage
 */
class WikiFactoryPage extends SpecialPage {

	private $mWiki, $mTitle, $mDomain, $mTab, $mVariableName;
	public $mStatuses = array( "disabled", "enabled", "redirected" );

	/**
	 * constructor
	 */
	function  __construct() {
		wfLoadExtensionMessages("WikiFactory");
		parent::__construct( "WikiFactory"  /*class*/, 'wikifactory' /*restriction*/);
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @access public
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;
		wfLoadExtensionMessages("WikiFactory");

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'wikifactory' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		$this->mDomain = false;

		/**
		 * initial output
		 */
		$wgOut->setPageTitle( wfMsg('wikifactorypagetitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		#--- handle chagelog
		if ( $subpage === "change.log" ) {
			$oPager = new ChangeLogPager;

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"limit"     => $oPager->getForm(),
				"body"      => $oPager->getBody(),
				"nav"       => $oPager->getNavigationBar()
			));
			$wgOut->addHTML( $oTmpl->execute("changelog") );
		}
		elseif ( strtolower($subpage) === "metrics" ) {
			$oAWCMetrics = new WikiMetrics();
			$oAWCMetrics->show();
		}
		elseif ( $subpage === "short.stats" ) {
			$wgOut->addHTML( $this->shortStats() );
		}
		else {
			$subpage = ( $subpage == "/" ) ? null : $subpage;
			$oWiki = $this->getWikiData( $subpage );

			if( !isset( $oWiki->city_id )) {
				$this->doWikiSelector();
			}
			else {
				$this->mWiki = $oWiki;
				$this->doWikiForm( );
			}
		}
	}

	/**
	 * getWikiData
	 *
	 * use subpage as param and try to find wiki which match criteria
	 *
	 * @access private
	 *
	 * @param mixed $subpage:
	 *
	 * @return Database Row from city_list
	 */
	private function getWikiData( $subpage ) {
		global $wgRequest;

		$domain	= $wgRequest->getVal( "wpCityDomain", null );
		$cityid	= $wgRequest->getVal( "cityid", null );
		$tab 	= "variables";
		if( is_null( $cityid ) && ( isset( $subpage ) || isset( $domain ) ) ) {

			/**
			 * if there is # in subpage we are switching tab
			 */
			if( strpos( $subpage, "/" ) ) {
				$parts = explode( "/", $subpage, 3 );
				if( is_array( $parts ) && sizeof( $parts ) >= 2 ) {
					$subpage = $parts[0];
					$tab = $parts[1];
					if ( ( $tab === "variables" ) && ( isset($parts[2]) ) ) {
						$this->mVariableName = trim($parts[2]);
					}
				}
			}

			if( is_null( $domain ) ) {
				$domain = $subpage;
			}

			if( is_numeric( $subpage ) ) {
				$cityid = $subpage;
			}
			else {
				/**
				 * if there's no dot in cityname we add .wikia.com
				 * or if is only one dot (language.domain.wikia.com)
				 */
				if( sizeof(explode(".", $domain )) <= 2 && strlen( $domain ) > 0) {
					$domain = $domain.".wikia.com";
				}
				$this->mDomain = $domain;

				$cityid = WikiFactory::DomainToId( $domain );
			}
		}
		$this->mTab = $tab;
		if( !is_null( $cityid ) ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$cityid}/{$tab}" );
		}
		if ( !isset($this->mVariableName) ) {
			$this->mVariableName = "";
		}
		return WikiFactory::getWikiByID( $cityid );
	}

	/**
	 * doWikiSelector
	 *
	 * Pager with all wikis
	 *
	 * @access private
	 * @author eloy
	 *
	 * @return nothing
	 */
	private function doWikiSelector() {
		global $wgOut;


		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title"  => $this->mTitle,
			"domain" => $this->mDomain
		));

		if( !empty( $this->mDomain ) ) {
			$pager = new CityListPager( $this->mDomain );
			$oTmpl->set( "pager", $pager->render() );
		}
		$wgOut->addHTML( $oTmpl->render( "selector" ) );
	}

	/**
	 * doCityForm
	 *
	 * show wiki data
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return nothing
	 */
	public function doWikiForm() {
		global $wgOut, $wgRequest;
		global $wgDevelEnvironment;

		$info = null;
		/**
		 * check maybe something was posted
		 */
		if( $wgRequest->wasPosted() ) {
			switch( $this->mTab ){
				case "hubs":
					$info = $this->doUpdateHubs( $wgRequest );
				break;
				case "domains":
					$info = $this->doUpdateDomains( $wgRequest );
				break;
			}
		}

		$oWikiRequest = null;
		if( class_exists( "CreateWikiForm" ) ) {
			preg_match('/http:\/\/(\w{1,})./i', $this->mWiki->city_url, $matches);
			$sRequestName = $matches[1];
			if(!empty($sRequestName)) {
				$oWikiRequest = CreateWikiForm::getRequestBy( 'request_name', $sRequestName );
				$oWikiRequest = is_object($oWikiRequest) ? $oWikiRequest : $sRequestName;
			}
		}

		$user_name = 'unknown';
		if (!empty($this->mWiki->city_founding_user)) {
			$user_name = User::WhoIs($this->mWiki->city_founding_user);
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$vars = array(
			"tab"         => $this->mTab,
			"hub"         => WikiFactoryHub::getInstance(),
			"wiki"        => $this->mWiki,
			"info"        => $info,
			"title"       => $this->mTitle,
			"groups"      => WikiFactory::getGroups(),
			"domains"     => WikiFactory::getDomains( $this->mWiki->city_id ),
			"statuses" 	  => $this->mStatuses,
			"variables"   => WikiFactory::getVariables(),
			"wikiRequest" => $oWikiRequest,
			"variableName"=> $this->mVariableName,
			"user_name"   => $user_name,
			"isDevel"     => $wgDevelEnvironment
		);
		if( $this->mTab === "clog" ) {
			$pager = new ChangeLogPager( $this->mWiki->city_id );
			$vars[ "changelog" ] = array(
				"limit"     => $pager->getForm(),
				"body"      => $pager->getBody(),
				"nav"       => $pager->getNavigationBar()
			);
		}
		$oTmpl->set_vars( $vars );
		$wgOut->addHTML( $oTmpl->execute("form") );
	}

	/**
	 * doUpdateHubs
	 *
	 * Store changes connected with hubs
	 *
	 * @access private
	 *
	 * @return mixed	info when change, null when not changed
	 */
	private function doUpdateHubs( &$request ) {
		$cat_id = $request->getVal( "wpWikiCategory", null );
		if( !is_null( $cat_id ) ){
			$hub = WikiFactoryHub::getInstance();
			$hub->setCategory( $this->mWiki->city_id, $cat_id );
			$categories = $hub->getCategories();
			return Wikia::successmsg( "Hub is now set to: ". $categories[ $cat_id ] );
		}
		else {
			return Wikia::errormsg( "Hub was not changed.");
		}
	}

    /**
     * doUpdateDomains
     *
     * Store changes connected with domains
     *
     * @access private
     * @author eloy@wikia
     *
     * @return mixed	info when change, null when not changed
     */
	private function doUpdateDomains( &$request ) {
		$action = $request->getText( "wpAction", null );
		$message = "";
		switch( $action ) {
			case "status":
				$status = $request->getVal( "wpWikiStatus", 0 );
				WikiFactory::setPublicStatus( $status, $this->mWiki->city_id );
				$this->mWiki->city_public = $status;
				$message = "Status of this wiki was changed to " . $this->mStatuses[ $status ];
			break;
		}
		return Wikia::successmsg( $message );
	}

	/**
	 * showTab
	 *
	 * helper function, CSS/HTML code for tab
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 * @static
	 *
	 * @param string	$tab		current tab
	 * @param string 	$active		active tab
	 * @param integer	$city_id	wiki id in city_list table
	 *
	 * @return string HTML/CSS code
	 */
	static public function showTab( $tab, $active, $city_id ) {

		$title = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$city_id}/{$tab}" );

		if( $tab === $active ) {
			return wfMsg( "wikifactory-label-{$tab}" );
		}
		else {
			$attribs = array(
				"href" => $title->getFullUrl()
			);
			return wfElement( "a", $attribs, wfMsg( "wikifactory-label-{$tab}" ) );
		}
	}

	private function shortStats() {

		$dbr = WikiFactory::db( DB_SLAVE );
		$res = $dbr->select(
			array( "city_list" ),
			array(
				"date(city_created) as date",
				"city_public",
				"count(*) as count"
			),
			false,
			__METHOD__,
			array(
				  "GROUP BY" => "date(city_created), city_public",
				  "ORDER BY" => "date(city_created) desc"
			)
		);
		$stats = array();
		while( $row = $dbr->fetchObject( $res ) ) {
			if( !isset( $stats[ $row->date ] ) ){
				$stats[ $row->date ] = (object) null;
			}
			$stats[ $row->date ]->total += $row->count;
			switch( $row->city_public ) {
				case 1:
					$stats[ $row->date ]->active += $row->count;
					break;
				case 0:
					$stats[ $row->date ]->disabled += $row->count;
					break;
				case 2:
					$stats[ $row->date ]->redirected += $row->count;
					break;
			}
		}
		$dbr->freeResult( $res );

		$Tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$Tmpl->set( "stats", $stats );


		return $Tmpl->render( "shortstats" );
	}
}

/**
 * Changelog Pager
 */
class ChangeLogPager  {

	/**
	 * __construct
	 *
	 * Public constructor with standard initializations
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param integer $wiki_id	wiki identifier in wiki factory
	 *
	 */
	function __construct( $wiki_id = false ) {
		if( is_numeric( $wiki_id ) ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/{$wiki_id}/clog" );
			$this->mWikiId = $wiki_id;
		}
		else {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/change.log" );
			$this->mWikiId = false;
		}
		$this->mDefaultDirection = true;
		parent::__construct();
	}

	/**
	 * getTitle
	 *
	 * @return Title object
     */
	function getTitle() {
		return $this->mTitle;
	}

	/**
	 * getFieldNames
	 *
	 * @return Array with column names
	 */
	public function getFieldNames() {
		if( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			if( ! $this->mWikiId ) {
				$this->mFieldNames["city_url"]      = "Wiki";
			}
			$this->mFieldNames["cl_timestamp"]  = "Changed";
			$this->mFieldNames["cl_type"]       = "Type";
			$this->mFieldNames["cl_user_id"]    = "Who";
			$this->mFieldNames["cl_text"]       = "What";
		}

		return $this->mFieldNames;
	}

	/**
	 * isFieldSortable
	 *
	 * @param string $field: field name
	 *
	 * @return boolean: flag if $field is sortable of not
     */
	public function isFieldSortable( $field ) {
		static $aSortable = array( "city_url", "cl_type", "cl_timestamp", "cl_user_id" );
		return in_array( $field, $aSortable );
	}

	protected function preprocessResults( $result ) {

	}
	/**
	 * formatValue
	 *
	 * field formatter
	 *
	 * @param string $field: field name
	 * @param mixed $value: field value
	 *
	 * @return string: formated table field
	 */
	function formatValue( $field, $value ) {
		switch ($field) {
			case "city_url":
				preg_match("/http:\/\/([\w\.\-]+)\//", $value, $matches );
				$sRetval = str_ireplace(".wikia.com", "", $matches[1]);
				return $sRetval;
				break;

			case "cl_timestamp":
				return wfTimestamp( TS_EXIF, $value );
				break;
			case "cl_type":
				switch( $value ) {
					case WikiFactory::LOG_CATEGORY:
						return "category";
						break;
					case WikiFactory::LOG_VARIABLE:
						return "variable";
						break;
					case WikiFactory::LOG_DOMAIN:
						return "domain";
						break;
					case WikiFactory::LOG_STATUS:
						return "status";
						break;
				}
				break;

			case "cl_user_id":
				$oUser = User::newFromId( $value );
				$oUser->load();
				return sprintf("<a href=\"%s\">%s</a>", $oUser->getUserPage()->getLocalUrl(), $oUser->getName());
				break;

			default:
				return $value;
		}
	}

	/**
	 * getDefaultSort
	 *
	 * get default field for sorting
	 *
	 * @return string: table field
	 */
	function getDefaultSort() {
		$this->mDefaultDirection = true;
		return "cl_timestamp";
	}

	/**
	 * getQueryInfo
	 *
	 * get default field for sorting
	 *
	 * @return array: query info
	 */
	function getQueryInfo() {
		$query = array(
			"tables" => array(
				WikiFactory::table("city_list_log"),
				WikiFactory::table("city_list"),
			),
			"fields" => array( "*" ),
			"conds" => array(
				WikiFactory::table("city_list", "city_id" )
					. " = "
					. WikiFactory::table( "city_list_log", "cl_city_id" )
			)
		);

		if( $this->mWikiId ) {
			$query[ "conds" ][] = WikiFactory::table("city_list", "city_id" )
				. " = "
				. $this->mWikiId;
		}
		return $query;
	}

	/**
	 * getForm
	 *
	 * get form definition
	 *
	 * @return string: empty
	 */
	function getForm() {
		return "";
	}
}


/**
 * CityListPager( $this->mDomain );
 */
class CityListPager {

	private $mPart;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $part ) {
		$this->mPart = $part;
	}

	/**
	 * render page of pager
	 * 
	 * @access public
	 */
	public function render() {

	}
};
