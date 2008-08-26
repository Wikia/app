<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiEvents.\n";
    exit( 1 ) ;
}

define ("PAGE_NAME", 'WikiEvents');

#--- Add messages
global $wgMessageCache, $wgWikiEventsMessages;
foreach( $wgWikiEventsMessages as $key => $value ) {
    $wgMessageCache->addMessages( $wgWikiEventsMessages[$key], $key );
}

global $wgwkEventHooks;

class WikiaEventsPage extends SpecialPage {

    /**
     * contructor
     */
    function  __construct() {
        parent::__construct( PAGE_NAME, 'systemevents');
    }

    function execute() {
        global $wgUser, $wgOut, $wgRequest;

		wfProfileIn( __METHOD__ );

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isAllowed( 'systemevents' ) ) {
            $this->displayRestrictionError();
            return;
        }

        if (!in_array('systemevents', $wgUser->getRights() )) {
            $wgOut->setArticleRelated( false );
            $wgOut->setRobotpolicy( 'noindex,nofollow' );
            $wgOut->errorpage( 'nosuchspecialpage', 'nospecialpagetext' );
            return;
        }

        $oEvForm = new WikiaEventRequest($wgRequest);
        if (!empty($oEvForm))
        {
        	#--- menu
        	$oEvForm->doMenuForm();
        	#--- parse request action
        	$oEvForm->makeConfigEventAction();
        	#--- footer
        	$oEvForm->doShowFooter();
        }

		wfProfileOut( __METHOD__ );
    }
};


class WikiaEventRequest {
    var $mTitle, $mAction, $mPosted, $mRequest;

    function __construct(&$request)
    {
        global $wgOut;

		wfProfileIn( __METHOD__ );
        $this->mEvent = null;

        $this->mRequest = $request;

        $this->mPosted = $request->wasPosted();
        $this->mAction = $request->getVal( 'action' );

        #--- initial output
        $this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiEvent' );
        $wgOut->setPageTitle( wfMsg('wepagetitle') );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
        $wgOut->setArticleRelated( false );

		wfProfileOut( __METHOD__ );
    }

    public function getAction()
    {
    	return $this->mAction;
    }

    public function isPosted()
    {
    	return $this->mPosted;
    }

    /*
     * menu
     */
    public function doMenuForm()
    {
        global $wgOut;

        wfProfileIn( __METHOD__ );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars(
        	array(
        		'events' 			=> wfMsg('events'),
        		'events_type' 		=> wfMsg('eventtype'),
        		'events_templates' 	=> wfMsg('eventtemplates'),
        		'events_tracking' 	=> wfMsg('eventtracking'),
        		'events_hooks'		=> wfMsg('eventhooks'),
        		'events_params'		=> wfMsg('events_params'),
        		'events_setup'		=> wfMsg('events_setup'),
        	)
        );

		$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/WikiaEvents/js/wikia_events.js\"></script>\n");
        $wgOut->addHTML( $oTmpl->execute("events-menu") );

