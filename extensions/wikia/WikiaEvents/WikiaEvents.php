<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

/*
 * 
 *

CREATE TABLE system_events (
  `ev_id` int(7) unsigned not null auto_increment,
  `ev_name` varchar(255) not null,
  `ev_user_id` int(9) unsigned NOT NULL default '0',
  `ev_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ev_desc` text not null,
  `ev_hook` varchar(255) not null,
  `ev_hook_values` mediumtext not null,
  `ev_active` tinyint(3) NOT NULL default 0,
  PRIMARY KEY (`ev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into system_events values (null, 'welcome visitor', '115748', now(), 'Welcome message - when user visit page for first time', 'BeforePageDisplay', '', 0);
insert into system_events values (null, 'CreateVisitorPage', '115748', now(), 'Show message before create user page (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'VotePage', '115748', now(), 'Show message when user hasn\'t vote any page', 'BeforePageDisplay', '', 0);
insert into system_events values (null, 'EditPageByVisitor', '115748', now(), 'Show message where user hasn\'t edit any page (for visitors)', 'GetUserMessages', '', 0);
insert into system_events values (null, 'WatchPage', '115748', now(), 'Get notified when some page is updated (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'DiscussArticle', '115748', now(), 'Check out the forum and join the discussion (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'welcome user', '115748', now(), 'Show message after registration', 'AddNewAccount', '', 0);
insert into system_events values (null, 'CreateUserPage', '115748', now(), 'Show message where user has not own user page', 'GetUserMessages', '', 0);
insert into system_events values (null, 'EditPageByUser', '115748', now(), 'Show message when user didn\'t edit active page', 'GetUserMessages', '', 0);
insert into system_events values (null, 'SendToFriend', '115748', now(), 'Show message after edit user page', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'DiscussUserArticle', '115748', now(), 'Check out the forum and join the discussion (for registered users)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'CreateArticle', '115748', now(), 'Show message to create some article (for reg. users and after edit page)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'WatchUserPage', '115748', now(), 'Show message after edit page to know when page is updated (for reg. user)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'TagImage', '115748', now(), 'Show message to know how to tag image', 'BefWelcomeVisitorConditionorePageDisplay', '', 0);
insert into system_events values (null, 'FlickrPromo', '115748', now(), 'Show message when image page is displaying (reg. users)', 'BeforePageDisplay', '', 0);

CREATE TABLE system_events_types (
  `et_id` int(7) unsigned not null auto_increment,
  `et_name` varchar(255) not null,
  `et_user_id` int(9) unsigned NOT NULL default '0',
  `et_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `et_desc` text not null,
  `et_active` tinyint(3) NOT NULL default 1,
  PRIMARY KEY (`et_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
insert into system_events_types values (1, 'MessageBox', '115748', now(), 'Show text of event on the site', 1);
insert into system_events_types values (2, 'Email', '115748', now(), 'Send text of event by email', 1);
 
CREATE TABLE system_events_text (
  `te_id` int(7) unsigned not null auto_increment,
  `te_ev_id` int(7) unsigned not null,
  `te_user_id` int(9) unsigned NOT NULL default '0',
  `te_et_id` tinyint(3) NOT NULL default 0,
  `te_title` mediumtext NOT NULL,
  `te_content` text NOT NULL,
  `te_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`te_id`),
  KEY (`te_ev_id`, `te_et_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into system_events_text values (null, 1, 115748, '1', '', 'welcome_event_content', now());
insert into system_events_text values (null, 2, 115748, '1', '', 'create_user_page_visitor_msg', now());
insert into system_events_text values (null, 3, 115748, '1', '', 'user_can_vote_page_msg', now());
insert into system_events_text values (null, 4, 115748, '1', '', 'user_can_edit_page_evt', now());
insert into system_events_text values (null, 5, 115748, '1', '', 'watch_page_visitor_msg', now());
insert into system_events_text values (null, 6, 115748, '1', '', 'discuss_article_visitor_msg', now());
insert into system_events_text values (null, 7, 115748, '1', '', 'welcome_user_msg', now());
insert into system_events_text values (null, 8, 115748, '1', '', 'create_user_page_msg', now());
insert into system_events_text values (null, 9, 115748, '1', '', 'edit_page_msg', now());
insert into system_events_text values (null, 10, 115748, '1', '', 'sent_to_friend_msg', now());
insert into system_events_text values (null, 11, 115748, '1', '', 'discuss_article_user_msg', now());
insert into system_events_text values (null, 12, 115748, '1', '', 'create_article_msg', now());
insert into system_events_text values (null, 13, 115748, '1', '', 'watch_page_user_msg', now());
insert into system_events_text values (null, 14, 115748, '1', '', 'tag_image_msg', now());
insert into system_events_text values (null, 15, 115748, '1', '', 'flickr_promo_msg', now());

CREATE TABLE system_events_data (
  `ed_id` int(7) unsigned not null auto_increment,
  `ed_city_id` int(7) unsigned not null,
  `ed_ev_id` int(7) unsigned not null default 0,
  `ed_et_id` int(7) unsigned not null default 0,
  `ed_user_id` int(9) unsigned NOT NULL default '0',
  `ed_user_ip` varchar(20) NOT NULL default '',
  `ed_field_id` varchar(255) default '',
  `ed_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`ed_id`),
  KEY (`ed_city_id`),
  KEY (`ed_ev_id`, `ed_et_id`),
  KEY (`ed_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE system_events_params (
  `ep_id` int(7) unsigned not null auto_increment,
  `ep_name` varchar(100) NOT NULL default '',
  `ep_value` varchar(100) NOT NULL default '',
  `ep_desc` text default '',
  `ep_user_id` int(9) unsigned NOT NULL default '0',
  `ep_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ep_active` tinyint(3) NOT NULL default 1,
  PRIMARY KEY (`ep_id`),
  KEY (`ep_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
create index system_events_params_active on system_events_params(ep_active);

insert into system_events_params values (null, 'DisplayLength', '5', 'How much user\'s message should be visible on page', 0, now(), 1);
insert into system_events_params values (null, 'EmailsCount', '1', 'Number of emails that should be sent to user', 0, now(), 1);
insert into system_events_params values (null, 'TitleBold', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'TitleItalic', '1', '', 0, now(), 1);
insert into system_events_params values (null, 'TitleUnderline', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentBold', '1', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentItalic', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentUnderline', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'BackgroundColor', '#3366CC', '', 0, now(), 1);
insert into system_events_params values (null, 'LinkColor', '#FEC423', '', 0, now(), 1);
insert into system_events_params values (null, 'TextColor', '#FFFFFF', '', 0, now(), 1);

CREATE TABLE system_events_users (
  `eu_id` int(7) unsigned not null auto_increment,
  `eu_city_id` int(7) unsigned not null,
  `eu_ev_id` int(7) unsigned not null default 0,
  `eu_et_id` int(7) unsigned not null default 0,
  `eu_user_id` int(9) unsigned NOT NULL default '0',
  `eu_user_ip` varchar(20) NOT NULL default '',
  `eu_visible_count` int(5) default 0,
  `eu_active` int(5) default 1,
  `eu_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`eu_id`),
  KEY (`eu_city_id`),
  KEY (`eu_ev_id`, `eu_et_id`),
  KEY (`eu_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

global $wgSystemEventSetup; 
if (empty($wgSystemEventSetup))
{
	# some default values
	$wgSystemEventSetup = array (
		'DisplayLength' 	=> 5,
		'EmailsCount' 		=> 1,
		#---
		'TitleBold' 		=> false,
		'TitleItalic' 		=> false,
		'TitleUnderline'	=> false,
		#---
		'ContentBold' 		=> false,
		'ContentItalic' 	=> false,
		'ContentUnderline' 	=> false,
		#---
		'BackgroundColor' 	=> '',
		'LinkColor'			=> '',
		'TextColor'			=> '',
	);
}

global $wgSharedDB;
$dbname = (!isset($wgSharedDB)) ? "wgDBname" : "wgSharedDB";

define ('SYSTEM_EVENTS', 		"`".$$dbname."`.`system_events`");
define ('SYSTEM_EVENTS_TYPES', 	"`".$$dbname."`.`system_events_types`");
define ('SYSTEM_EVENTS_TEXT', 	"`".$$dbname."`.`system_events_text`");
define ('SYSTEM_EVENTS_DATA', 	"`".$$dbname."`.`system_events_data`");
define ('SYSTEM_EVENTS_USERS', 	"`".$$dbname."`.`system_events_users`");
define ('SYSTEM_EVENTS_PARAMS', "`".$$dbname."`.`system_events_params`");

#---
define ('MEMC_SETUP_KEY', 'wk-site-wide-events-setup::'.$$dbname);
define ('MEMC_SITE_WIDE_EVENTS_KEY', 'wk-generate-system-events::'.$$dbname);

// wikia events
require_once ( dirname( __FILE__ ) ."/SpecialWikiaEvents.php" );
#require_once ( dirname( __FILE__ ) ."/WikiaSiteEvents.php" );
require_once ( dirname( __FILE__ ) ."/WikiaEventsConditions.php");
// wikia events ajax functions
require_once ( dirname( __FILE__ ) ."/WikiaEvents_ajax.php" );
// wikia events API
global $wgAutoloadClasses; 
$wgAutoloadClasses["WikiaEventsApi"] = "extensions/wikia/WikiaEvents/WikiaEventsApi.php";
#--
global $wgApiQueryListModules;
$wgApiQueryListModules["wkevents"] = "WikiaEventsApi";

#---
$wgExtensionFunctions[] = 'wfGenerateSystemEvents';
$wgEnableSiteWideMessages = true;

function wfGenerateSystemEvents() 
{
	global $wgHooks, $wgSharedDB;
	global $wgMemc, $wgEnableSystemEvents;
	#---
	global $wgSystemEventSetup;
	global $wgMessageCache, $wgWikiaEventsMessages;

	# upper case of every element in tab
	function _ucfirst(&$elem, $value)
	{
		$elem = ucfirst($elem);
	}
		
	$data = array();

	wfProfileIn( __METHOD__ );

	if (empty($wgEnableSystemEvents))
	{
		wfProfileOut( __METHOD__ );
		return false;
	}

	require_once ( dirname( __FILE__ ) . '/WikiaEvents.i18n.php' );
	foreach( $wgWikiaEventsMessages as $key => $value ) 
	{
		$wgMessageCache->addMessages( $wgWikiaEventsMessages[$key], $key );
	}

	$time = 300;
	$data = $wgMemc->get(MEMC_SITE_WIDE_EVENTS_KEY);
	if (empty($data)) 
	{
		wfDebug( "Get wikia events from database\n" );
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'wfgenerateSystemEvents';

		$sql = "SELECT ev_id, ev_name, ev_hook from ".SYSTEM_EVENTS." where ev_active = 1";
		$res = $dbr->query($sql);

		#---
		while ( $row = $dbr->fetchObject( $res ) ) 
		{
			if ( (!empty($row->ev_hook)) && (!empty($row->ev_name)) )
			{
				#---
				$file_condition = $row->ev_name;
				$_tmp = preg_split("/[\s,]+/", $file_condition);
				if (!empty($_tmp) && is_array($_tmp) && count($_tmp)>1)
				{
					if (array_walk($_tmp, '_ucfirst'))
					{
						$file_condition = implode('', $_tmp);
					}					
				}
				#---
				// class name with event condition
				$conditionFile = $file_condition."Condition";
				#---
				$data[$row->ev_name] = array('hook' => $row->ev_hook, 'condition' => $conditionFile, 'event-id' => $row->ev_id, 'event-name' => $row->ev_name);
				#---
			}
		}
		$wgMemc->set(MEMC_SITE_WIDE_EVENTS_KEY, $data, $time);
		$dbr->freeResult ($res);
	} else {
		wfDebug( "Get wikia events from memcache\n" );
	}
	
	if (!empty($data))
	{
		foreach ($data as $event_name => $event_data)
		{
			$conditionFile = $event_data['condition'];
			if (file_exists(dirname( __FILE__ )."/conditions/".$conditionFile.".php"))
			{
				require_once dirname( __FILE__ )."/conditions/".$conditionFile.".php";
			}
			// for PHP < 5.2.0 is need call function
			$func_name = "wf".$conditionFile;
			$wgHooks[$event_data['hook']][] = array($func_name, $event_data['event-id']);
		}
	}
	
	#--- read configuration
	$time = 300;
	$setup = $wgMemc->get(MEMC_SETUP_KEY);
	if (empty($setup)) 
	{
		wfDebug( "Get wikia site-wite events setup from database\n" );
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'wfgenerateSystemEvents';

		$sql = "SELECT ep_id, ep_name, ep_value from ".SYSTEM_EVENTS_PARAMS." where ep_active = 1";
		$res = $dbr->query($sql);
	
		#---
		while ( $row = $dbr->fetchObject( $res ) ) 
		{
			$setup[$row->ep_name] = $row->ep_value;
		}
		$wgMemc->set(MEMC_SETUP_KEY, $setup, $time);
		$dbr->freeResult($res);
	} else {
		wfDebug( "Get wikia events from memcache\n" );
	}

	#---
	$wgSystemEventSetup	= $setup;

	wfProfileOut( __METHOD__ );
}

?>