		wfProfileOut( __METHOD__ );
    }

    public function makeConfigEventAction()
    {
		wfProfileIn( __METHOD__ );

    	switch ($this->mAction)
    	{
    		case 'type' :
    			{
    				$this->doEventType();
    				break;
    			}
    		case 'events' :
    			{
    				$this->doEventShow();
    				break;
    			}
    		case 'tmpl' :
    			{
    				$this->doEventTemplate();
    				break;
    			}
    		case 'track' :
    			{
    				$this->doEventTrack();
    				break;
    			}
    		case 'setup' :
    			{
    				$this->doEventSetup();
    				break;
    			}
    		default:
    			{
    				break;
    			}
    	}

		wfProfileOut( __METHOD__ );
    }

    public function doShowFooter()
    {
        global $wgOut;

		wfProfileIn( __METHOD__ );

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array() );

        $wgOut->addHTML( $oTmpl->execute("events-footer") );

		wfProfileOut( __METHOD__ );
    }

	/*
	 *
	 * Menu's functions
	 *
	 */
    private function doEventType()
    {
    	global $wgOut, $wgScript;

		wfProfileIn( __METHOD__ );

    	if ($this->mPosted)
    	{
    		$eventName = $this->mRequest->getVal( 'eventName' );
    		$eventDesc = $this->mRequest->getVal( 'eventDesc' );
    		$eventActive = $this->mRequest->getVal( 'eventActive' );
    		if (!empty($eventName))
    		{
    			$this->addEventTypeDB($eventName, $eventDesc, (empty($eventActive))?0:1);
    		}
    	}

    	#---
    	# get events from database;
    	$events = $this->getEventsTypeFromDB();
    	#---

        $baseurl = sprintf("%s?action=ajax&rs=wfwkGetEventTypes", $wgScript);

        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"event_select_form" => $events,
        		"select_txt" 		=> wfMsg('choosetype'),
        		"select_def_txt"	=> wfMsg('selectdeftxt'),
        		"edit_txt" 			=> wfMsg('addsystemevent'),
        		"event_edit" 		=> wfMsg('btnedit'),
        		"event_name"		=> wfMsg('eventname'),
        		"event_desc"		=> wfMsg('eventdesc'),
        		"event_active"		=> wfMsg('eventactive'),
        		"event_created_by"	=> wfMsg('eventcreatedby'),
        		"savebtn"			=> wfMsg('savebtn'),
        		"events_type"		=> wfMsg('eventtype'),
        		"baseurl"			=> $baseurl,
        		"tableHdr"			=> array(wfMsg('eventname'), wfMsg('eventdesc'), wfMsg('eventactive')),
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events-type") );

		wfProfileOut( __METHOD__ );
    }

	#---
    private function doEventShow()
    {
    	global $wgOut, $wgScript;
    	global $wgwkEventHooks; // list of hooks

		wfProfileIn( __METHOD__ );

    	if ($this->mPosted)
    	{
    		$eventName = $this->mRequest->getVal( 'eventName' );
    		$eventDesc = $this->mRequest->getVal( 'eventDesc' );
    		$eventActive = $this->mRequest->getVal( 'eventActive' );
    		$selectHook = $this->mRequest->getVal( 'wk-select-hook' );
    		if (!empty($eventName))
    		{
    			$this->addEventDB($eventName, $eventDesc, (empty($eventActive))?0:1, $selectHook);
    		}
    	}

    	#---
    	//$hooks = $this->getHooksFromPath();
/*    	$hooks = $this->getHooksList();
    	echo "<pre>".print_r($hooks, true)."</pre>";

    	$hooks = $this->getHooksFromPath();
    	echo "<pre>".print_r($hooks, true)."</pre>";*/
    	#---

    	#---
    	# get events from database;
    	$events = $this->getEventsFromDB();
    	#---

        $baseurl = sprintf("%s?action=ajax&rs=wfwkGetEvents", $wgScript);

        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"event_select_form" => $events,
        		"select_txt" 		=> wfMsg('chooseevent'),
        		"select_def_txt"	=> wfMsg('selectdeftxt'),
        		"edit_txt" 			=> wfMsg('addsystemevent'),
        		"event_edit" 		=> wfMsg('btnedit'),
        		"event_name"		=> wfMsg('eventname'),
        		"event_desc"		=> wfMsg('eventdesc'),
        		"hookname"			=> wfMsg('hookname'),
        		"event_active"		=> wfMsg('eventactive'),
        		"event_created_by"	=> wfMsg('eventcreatedby'),
        		"savebtn"			=> wfMsg('savebtn'),
        		"events"			=> wfMsg('events'),
        		"baseurl"			=> $baseurl,
        		//"hooks"				=> $wgwkEventHooks,
        		"tableHdr"			=> array(wfMsg('eventname'), wfMsg('eventdesc'), wfMsg('hookname'), wfMsg('eventactive')),
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events") );

		wfProfileOut( __METHOD__ );
    }

	#---
    private function doEventTemplate()
    {
    	global $wgOut;

		wfProfileIn( __METHOD__ );

    	# get events from database;
    	$events = $this->getEventsFromDB();
    	#---
        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"event_select_form" => $events,
        		"eventtpltext" 		=> wfMsg('eventtpltext'),
        		"events_text"		=> wfMsg('eventtext'),
        		"event_name"		=> wfMsg('eventname'),
        		"selectevent"		=> wfMsg('selectdeftxt'),
        		"addeventtext"		=> wfMsg('addeventtext'),
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events-text") );

		wfProfileOut( __METHOD__ );
    }

    #---
    private function doEventTrack()
    {
    	global $wgOut;
    	global $wgRequest;

		wfProfileIn( __METHOD__ );

		#---
		$ev_id = $wgRequest->getText('wk_select_event_name');
    	# get events from database;
    	$events = $this->getEventsFromDB();
    	#---
        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"event_select_form" => $events,
        		"eventtpltext" 		=> wfMsg('eventtpltext'),
        		"events_text"		=> wfMsg('eventtracking'),
        		"event_name"		=> wfMsg('eventname'),
        		"selectevent"		=> wfMsg('selectdeftxt'),
        		"addeventtext"		=> wfMsg('addeventtext'),
        		"select_event"		=> ( isset($ev_id) ) ? $ev_id : 0,
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events-track") );

		if ( isset($ev_id) )
		{
			$data = $this->getUserActionDataFromDB($ev_id);
			foreach ($data as $type_name => $data_values)
			{
				$this->genarateTrackDataCharts ($data_values, $events[$ev_id]['name']." ($type_name)");
			}
		}

		wfProfileOut( __METHOD__ );
    }

    #---
    private function doEventSetup()
    {
    	global $wgOut, $wgScript;
    	global $wgMemc;

		wfProfileIn( __METHOD__ );

    	# get events from database;
    	#$setupVars = $wgMemc->get(MEMC_SETUP_KEY);
   		$setupVars = $this->getEventsSetupFromDB();
    	#---

        $baseurl = sprintf("%s?action=ajax&rs=wfwkSetEventParamSetup", $wgScript);

        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"setupVars" 		=> $setupVars,
        		"ev_title_setup"	=> wfMsg('events_title_setup'),
        		"ev_param_list"		=> wfMsg('events_variables_list'),
        		"savebtn"			=> wfMsg('savebtn'),
        		"btnedit"			=> wfMsg('btnedit'),
        		"baseurl"			=> $baseurl,
        		"tableRowHdr"		=> wfMsg('event_variables'),
        		"tableHdr"			=> array('#', wfMsg('eventname'), wfMsg('event_param_value'), wfMsg('eventdesc'), wfMsg('eventactive'), wfMsg('eventoption')),
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events-setup") );

		wfProfileOut( __METHOD__ );
    }

	#---
	# other functions
	#---
	private function getHooksList()
	{
		global $IP;
		wfProfileIn( __METHOD__ );

		$hooks = array();
		$hooksDoc = $IP."/docs/hooks.txt";
		$content = file_get_contents( $hooksDoc );
		echo "<pre>".$content."</pre>";
		$m = array();
		preg_match_all( "/\n'(.*?)':\s(.*?)\n\n/s", $content, $m);
		/*foreach ($m[1] as $hook_id => $hook_name)
		{
			$_ = array();
			preg_match_all( "/(.*?)([\$].*?)[\:](.*?)[\n]/", $m[2][$hook_id]."\n", $_);
			//$hooks[$hook_name];
		}*/
		//echo "<pre>".print_r($m, true)."</pre>";

		wfProfileOut( __METHOD__ );
		return $m[1];
	}

	/**
	 * Get hooks from the source code.
	 * @param $path Directory where the include files can be found
	 * @return array of hooks found.
	 */
	function getHooksFromPath()
	{
		global $IP;
		wfProfileIn( __METHOD__ );

		$hooks = array();
		$path = $IP."/includes/";
		if( $dh = opendir($path) )
		{
			while(($file = readdir($dh)) !== false)
			{
				if( filetype($path.$file) == 'file' )
				{
					$content = file_get_contents($path.$file);
					$_ = array();
					if (preg_match_all( "/wfRunHooks\(\s*\'(.*?)\'.*?array\s*\((.*?)\)/s", $content, $_))
					{
						$hooks = array_merge( $hooks, $_[1]);
					}
				}
			}
			closedir($dh);
		}

		wfProfileOut( __METHOD__ );

		return $hooks;
	}


    #---
    # database functions
    #---
    private function getEventsSetupFromDB()
    {
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::getEvent';
		#---
		$sql = "SELECT ep_id, ep_name, ep_value, ep_desc, ep_active FROM ".SYSTEM_EVENTS_PARAMS." order by ep_id";
		#---
		$res = $dbr->query($sql);

		$evParams = array();
		while ( $row = $dbr->fetchObject( $res ) )
		{
			$evParams[$row->ep_id] = array('name' => $row->ep_name, 'desc' => $row->ep_desc, 'value' => $row->ep_value, 'active' => (empty($row->ep_active)) ? 0 : 1);
		}
		$dbr->freeResult ($res);

		wfProfileOut( __METHOD__ );
		return $evParams;
	}
    
    #---
    private function getEventsTypeFromDB()
    {
    	global $wgSharedDB;
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::getEvent';
		#---
		$sql = "SELECT et_id, et_name, et_desc, et_active FROM ".SYSTEM_EVENTS_TYPES." order by et_name";
		#---
		$res = $dbr->query($sql);

		$evMessages = array();
		while ( $row = $dbr->fetchObject( $res ) )
		{
			 $evMessages[$row->et_id] = array('name' => $row->et_name, 'desc' => $row->et_desc, 'active' => (empty($row->et_active))?0:1);
		}
		$dbr->freeResult ($res);

		wfProfileOut( __METHOD__ );
		return $evMessages;
    }

	#---
    private function getEventsFromDB()
    {
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::getEvent';
		#---
		$sql = "SELECT ev_id, ev_name, ev_desc, ev_active, ev_hook, ev_hook_values FROM ".SYSTEM_EVENTS." order by ev_name";
		#---
		$res = $dbr->query($sql);

		$evMessages = array();
		while ( $row = $dbr->fetchObject( $res ) )
		{
			 $evMessages[$row->ev_id] = array(
			 								'name' => $row->ev_name,
			 								'desc' => $row->ev_desc,
			 								'hook'=>$row->ev_hook,
			 								'hook_values'=>$row->ev_hook_values,
			 								'active' => (empty($row->ev_active))?0:1
			 								);
		}
		$dbr->freeResult ($res);

		wfProfileOut( __METHOD__ );

		return $evMessages;
    }

    private function addEventTypeDB($et_name, $et_desc, $et_active)
    {
    	global $wgUser;
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::addEventType';
		#---
		$sql = "INSERT INTO ".SYSTEM_EVENTS_TYPES." (et_id, et_name, et_user_id, et_timestamp, et_desc, et_active) values ";
		$sql .= "(null, ".$dbr->addQuotes($et_name).", ".$dbr->addQuotes($wgUser->getID()).", ".$dbr->addQuotes(wfTimestampNow()).", ".$dbr->addQuotes($et_desc).", ".$et_active.")";
		#---
		$res = $dbr->query($sql);

		wfProfileOut( __METHOD__ );

        return ($res ? mysql_insert_id() : false);
    }

    private function addEventDB($ev_name, $ev_desc, $ev_active, $selectHook)
    {
    	global $wgUser;
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::addEvent';
		#---
		$sql = "INSERT INTO ".SYSTEM_EVENTS." (ev_id, ev_name, ev_user_id, ev_timestamp, ev_desc, ev_active, ev_hook, ev_hook_values) values ";
		$sql .= "(null, ".$dbr->addQuotes($ev_name).", ".$dbr->addQuotes($wgUser->getID()).", ".$dbr->addQuotes(wfTimestampNow()).", ".$dbr->addQuotes($ev_desc).", ".$ev_active.", ".$dbr->addQuotes($selectHook).", '')";
		#---
		$res = $dbr->query($sql);

		wfProfileOut( __METHOD__ );

        return ($res ? mysql_insert_id() : false);
    }

    private function getUserActionDataFromDB($ev_id)
    {
    	#---
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Special:WikiEvents::userActionData';
		#---
		$sql = "SELECT ed_et_id, et_name, ed_field_id, count(ed_field_id) as cnt ";
		$sql .= "FROM ".SYSTEM_EVENTS_DATA.", ".SYSTEM_EVENTS_TYPES." ";
		$sql .= "where ed_et_id = et_id and ed_ev_id = '".$ev_id."' group by ed_field_id, ed_et_id, et_name ";
		$sql .= "order by ed_et_id, ed_field_id";
		#---
		$res = $dbr->query($sql);

		$data = array();
		while ( $row = $dbr->fetchObject( $res ) )
		{
			 $data[$row->et_name][] = array(
			 	'id'		=> $ev_id,
			 	'type_id' 	=> $row->ed_et_id,
			 	'field' 	=> $row->ed_field_id,
			 	'cnt' 		=> $row->cnt
			 );
		}
		$dbr->freeResult ($res);

		wfProfileOut( __METHOD__ );
		return $data;
	}

    #---
	private function genarateTrackDataCharts ($data, $chart_title = '')
	{
    	global $wgOut;
		wfProfileIn( __METHOD__ );

		#--- some defaults
		$chart_bar_max_size = 400;
		$chart_bar_size = 20;
		$chart_bar_unit = 'px';
		$chart_colors = array('#DB8400', '#9A1D23');

		// Start HTML...
        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $tmpl->set_vars(
        	array(
        		"eventChartTitle"	=> $chart_title,
        		"eventChartData" 	=> $data,
        		"eventChartBarSize"	=> $chart_bar_size,
        		"eventChartMaxSize"	=> $chart_bar_max_size,
        		"eventChartBarUnit"	=> $chart_bar_unit,
        		"eventChartColors"	=> $chart_colors,
        	)
        );

        $wgOut->addHTML( $tmpl->execute("events-track-chart") );
		wfProfileOut( __METHOD__ );
	}


};

?>
